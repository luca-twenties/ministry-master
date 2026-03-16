<?php

namespace ChurchCRM;

use ChurchCRM\Authentication\AuthenticationManager;
use ChurchCRM\dto\LocaleInfo;
use ChurchCRM\dto\SystemConfig;
use ChurchCRM\dto\SystemURLs;
use ChurchCRM\model\ChurchCRM\ConfigQuery;
use ChurchCRM\model\ChurchCRM\Version;
use ChurchCRM\Service\SystemService;
use ChurchCRM\Utils\InputUtils;
use ChurchCRM\Utils\LoggerUtils;
use ChurchCRM\Utils\AppMode;
use ChurchCRM\Utils\RedirectUtils;
use ChurchCRM\Utils\SQLUtils;
use ChurchCRM\Utils\VersionUtils;
use ChurchCRM\Utils\FiscalYearUtils;
use ChurchCRM\model\ChurchCRM\Person;
use ChurchCRM\model\ChurchCRM\User;
use ChurchCRM\model\ChurchCRM\UserQuery;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Propel\Runtime\Connection\ConnectionManagerSingle;
use Propel\Runtime\Connection\ConnectionWrapper;
use Propel\Runtime\Connection\DebugPDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ServiceContainer\ServiceContainerInterface;

class Bootstrapper
{
    // Constants for magic values
    private const DEFAULT_MYSQL_PORT = 3306;
    private const DEFAULT_DB_DRIVER = 'mysql';
    private const LOCALE_DOMAIN = 'messages';
    private const SESSION_PREFIX = 'CRM-';
    private const DEFAULT_CHARSET = 'utf8mb4';
    private const PROPEL_CONFIG_VERSION = 2; // Perpl ORM configuration version
    private const LOCALHOST_IDENTIFIER = 'localhost';
    
    private static ?ConnectionManagerSingle $manager = null;
    private static ?string $dbClassName = null;
    private static ?string $databaseServerName = null;
    private static ?int $databasePort = null;
    private static ?string $databaseUser = null;
    private static ?string $databasePassword = null;
    private static ?string $databaseName = null;
    private static ?string $rootPath = null;
    private static ?bool $lockURL = null;
    private static ?array $allowableURLs = null;
    private static ?string $databaseDriver = null;

    private static ?Logger $bootStrapLogger = null;
    private static ?ServiceContainerInterface $serviceContainer = null;
    private static bool $initialized = false;

