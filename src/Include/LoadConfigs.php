<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ChurchCRM\Bootstrapper;
use ChurchCRM\Utils\AppMode;
use ChurchCRM\Utils\StandaloneUtils;
use ChurchCRM\model\ChurchCRM\ConfigQuery;
use ChurchCRM\Utils\KeyManagerUtils;
use ChurchCRM\dto\SystemConfig;

/**
 * Safely loads Config.php with graceful handling for missing configuration.
 * Redirects to setup if Config.php doesn't exist.
 * This file should be used by all Slim application entry points.
 */
$configPath = __DIR__ . '/Config.php';
$standaloneConfigPath = null;

if (AppMode::isStandalone()) {
    $dataDir = StandaloneUtils::ensureDataDir();
    if ($dataDir !== null) {
        putenv('CHURCHCRM_DATA_DIR=' . $dataDir);
        $_ENV['CHURCHCRM_DATA_DIR'] = $dataDir;

        $standaloneConfigPath = StandaloneUtils::getStandaloneConfigPath($dataDir);
        if ($standaloneConfigPath !== null) {
            putenv('CHURCHCRM_CONFIG_PATH=' . $standaloneConfigPath);
            $_ENV['CHURCHCRM_CONFIG_PATH'] = $standaloneConfigPath;
        }
    }
}

$isStandalone = AppMode::isStandalone();

if ($isStandalone && $standaloneConfigPath !== null && !file_exists($standaloneConfigPath) && StandaloneUtils::canGenerateConfigFromEnv()) {
    $dbDriver = getenv('CHURCHCRM_DB_DRIVER') ?: 'mysql';
    $dbName = getenv('CHURCHCRM_DB_NAME') ?: '';
    if ($dbDriver === 'sqlite' && $dbName === '' && $dataDir !== null) {
        $dbName = $dataDir . DIRECTORY_SEPARATOR . 'churchcrm.sqlite';
    }
    StandaloneUtils::writeStandaloneConfig($standaloneConfigPath, [
        'db_server' => getenv('CHURCHCRM_DB_HOST') ?: 'localhost',
        'db_port' => getenv('CHURCHCRM_DB_PORT') ?: '3306',
        'db_user' => getenv('CHURCHCRM_DB_USER') ?: '',
        'db_password' => getenv('CHURCHCRM_DB_PASS') ?: '',
        'db_name' => $dbName,
        'db_driver' => $dbDriver,
        'root_path' => getenv('CHURCHCRM_ROOT_PATH') ?: '',
        'url' => getenv('CHURCHCRM_URL') ?: StandaloneUtils::buildDefaultUrl((string) (getenv('CHURCHCRM_ROOT_PATH') ?: '')),
        'lock_url' => getenv('CHURCHCRM_LOCK_URL') === '1',
    ]);
}

if ($isStandalone && $standaloneConfigPath !== null && file_exists($standaloneConfigPath)) {
    $configPath = $standaloneConfigPath;
} elseif (!file_exists($configPath) || $isStandalone) {
    header('Location: ../setup');
    exit;
}

require_once $configPath;

// Enable this line to debug the bootstrapper process (database connections, etc).
// this makes a lot of log noise, so don't leave it on for normal production use.
//$debugBootstrapper = true;
Bootstrapper::init($sSERVERNAME, $dbPort, $sUSER, $sPASSWORD, $sDATABASE, $sRootPath, $bLockURL, $URL);

if (!SystemConfig::isInitialized()) {
    SystemConfig::init(ConfigQuery::create()->find());
}

// Ensure config_cfg is seeded with any missing required defaults.
// This makes first-run resilient even if install/upgrade scripts didn't populate config_cfg.
try {
    // Only seed a minimal, high-impact set of defaults which are required for normal operation.
    // These are idempotent because ConfigItem::setValue() persists only when non-default.
    $requiredDefaults = [
        'sLogLevel' => '200',
        'iSessionTimeout' => '3600',
        'iMaxFailedLogins' => '5',
        'bEnableLostPassword' => '1',
        'bEnabledFinance' => '1',
        'bEnabledSundaySchool' => '1',
        'bEnabledEvents' => '1',
        'bEnabledFundraiser' => '1',
        'bEnabledEmail' => '1',
        'sLanguage' => 'en_US',
    ];
    foreach ($requiredDefaults as $key => $defaultValue) {
        if (SystemConfig::getValue($key) === '') {
            SystemConfig::setValue($key, $defaultValue);
        }
    }
} catch (\Throwable $e) {
    // Intentionally ignore: if DB isn't ready yet, bootstrap will handle it elsewhere.
}

// Initialize KeyManager with 2FA secret from SystemConfig
$twoFASecretKey = SystemConfig::getValue('sTwoFASecretKey');

// Auto-generate encryption key if not yet set (required for 2FA enrollment)
if (empty($twoFASecretKey)) {
    $twoFASecretKey = bin2hex(random_bytes(32));
    SystemConfig::setValue('sTwoFASecretKey', $twoFASecretKey);
}

KeyManagerUtils::init($twoFASecretKey);
