<?php
require_once 'logs.php';


printHello();









$output = ob_get_clean();

if (!empty($output)) {
    logMessage('Success', trim($output));
    // echo $output; // якщо хочеш бачити результат
}

// Зберігаємо логи (на випадок якщо не було фаталу)
file_put_contents(__DIR__ . '/log.json', json_encode($GLOBALS['logs'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));