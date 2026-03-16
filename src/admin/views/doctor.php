<?php

use ChurchCRM\dto\SystemURLs;

require SystemURLs::getDocumentRoot() . '/Include/Header.php';

$doctor = $doctor ?? [];
$checks = $doctor['checks'] ?? [];
$php = $checks['php'] ?? [];
$extensions = $php['extensions'] ?? [];
$paths = $checks['paths'] ?? [];
$db = $checks['database'] ?? [];
$tables = $db['tables'] ?? [];
$ok = $doctor['ok'] ?? false;
$generatedAt = $doctor['generatedAt'] ?? null;
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?= gettext('System Doctor') ?></h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge badge-<?= $ok ? 'success' : 'danger' ?>">
                        <?= $ok ? gettext('OK') : gettext('Issues Detected') ?>
                    </span>
                    <?php if (!empty($generatedAt)): ?>
                        <span class="text-muted ml-2"><?= gettext('Generated') ?>: <?= htmlspecialchars($generatedAt, ENT_QUOTES, 'UTF-8') ?></span>
                    <?php endif; ?>
                </div>

                <h5><?= gettext('PHP') ?></h5>
                <table class="table table-sm table-striped">
                    <tbody>
                        <tr>
                            <th><?= gettext('Version') ?></th>
                            <td><?= htmlspecialchars($php['version'] ?? 'unknown', ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th><?= gettext('SAPI') ?></th>
                            <td><?= htmlspecialchars($php['sapi'] ?? 'unknown', ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    </tbody>
                </table>

                <h5><?= gettext('Required Extensions') ?></h5>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th><?= gettext('Extension') ?></th>
                            <th><?= gettext('Status') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($extensions as $name => $loaded): ?>
                            <tr>
                                <td><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <span class="badge badge-<?= $loaded ? 'success' : 'danger' ?>">
                                        <?= $loaded ? gettext('Loaded') : gettext('Missing') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h5><?= gettext('Paths') ?></h5>
                <table class="table table-sm table-striped">
                    <tbody>
                        <tr>
                            <th><?= gettext('Config Path') ?></th>
                            <td><?= htmlspecialchars($paths['configPath'] ?? 'n/a', ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th><?= gettext('Data Directory') ?></th>
                            <td><?= htmlspecialchars($paths['dataDir'] ?? 'n/a', ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    </tbody>
                </table>

                <h5><?= gettext('Database') ?></h5>
                <table class="table table-sm table-striped">
                    <tbody>
                        <tr>
                            <th><?= gettext('Driver') ?></th>
                            <td><?= htmlspecialchars($doctor['checks']['databaseDriver'] ?? 'unknown', ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th><?= gettext('Connected') ?></th>
                            <td><?= ($db['connected'] ?? false) ? gettext('Yes') : gettext('No') ?></td>
                        </tr>
                        <?php if (!empty($db['error'])): ?>
                            <tr>
                                <th><?= gettext('Error') ?></th>
                                <td><?= htmlspecialchars($db['error'], ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <th><?= gettext('config_cfg rows') ?></th>
                            <td><?= htmlspecialchars((string) ($tables['config_cfg'] ?? 'n/a'), ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                        <tr>
                            <th><?= gettext('version_ver rows') ?></th>
                            <td><?= htmlspecialchars((string) ($tables['version_ver'] ?? 'n/a'), ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<?php require SystemURLs::getDocumentRoot() . '/Include/Footer.php'; ?>
