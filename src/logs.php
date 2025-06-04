<?php
// logs.php
date_default_timezone_set('Europe/Kyiv');

$logFile = __DIR__ . '/log.json';
$GLOBALS['logs'] = [];

// Якщо файл існує — зчитай поточні логи
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

// Перехоплює warnings/notices
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    logMessage('Warning/Error', "$errstr in $errfile on line $errline");
});

// Перехоплює фатальні помилки
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== NULL) {
        logMessage('Fatal Error', "{$error['message']} in {$error['file']} on line {$error['line']}");
    }
    // Зберігаємо всі логи в масиві
    file_put_contents(__DIR__ . '/log.json', json_encode($GLOBALS['logs'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
});

// Починаємо перехоплювати весь вивід
ob_start();
