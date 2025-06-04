<?php
date_default_timezone_set('Europe/Kyiv');

$logFile = __DIR__ . '/log.json';
$GLOBALS['logs'] = [];

if (file_exists($logFile)) {
    $existing = json_decode(file_get_contents($logFile), true);
    if (is_array($existing)) {
        $GLOBALS['logs'] = $existing;
    }
}

function logMessage(string $type, string $message): void {
    $entry = [
        'type' => $type,
        'date' => date('Y-m-d'),
        'time' => date('H:i:s'),
        'message' => $message
    ];
    $GLOBALS['logs'][] = $entry;
}

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);

ob_start();

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    logMessage('Warning/Error', "$errstr in $errfile on line $errline");
    return true; // щоб PHP сам не виводив
});

register_shutdown_function(function () use ($logFile) {
    $error = error_get_last();
    if ($error !== NULL) {
        logMessage('Fatal Error', "{$error['message']} in {$error['file']} on line {$error['line']}");
    }

    $output = ob_get_clean();
    if (!empty($output)) {
        logMessage('Success', trim($output));
    }

    file_put_contents($logFile, json_encode($GLOBALS['logs'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
});
