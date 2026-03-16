#!/usr/bin/env php
<?php

require_once __DIR__ . '/../src/Include/LoadConfigs.php';

use ChurchCRM\Service\DoctorService;

$options = getopt('', ['json']);
$report = DoctorService::run();

if (isset($options['json'])) {
    echo json_encode($report, JSON_PRETTY_PRINT) . "\n";
    exit(0);
}

echo DoctorService::renderText($report);
