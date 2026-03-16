<?php

// Simple router for PHP built-in server development
// Maps '/' to index.php so the app routes correctly when using `php -S`

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$path = parse_url($requestUri, PHP_URL_PATH) ?: '/';

// If the request is for the root path, serve index.php
if ($path === '/' || $path === '/index.php' || ($scriptName && basename($scriptName) === 'router.php')) {
    require_once __DIR__ . '/index.php';
    exit;
}

// For any other path, try to serve the file directly if it exists
$requestedFile = __DIR__ . $path;
if (is_file($requestedFile)) {
    return false; // Let PHP server handle the file
}

// Route /session/* and /api/* to their respective front controllers
if (str_starts_with($path, '/session')) {
    require_once __DIR__ . '/session/index.php';
    exit;
}

if (str_starts_with($path, '/setup')) {
    require_once __DIR__ . '/setup/index.php';
    exit;
}

if (str_starts_with($path, '/kiosk')) {
    require_once __DIR__ . '/kiosk/index.php';
    exit;
}

if (str_starts_with($path, '/v2')) {
    require_once __DIR__ . '/v2/index.php';
    exit;
}

if (str_starts_with($path, '/finance')) {
    require_once __DIR__ . '/finance/index.php';
    exit;
}

if (str_starts_with($path, '/admin')) {
    require_once __DIR__ . '/admin/index.php';
    exit;
}

if (str_starts_with($path, '/plugins')) {
    require_once __DIR__ . '/plugins/index.php';
    exit;
}

if (str_starts_with($path, '/api')) {
    require_once __DIR__ . '/api/index.php';
    exit;
}

// Fallback: route all app paths through the front controller
require_once __DIR__ . '/index.php';
exit;