    /**
     * Initialize the ChurchCRM system
     * 
     * @param string $sSERVERNAME Database server hostname
     * @param string|int|null $dbPort Database server port (defaults to 3306)
     * @param string $sUSER Database username
     * @param string $sPASSWORD Database password
     * @param string $sDATABASE Database name
     * @param string $sRootPath Application root path
     * @param bool $bLockURL Whether to enforce URL restrictions
     * @param array $URL Array of allowed URLs
     * 
     * @throws \InvalidArgumentException If required parameters are empty
     */
    public static function init(string $sSERVERNAME, $dbPort, string $sUSER, string $sPASSWORD, string $sDATABASE, string $sRootPath, bool $bLockURL, array $URL): void
    {
        // Prevent double initialization
        if (self::$initialized) {
            return;
        }
        
        global $debugBootstrapper;
        
        // Set default timezone before any logging to ensure consistent log file naming
        date_default_timezone_set('UTC');
        // Validate required parameters
        self::validateInitParameters($sSERVERNAME, $sUSER, $sPASSWORD, $sDATABASE, $sRootPath);
        
        self::$databaseServerName = $sSERVERNAME;
        self::$databaseUser = $sUSER;
        self::$databasePassword = $sPASSWORD;
        self::$databasePort = self::normalizePort($dbPort);
        self::$databaseName = $sDATABASE;
        self::$rootPath = $sRootPath;
        self::$lockURL = $bLockURL;
        self::$allowableURLs = $URL;
        self::$databaseDriver = self::resolveDatabaseDriver();

        try {
            SystemURLs::init($sRootPath, $URL, dirname(__DIR__));
            // Debug: Output document root and log path
            $docRoot = SystemURLs::getDocumentRoot();
            $logPath = LoggerUtils::buildLogFilePath('debug');
            error_log("[Bootstrap Debug] DocumentRoot: $docRoot, LogPath: $logPath");
        } catch (\Exception $e) {
            self::handleBootstrapFailure($e, 'SystemURLs initialization failed');
        }
        if ($debugBootstrapper) {
            self::$bootStrapLogger = LoggerUtils::getAppLogger(Level::Debug->value);
        } else {
            self::$bootStrapLogger = LoggerUtils::getAppLogger(Level::Info->value);
        }

        self::$bootStrapLogger->debug("Starting ChurchCRM");
        SystemURLs::checkAllowedURL($bLockURL, $URL);
        if (self::$databaseDriver === 'sqlite') {
            if (getenv('CHURCHCRM_SQLITE_EXPERIMENTAL') !== '1') {
                self::systemFailure('SQLite support is experimental and disabled. Set CHURCHCRM_SQLITE_EXPERIMENTAL=1 to enable it.', 'SQLite Disabled');
            }
        } else {
            self::initMySQLI();
        }
        self::initPropel();

        if (self::isDatabaseEmpty()) {
            self::installChurchCRMSchema();
        }
        self::initSession();
        
        // Initialize SystemConfig with database values only once during bootstrap
        // Fallback error handlers (testMYSQLI, systemFailure) will call init() without parameters
        if (!SystemConfig::isInitialized()) {
            SystemConfig::init(ConfigQuery::create()->find());
        }
        self::ensureStandaloneAdminUser();
        
        self::configureLogging();
        self::configureUserEnvironment();
        self::configureLocale();
        if (!self::isDBCurrent()) {
            // If we just ran the DB upgrade, avoid immediately redirecting back (prevents redirect loop)
            if (session_status() !== PHP_SESSION_ACTIVE) {
                @session_start();
            }
            if (!empty($_SESSION['dbUpgradeJustRan'])) {
                unset($_SESSION['dbUpgradeJustRan']);
                self::$bootStrapLogger->info('Database upgrade just ran; skipping immediate redirect to upgrade page.');
            } else {
                // Minimal, robust check to avoid redirect loops when already on the external upgrade page
                $requestUri = $_SERVER['REQUEST_URI'] ?? $_SERVER['SCRIPT_NAME'] ?? '';
                $isOnUpgradePage = (strpos($requestUri, '/external/system') !== false);

                if (!$isOnUpgradePage) {
                    self::$bootStrapLogger->info("Database is not current, redirecting to external/system/db-upgrade");
                    RedirectUtils::redirect('external/system/db-upgrade');
                } else {
                    self::$bootStrapLogger->debug("Database is not current, not redirecting to SystemDBUpdate since we're already on it");
                }
            }
        }
        LoggerUtils::resetAppLoggerLevel();
        
        // Mark as initialized
        self::$initialized = true;
    }
    
    /**
     * Validates required initialization parameters
     * Note: rootPath can be empty string for top-level installations, so we don't validate it
     */
    private static function validateInitParameters(string $serverName, string $user, string $password, string $database, string $rootPath): void
    {
        $dbDriver = strtolower((string) (getenv('CHURCHCRM_DB_DRIVER') ?: (self::$databaseDriver ?? self::DEFAULT_DB_DRIVER)));
        $isSqlite = $dbDriver === 'sqlite';

        if (!$isSqlite && empty($serverName)) {
            throw new \InvalidArgumentException('Database server name cannot be empty');
        }
        if (!$isSqlite && empty($user)) {
            throw new \InvalidArgumentException('Database user cannot be empty');
        }
        if (!$isSqlite && empty($password)) {
            throw new \InvalidArgumentException('Database password cannot be empty');
        }
        if (empty($database)) {
            throw new \InvalidArgumentException('Database name cannot be empty');
        }
        // rootPath validation: empty string is valid for top-level installations
        // Only check for obviously invalid values
        if (trim($rootPath) !== $rootPath) {
            throw new \InvalidArgumentException('Root path cannot have leading or trailing whitespace');
        }
    }
    
