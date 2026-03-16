<?php

namespace ChurchCRM\Service;

use Propel\Runtime\Propel;

final class DoctorService
{
    /**
     * Run diagnostic checks and return a structured report.
     *
     * @return array<string, mixed>
     */
    public static function run(): array
    {
        $checks = [];
        $ok = true;

        $requiredExtensions = [
            'bcmath',
            'curl',
            'gd',
            'intl',
            'mbstring',
            'mysqli',
            'pdo',
            'pdo_mysql',
            'zip',
        ];

        $extensions = [];
        foreach ($requiredExtensions as $name) {
            $loaded = extension_loaded($name);
            $extensions[$name] = $loaded;
            if (!$loaded) {
                $ok = false;
            }
        }

        $checks['php'] = [
            'version' => PHP_VERSION,
            'sapi' => PHP_SAPI,
            'extensions' => $extensions,
        ];

        $driver = getenv('CHURCHCRM_DB_DRIVER');
        if ($driver === false || $driver === null || trim($driver) === '') {
            $driver = $GLOBALS['sDATABASEDriver'] ?? 'mysql';
        }
        $checks['databaseDriver'] = strtolower(trim((string) $driver));

        $checks['paths'] = [
            'configPath' => getenv('CHURCHCRM_CONFIG_PATH') ?: null,
            'dataDir' => getenv('CHURCHCRM_DATA_DIR') ?: null,
        ];

        $db = [
            'connected' => false,
            'error' => null,
            'tables' => [
                'config_cfg' => null,
                'version_ver' => null,
            ],
        ];

        try {
            $cn = Propel::getConnection();
            $db['connected'] = true;

            $stmt = $cn->prepare('SELECT COUNT(*) FROM config_cfg');
            $stmt->execute();
            $db['tables']['config_cfg'] = (int) $stmt->fetchColumn();

            $stmt = $cn->prepare('SELECT COUNT(*) FROM version_ver');
            $stmt->execute();
            $db['tables']['version_ver'] = (int) $stmt->fetchColumn();

            if ($db['tables']['config_cfg'] === 0 || $db['tables']['version_ver'] === 0) {
                $ok = false;
            }
        } catch (\Throwable $e) {
            $ok = false;
            $db['error'] = $e->getMessage();
        }

        $checks['database'] = $db;

        return [
            'ok' => $ok,
            'generatedAt' => gmdate('c'),
            'checks' => $checks,
        ];
    }

    public static function renderText(array $report): string
    {
        $lines = [];
        $lines[] = 'Doctor Report';
        $lines[] = 'Status: ' . (($report['ok'] ?? false) ? 'OK' : 'FAIL');
        if (!empty($report['generatedAt'])) {
            $lines[] = 'Generated: ' . $report['generatedAt'];
        }
        $lines[] = '';

        $php = $report['checks']['php'] ?? [];
        $lines[] = 'PHP';
        $lines[] = '  Version: ' . ($php['version'] ?? 'unknown');
        $lines[] = '  SAPI: ' . ($php['sapi'] ?? 'unknown');
        if (!empty($php['extensions']) && is_array($php['extensions'])) {
            $lines[] = '  Extensions:';
            foreach ($php['extensions'] as $name => $loaded) {
                $lines[] = '    ' . $name . ': ' . ($loaded ? 'loaded' : 'missing');
            }
        }
        $lines[] = '';

        $paths = $report['checks']['paths'] ?? [];
        $lines[] = 'Paths';
        $lines[] = '  Config: ' . ($paths['configPath'] ?? 'n/a');
        $lines[] = '  Data Dir: ' . ($paths['dataDir'] ?? 'n/a');
        $lines[] = '';

        $db = $report['checks']['database'] ?? [];
        $lines[] = 'Database';
        $lines[] = '  Driver: ' . ($report['checks']['databaseDriver'] ?? 'unknown');
        $lines[] = '  Connected: ' . (($db['connected'] ?? false) ? 'yes' : 'no');
        if (!empty($db['error'])) {
            $lines[] = '  Error: ' . $db['error'];
        }
        $tables = $db['tables'] ?? [];
        $lines[] = '  config_cfg rows: ' . ($tables['config_cfg'] ?? 'n/a');
        $lines[] = '  version_ver rows: ' . ($tables['version_ver'] ?? 'n/a');

        return implode("\n", $lines) . "\n";
    }
}
