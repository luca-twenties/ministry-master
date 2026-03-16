<?php

namespace ChurchCRM\Utils;

final class StandaloneUtils
{
    private const DEFAULT_APP_NAME = 'ministry-master';

    public static function getAppName(): string
    {
        $name = getenv('CHURCHCRM_APP_NAME');
        if ($name === false || $name === null || trim($name) === '') {
            return self::DEFAULT_APP_NAME;
        }

        return trim((string) $name);
    }

    public static function getDataDir(): ?string
    {
        $override = getenv('CHURCHCRM_DATA_DIR');
        if ($override !== false && $override !== null && trim($override) !== '') {
            return rtrim(trim((string) $override), DIRECTORY_SEPARATOR);
        }

        $appName = self::getAppName();
        $osFamily = PHP_OS_FAMILY;

        if ($osFamily === 'Windows') {
            $base = getenv('APPDATA') ?: getenv('LOCALAPPDATA');
            if ($base === false || $base === null || trim($base) === '') {
                return null;
            }
            return rtrim((string) $base, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $appName;
        }

        $home = getenv('HOME');
        if ($home === false || $home === null || trim($home) === '') {
            return null;
        }

        if ($osFamily === 'Darwin') {
            return rtrim((string) $home, DIRECTORY_SEPARATOR)
                . DIRECTORY_SEPARATOR . 'Library'
                . DIRECTORY_SEPARATOR . 'Application Support'
                . DIRECTORY_SEPARATOR . $appName;
        }

        $xdg = getenv('XDG_DATA_HOME');
        if ($xdg !== false && $xdg !== null && trim($xdg) !== '') {
            return rtrim((string) $xdg, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $appName;
        }

        return rtrim((string) $home, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR . '.local'
            . DIRECTORY_SEPARATOR . 'share'
            . DIRECTORY_SEPARATOR . $appName;
    }

    public static function ensureDataDir(): ?string
    {
        $dir = self::getDataDir();
        if ($dir === null || $dir === '') {
            return null;
        }

        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        return is_dir($dir) ? $dir : null;
    }

    public static function getStandaloneConfigPath(?string $dataDir = null): ?string
    {
        $dataDir = $dataDir ?? self::getDataDir();
        if ($dataDir === null || $dataDir === '') {
            return null;
        }

        return rtrim($dataDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'Config.php';
    }

    public static function canGenerateConfigFromEnv(): bool
    {
        $driver = getenv('CHURCHCRM_DB_DRIVER');
        if ($driver !== false && $driver !== null && strtolower((string) $driver) === 'sqlite') {
            return true;
        }

        $required = [
            'CHURCHCRM_DB_NAME',
            'CHURCHCRM_DB_USER',
            'CHURCHCRM_DB_PASS',
        ];

        foreach ($required as $key) {
            $value = getenv($key);
            if ($value === false || $value === null || $value === '') {
                return false;
            }
        }

        return true;
    }

    public static function writeStandaloneConfig(string $path, array $values): void
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        $contents = self::buildStandaloneConfig($values);
        file_put_contents($path, $contents);
    }

    public static function buildStandaloneConfig(array $values): string
    {
        $server = $values['db_server'] ?? 'localhost';
        $port = $values['db_port'] ?? '3306';
        $user = $values['db_user'] ?? '';
        $pass = $values['db_password'] ?? '';
        $name = $values['db_name'] ?? '';
        $driver = $values['db_driver'] ?? 'mysql';
        $rootPath = $values['root_path'] ?? '';
        $url = $values['url'] ?? self::buildDefaultUrl($rootPath);
        $lockUrl = (bool) ($values['lock_url'] ?? false);

        return "<?php\n"
            . "// Auto-generated standalone config. Edit via setup or environment.\n"
            . "\$sSERVERNAME = " . self::phpString($server) . ";\n"
            . "\$dbPort = " . self::phpString($port) . ";\n"
            . "\$sUSER = " . self::phpString($user) . ";\n"
            . "\$sPASSWORD = " . self::phpString($pass) . ";\n"
            . "\$sDATABASE = " . self::phpString($name) . ";\n\n"
            . "\$sDATABASEDriver = " . self::phpString($driver) . ";\n\n"
            . "\$sRootPath = " . self::phpString($rootPath) . ";\n\n"
            . "\$bLockURL = " . ($lockUrl ? 'true' : 'false') . ";\n"
            . "\$URL = [];\n"
            . "\$URL[0] = " . self::phpString($url) . ";\n\n"
            . "error_reporting(E_ERROR);\n";
    }

    public static function buildDefaultUrl(string $rootPath): string
    {
        $host = getenv('CHURCHCRM_HOST');
        if ($host === false || $host === null || trim($host) === '') {
            $host = '127.0.0.1';
        }
        $host = trim((string) $host);

        $port = getenv('CHURCHCRM_PORT');
        if ($port !== false && $port !== null && trim($port) !== '') {
            $port = trim((string) $port);
            $base = "http://{$host}:{$port}";
        } else {
            $base = "http://{$host}";
        }

        if ($rootPath !== '' && $rootPath[0] !== '/') {
            $rootPath = '/' . $rootPath;
        }

        $url = rtrim($base, '/') . $rootPath;
        if ($url === '' || $url[-1] !== '/') {
            $url .= '/';
        }

        return $url;
    }

    private static function phpString(string $value): string
    {
        return var_export($value, true);
    }
}