    /**
     * Handles bootstrap failures with proper logging and error display
     */
    private static function handleBootstrapFailure(\Exception $e, string $context = 'Bootstrap failure'): void
    {
        // Log the error if logger is available
        if (self::$bootStrapLogger) {
            self::$bootStrapLogger->error("Bootstrap failure in {$context}: " . $e->getMessage(), [
                'exception' => $e,
                'context' => $context
            ]);
        }
        
        // Display error to user
        self::systemFailure($e->getMessage(), $context);
    }
    
    /**
     * Normalize port number from mixed types to integer
     * 
     * @param string|int|null $port Port number in various formats
     * @return int Normalized port number
     */
    private static function normalizePort($port): int
    {
        if ($port === null || $port === '') {
            return self::DEFAULT_MYSQL_PORT;
        }
        
        if (is_string($port)) {
            $port = trim($port);
            if ($port === '') {
                return self::DEFAULT_MYSQL_PORT;
            }
            $port = (int)$port;
        }
        
        if (!is_int($port) || $port <= 0 || $port > 65535) {
            return self::DEFAULT_MYSQL_PORT;
        }
        
        return $port;
    }
    
    /**
     * Check if the bootstrapper has been initialized
     * 
     * @return bool True if initialized, false otherwise
     */
    public static function isInitialized(): bool
    {
        return self::$initialized;
    }
    
    /**
     * Get the current bootstrap logger
     * 
     * @return Logger|null The logger instance or null if not initialized
     */
    public static function getLogger(): ?Logger
    {
        return self::$bootStrapLogger;
    }
    /**
     * Gets a LocaleInfo object for the currently configured system sLanguage
     * 
     * @return LocaleInfo Current locale information
     */
    public static function getCurrentLocale(): LocaleInfo
    {
        $userLocale = "";
        try {
            $userLocale =  AuthenticationManager::getCurrentUser()->getSetting("ui.locale");
        } catch (\Exception $ex) {
            //maybe user is logged in
        }
        return new LocaleInfo(SystemConfig::getValue('sLanguage'), $userLocale);
    }

    /**
     * Configure locale settings with proper error handling
     */
    private static function configureLocale(): void
    {
        global $aLocaleInfo, $localeInfo;
        
        try {
            // Configure timezone
            $timezone = SystemConfig::getValue('sTimeZone');
            if ($timezone) {
                self::$bootStrapLogger->debug("Setting TimeZone to: " . $timezone);
                date_default_timezone_set($timezone);
            }

            // Get locale information
            $localeInfo = self::getCurrentLocale();
            self::$bootStrapLogger->debug("Setting locale to: " . $localeInfo->getLocale());
            
            // Set locale with fallback options
            $localeSet = setlocale(LC_ALL, 
                $localeInfo->getLocale(), 
                $localeInfo->getLocale() . '.UTF-8', 
                $localeInfo->getLocale() . '.utf8'
            );
            
            if ($localeSet === false) {
                self::$bootStrapLogger->warning("Failed to set locale: " . $localeInfo->getLocale() . ", using system default");
            }

            // Get numeric and monetary locale settings
            $aLocaleInfo = $localeInfo->getLocaleInfo();

            // This is needed to avoid some bugs in various libraries like fpdf
            // http://www.velanhotels.com/fpdf/FAQ.htm#6
            setlocale(LC_NUMERIC, 'C');

            // Configure text domain
            $domain = self::LOCALE_DOMAIN;
            $sLocaleDir = SystemURLs::getDocumentRoot() . '/locale/textdomain';
            self::$bootStrapLogger->debug("Setting local text domain bind to: " . $sLocaleDir);
            
            if (!is_dir($sLocaleDir)) {
                self::$bootStrapLogger->warning("Locale directory does not exist: " . $sLocaleDir);
            }
            
            bind_textdomain_codeset($domain, 'UTF-8');
            bindtextdomain($domain, $sLocaleDir);
            textdomain($domain);
            self::$bootStrapLogger->debug("Locale configuration complete");
            
        } catch (\Exception $e) {
            self::$bootStrapLogger->error("Locale configuration failed: " . $e->getMessage());
            // Continue with default locale settings
        }
    }

    /**
     * Initialize MySQLi connection with proper error handling
     */
    private static function initMySQLI(): void
    {
        global $cnInfoCentral; // need to stop using this everywhere....
        self::$bootStrapLogger->debug("Initializing MySQLi to " . self::$databaseServerName . " as " . self::$databaseUser);
        // Due to mysqli handling connections on 'localhost' via socket only, we need to tease out this case and handle
        // TCP/IP connections separately defaulting self::$databasePort to 3306 for the general case when self::$databasePort is not set.
        if (self::$databaseServerName === self::LOCALHOST_IDENTIFIER) {
            self::$bootStrapLogger->debug("Connecting to localhost with no port");
            $cnInfoCentral = mysqli_connect(self::$databaseServerName, self::$databaseUser, self::$databasePassword);
        } else {
            if (!isset(self::$databasePort)) {
                self::$bootStrapLogger->debug("MySQL connection did not specify a port. Using " . self::DEFAULT_MYSQL_PORT . " as default");
                self::$databasePort = self::DEFAULT_MYSQL_PORT;
            }
            // Connect via TCP to specified port and pass a 'null' for database name.
            // We specify the database name in a different call, ie 'mysqli_select_db()' just below here
            self::$bootStrapLogger->debug("Connecting to " . self::$databaseServerName . " on port " . self::$databasePort . " as " . self::$databaseUser);
            try {
                $cnInfoCentral = mysqli_connect(self::$databaseServerName, self::$databaseUser, self::$databasePassword, null, self::$databasePort);
            } catch (\Exception $e) {
                self::handleBootstrapFailure($e, 'Database connection failed');
            }
        }
        self::testMYSQLI();
        mysqli_set_charset($cnInfoCentral, self::DEFAULT_CHARSET);

        self::$bootStrapLogger->debug("Selecting database: " . self::$databaseName);
        try {
            if (!mysqli_select_db($cnInfoCentral, self::$databaseName)) {
                self::systemFailure('Could not select the MySQL database <strong>' . self::$databaseName . '</strong>. Please check the settings in <strong>Include/Config.php</strong>.<br/>MySQL Error: ' . mysqli_error($cnInfoCentral));
            }
        } catch (\mysqli_sql_exception $e) {
            self::systemFailure('Could not access the MySQL database <strong>' . self::$databaseName . '</strong>. Please verify the database name in <strong>Include/Config.php</strong>.<br/>Error: ' . $e->getMessage());
        }
        self::$bootStrapLogger->debug("Database selected: " . self::$databaseName);
    }
    
    private static function resolveDatabaseDriver(): string
    {
        $driver = getenv('CHURCHCRM_DB_DRIVER');
        if ($driver === false || $driver === null || trim($driver) === '') {
            if (isset($GLOBALS['sDATABASEDriver'])) {
                $driver = $GLOBALS['sDATABASEDriver'];
            }
        }

        if ($driver === null || $driver === false || trim((string) $driver) === '') {
            return self::DEFAULT_DB_DRIVER;
        }

        $driver = strtolower(trim((string) $driver));
        if ($driver === 'sqlite') {
            return 'sqlite';
        }

        return self::DEFAULT_DB_DRIVER;
    }
    private static function testMYSQLI(): void
    {
        global $cnInfoCentral; // need to stop using this everywhere....
        // Do we have a connection to the database? If not, log it and tell the user
        if (!$cnInfoCentral) {
            // Sanitise the mysqli_connect_error if required.
            $sMYSQLERROR = "none captured";
            if (strlen(mysqli_connect_error()) > 0) {
                $sMYSQLERROR = mysqli_connect_error();
            }
            // If connecting via a socket, note this for logging (don't change the port value)
            $portDisplay = (self::$databaseServerName === self::LOCALHOST_IDENTIFIER) ? "Unix socket" : (string)self::$databasePort;
            // Need to initialise otherwise logging etc will fail!
            if (!SystemConfig::isInitialized()) {
                SystemConfig::init();
            }
            // Log the error to the application log, and show an error page to user.
            LoggerUtils::getAppLogger()->error("ERROR connecting to database at '" . self::$databaseServerName . "' on port '" . $portDisplay . "' as user '" . self::$databaseUser . "' -  MySQL Error: '" . $sMYSQLERROR . "'");
            self::systemFailure('Could not connect to MySQL on <strong>' . self::$databaseServerName . '</strong> on port <strong>' . $portDisplay . '</strong> as <strong>' . self::$databaseUser . '</strong>. Please check the settings in <strong>Include/Config.php</strong>.<br/>MySQL Error: ' . $sMYSQLERROR, 'Database Connection Failure');
        }
    }
    private static function initPropel(): void
    {
        self::$bootStrapLogger->debug("Initializing Propel ORM");
        // ==== ORM
        self::$dbClassName = '\\' . ConnectionWrapper::class;
        self::$serviceContainer = Propel::getServiceContainer();
        self::$serviceContainer->checkVersion(self::PROPEL_CONFIG_VERSION);
        self::$serviceContainer->setAdapterClass('default', self::$databaseDriver ?? self::DEFAULT_DB_DRIVER);
        self::$manager = new ConnectionManagerSingle('default');
        self::$manager->setConfiguration(self::buildConnectionManagerConfig());
        self::$serviceContainer->setConnectionManager(self::$manager);
        self::$serviceContainer->setDefaultDatasource('default');
        // Load database map from Include directory (Perpl ORM requirement)
        require_once __DIR__ . '/../Include/LoadDatabaseMap.php';
        self::$bootStrapLogger->debug("Initialized Propel ORM");
    }
    private static function isDatabaseEmpty(): bool
    {
        self::$bootStrapLogger->debug("Checking for ChurchCRM Database tables");
        try {
            $connection = Propel::getConnection();
            if (self::$databaseDriver === 'sqlite') {
                $query = "SELECT name FROM sqlite_master WHERE type='table'";
            } else {
                $query = "SHOW TABLES FROM `" . self::$databaseName . "`";
            }
            $statement = $connection->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            if (count($results) === 0) {
                self::$bootStrapLogger->debug("No database tables found");
                return true;
            }
            self::$bootStrapLogger->debug("Found " . count($results) . " Database tables");
            return false;
        } catch (\PDOException $e) {
            self::$bootStrapLogger->error("Database check failed: " . $e->getMessage());
            self::systemFailure('Could not access the MySQL database <strong>' . self::$databaseName . '</strong>. Please check the settings in <strong>Include/Config.php</strong>.<br/>Error: ' . $e->getMessage());
            return true; // This line won't be reached due to systemFailure() calling exit()
        }
    }
    private static function installChurchCRMSchema(): void
    {
        self::$bootStrapLogger->info("Installing ChurchCRM Schema");
        $connection = Propel::getConnection();
        $version = new Version();
        $version->setVersion(VersionUtils::getInstalledVersion());
        $version->setUpdateStart(new \DateTime());
        $installFile = SystemURLs::getDocumentRoot() . '/mysql/install/Install.sql';
        if (self::$databaseDriver === 'sqlite') {
            $installFile = SystemURLs::getDocumentRoot() . '/sqlite/install/Install.sql';
        }
        if (!file_exists($installFile)) {
            self::systemFailure('Database install file is missing: ' . $installFile, 'Database Install Failure');
        }
        SQLUtils::sqlImport($installFile, $connection);
        $version->setUpdateEnd(new \DateTime());
        $version->save();
        self::$bootStrapLogger->info("Installed ChurchCRM Schema version: " . VersionUtils::getInstalledVersion());
    }

    private static function ensureStandaloneAdminUser(): void
    {
        if (!AppMode::isStandalone() && self::$databaseDriver !== 'sqlite') {
            return;
        }

        try {
            $username = getenv('CHURCHCRM_STANDALONE_ADMIN_USER') ?: 'Admin';
            $password = getenv('CHURCHCRM_STANDALONE_ADMIN_PASSWORD');

            $user = UserQuery::create()->findOneByUserName($username);
            if ($user !== null) {
                // Ensure account is unlocked and has admin privileges
                $user
                    ->setAdmin(true)
                    ->setAddRecords(true)
                    ->setEditRecords(true)
                    ->setDeleteRecords(true)
                    ->setMenuOptions(true)
                    ->setManageGroups(true)
                    ->setFinance(true)
                    ->setNotes(true)
                    ->setEditSelf(true)
                    ->setFailedLogins(0)
                    ->setNeedPasswordChange(false);
                if ($password !== false && $password !== null && $password !== '') {
                    $user->updatePassword($password);
                }
                $user->save();
                return;
            }

            if (UserQuery::create()->count() > 0) {
                return;
            }

            $password = ($password !== false && $password !== null && $password !== '') ? $password : 'admin';

            $person = new Person();
            $person
                ->setFirstName('Church')
                ->setLastName('Admin')
                ->setClsId(1);
            $person->save();

            $user = new User();
            $user
                ->setPersonId($person->getId())
                ->setUserName($username)
                ->setAdmin(true)
                ->setAddRecords(true)
                ->setEditRecords(true)
                ->setDeleteRecords(true)
                ->setMenuOptions(true)
                ->setManageGroups(true)
                ->setFinance(true)
                ->setNotes(true)
                ->setEditSelf(true)
                ->setDefaultFY(FiscalYearUtils::getCurrentFiscalYearId())
                ->setNeedPasswordChange(true)
                ->setLastLogin(date('Y-m-d H:i:s'));
            $user->updatePassword($password);
            $user->save();

            if (self::$bootStrapLogger) {
                self::$bootStrapLogger->info('Standalone admin user created');
            }
        } catch (\Throwable $e) {
            if (self::$bootStrapLogger) {
                self::$bootStrapLogger->error('Failed to auto-create standalone admin user', ['exception' => $e]);
            }
        }
    }
    /**
     * Initialize PHP session with secure settings
     */
    public static function initSession(): void
    {
        // Initialize the session
        $sessionName = self::SESSION_PREFIX . hash("md5", SystemURLs::getDocumentRoot());
        if (AppMode::isStandalone()) {
            $dataDir = getenv('CHURCHCRM_DATA_DIR');
            if ($dataDir !== false && $dataDir !== null && trim((string) $dataDir) !== '') {
                $sessionDir = rtrim((string) $dataDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'sessions';
                if (!is_dir($sessionDir)) {
                    @mkdir($sessionDir, 0700, true);
                }
                if (is_dir($sessionDir) && is_writable($sessionDir)) {
                    ini_set('session.save_path', $sessionDir);
                }
            }

            $lifetime = getenv('CHURCHCRM_SESSION_LIFETIME');
            $cookieLifetime = ($lifetime !== false && is_numeric($lifetime)) ? (int) $lifetime : 60 * 60 * 24 * 30;
            if ($cookieLifetime < 0) {
                $cookieLifetime = 0;
            }

            ini_set('session.gc_maxlifetime', (string) $cookieLifetime);
            $cookieParams = session_get_cookie_params();
            $cookieParams['lifetime'] = $cookieLifetime;
            $cookieParams['httponly'] = true;
            $cookieParams['secure'] = false;
            if (!isset($cookieParams['samesite']) || $cookieParams['samesite'] === '') {
                $cookieParams['samesite'] = 'Lax';
            }
            ini_set('session.cookie_lifetime', (string) $cookieLifetime);
            ini_set('session.cookie_secure', '0');
            ini_set('session.cookie_httponly', '1');
            ini_set('session.use_only_cookies', '1');
            session_set_cookie_params($cookieParams);
        }
        \session_cache_limiter('private_no_expire:');
        \session_name($sessionName);
        \session_start();
        self::$bootStrapLogger->debug("Session initialized: " . $sessionName);
        
        // Cache the installed version in the session (only once per session)
        if (!isset($_SESSION['sSoftwareInstalledVersion'])) {
            $_SESSION['sSoftwareInstalledVersion'] = VersionUtils::getInstalledVersion();
        }
    }
    private static function configureLogging(): void
    {
        // PHP Logs
        $phpLogPath = LoggerUtils::buildLogFilePath("php");
        self::$bootStrapLogger->debug("Configuring PHP logs at :" . $phpLogPath);
        ini_set('log_errors', 1);
        ini_set('error_log', $phpLogPath);

        // ORM Logs - only enabled when BOTH debug mode is on AND log level is DEBUG.
        // Root cause: Propel's ConnectionWrapper::log() hardcodes $logger->info()
        // for every SQL query - the level is not configurable from outside.
        // Fix: a processor remaps every INFO record to DEBUG before it hits the handler,
        // so ORM queries are correctly classified as DEBUG-level entries.
        if (SystemConfig::debugEnabled() && LoggerUtils::isDebugLogLevel()) {
            $ormLogPath = LoggerUtils::buildLogFilePath("orm");
            $ormLogger = new Logger('ormLogger');
            self::$bootStrapLogger->debug("Configuring ORM logs at :" . $ormLogPath);
            self::$dbClassName = '\\' . DebugPDO::class;
            self::$manager->setConfiguration(self::buildConnectionManagerConfig());

            // Remap INFO → DEBUG: Propel hardcodes ->info() for all SQL queries.
            // Without this, every SQL entry appears as INFO regardless of log level config.
            $ormLogger->pushProcessor(function (\Monolog\LogRecord $record): \Monolog\LogRecord {
                if ($record->level === Level::Info) {
                    return new \Monolog\LogRecord(
                        datetime: $record->datetime,
                        channel: $record->channel,
                        level: Level::Debug,
                        message: $record->message,
                        context: $record->context,
                        extra: $record->extra,
                    );
                }
                return $record;
            });

            $ormLogger->pushHandler(new StreamHandler($ormLogPath, Level::Debug->value));
            self::$serviceContainer->setLogger('defaultLogger', $ormLogger);
        }
    }

    /**
     * Generate database DSN string
     * 
     * @return string Database connection string
     */
    public static function getDSN(): string
    {
        if (self::$databaseDriver === 'sqlite') {
            $dbPath = self::$databaseName;
            if ($dbPath === null || $dbPath === '') {
                return 'sqlite::memory:';
            }
            if ($dbPath !== ':memory:' && $dbPath[0] !== DIRECTORY_SEPARATOR) {
                $dbPath = SystemURLs::getDocumentRoot() . DIRECTORY_SEPARATOR . $dbPath;
            }
            return 'sqlite:' . $dbPath;
        }

        return 'mysql:host=' . self::$databaseServerName . ';port=' . self::$databasePort . ';dbname=' . self::$databaseName;
    }

    private static function buildConnectionManagerConfig(): array
    {
        if (self::$databasePort === null) {
            self::$databasePort = self::DEFAULT_MYSQL_PORT;
        }
        $config = [
            'dsn' => Bootstrapper::getDSN(),
            'user' => self::$databaseUser,
            'password' => self::$databasePassword,
            'classname' => self::$dbClassName,
            'model_paths' => [
                0 => 'src',
                1 => 'vendor',
            ],
        ];

        if (self::$databaseDriver !== 'sqlite') {
            $config['settings'] = [
                'charset' => self::DEFAULT_CHARSET,
                'queries' => ["SET sql_mode=(SELECT REPLACE(REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''),'NO_ZERO_DATE',''))"],
            ];
        }

        return $config;
    }

    private static function configureUserEnvironment(): void
    {
        global $cnInfoCentral;
        if (AuthenticationManager::validateUserSessionIsActive(false)) { // set on POST to /session/begin
            // Load user variables from user config table.
            $sSQL = 'SELECT ucfg_name, ucfg_value AS value '
            . "FROM userconfig_ucfg WHERE ucfg_per_ID='" . AuthenticationManager::getCurrentUser()->getId() . "'";
            if (self::$databaseDriver === 'sqlite') {
                $connection = Propel::getConnection();
                $statement = $connection->prepare($sSQL);
                $statement->execute();
                $rows = $statement->fetchAll(\PDO::FETCH_NUM);
                if (!isset($_SESSION['user_config'])) {
                    $_SESSION['user_config'] = [];
                }
                foreach ($rows as $row) {
                    [$ucfg_name, $value] = $row;
                    $_SESSION['user_config'][$ucfg_name] = $value;
                    $_SESSION[$ucfg_name] = $value; // Keep for backward compatibility until all references are updated
                }
            } else {
                $rsConfig = mysqli_query($cnInfoCentral, $sSQL);     // Can't use RunQuery -- not defined yet
                if ($rsConfig) {
                    // Initialize user config array if not exists
                    if (!isset($_SESSION['user_config'])) {
                        $_SESSION['user_config'] = [];
                    }
                    
                    while ([$ucfg_name, $value] = mysqli_fetch_row($rsConfig)) {
                        // Store user configuration safely in session array
                        // This replaces the dangerous variable-variables pattern
                        $_SESSION['user_config'][$ucfg_name] = $value;
                        $_SESSION[$ucfg_name] = $value; // Keep for backward compatibility until all references are updated
                    }
                }
            }
        }
    }

    public static function systemFailure($message, $header = 'Setup failure'): void
    {
        // Clear any output buffers to ensure error message is displayed
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // Set HTTP status code
        http_response_code(500);
        
        $sPageTitle = $header;
        if (!SystemConfig::isInitialized()) {
            SystemConfig::init();
        }
        
        try {
            $headerPath = SystemURLs::getDocumentRoot() . '/Include/HeaderNotLoggedIn.php';
            $footerPath = SystemURLs::getDocumentRoot() . '/Include/FooterNotLoggedIn.php';
            
            if (file_exists($headerPath)) {
                require_once $headerPath;
            } else {
                // Fallback to basic HTML header
                echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>ChurchCRM - Error</title></head><body>';
            }
            ?>
    <div class='container'>
        <h3>ChurchCRM – <?= _($header) ?></h3>
        <div class='alert alert-danger text-center'>
            <?= gettext($message) ?>
        </div>
    </div>
            <?php
            if (file_exists($footerPath)) {
                require_once $footerPath;
            } else {
                echo '</body></html>';
            }
        } catch (\Exception $e) {
            // Last resort: plain HTML error if header/footer includes fail
            echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>ChurchCRM Error</title></head><body>';
            echo '<div style="max-width: 800px; margin: 50px auto; padding: 20px;">';
            echo '<h1>ChurchCRM Error</h1>';
            echo '<div style="padding: 15px; margin: 20px 0; border: 1px solid #f5c6cb; background-color: #f8d7da; color: #721c24; border-radius: 4px;">';
            echo InputUtils::escapeHTML($message);
            echo '</div></div></body></html>';
        }
        exit();
    }
    public static function isDBCurrent(): bool
    {
        $dbVersion = VersionUtils::getDBVersion();
        $installVersion = VersionUtils::getInstalledVersion();
        self::$bootStrapLogger->debug("Checking versions: " . $dbVersion . " == " . $installVersion);
        return $dbVersion == $installVersion;
    }
}
