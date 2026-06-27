<?php

// Включаем отладку
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Проверка Yii2</h1>";

// 1. Проверка автозагрузки
echo "<h2>1. Автозагрузка</h2>";
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require $autoloadPath;
    echo "✓ autoload.php найден и загружен<br>";
} else {
    echo "✗ autoload.php НЕ найден по пути: " . $autoloadPath . "<br>";
    exit;
}

// 2. Проверка Yii2
echo "<h2>2. Yii2</h2>";
$yiiPath = __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
if (file_exists($yiiPath)) {
    require $yiiPath;
    echo "✓ Yii2 найден и загружен<br>";
} else {
    echo "✗ Yii2 НЕ найден по пути: " . $yiiPath . "<br>";
    exit;
}

// 3. Проверка конфигурации
echo "<h2>3. Конфигурация</h2>";
$configPath = __DIR__ . '/../config/web.php';
if (file_exists($configPath)) {
    $config = require $configPath;
    echo "✓ web.php загружен<br>";
    
    // Проверка алиасов
    if (isset($config['aliases']['@web'])) {
        echo "✓ @web = " . $config['aliases']['@web'] . "<br>";
    } else {
        echo "✗ @web не определен!<br>";
    }
    
    if (isset($config['aliases']['@webroot'])) {
        echo "✓ @webroot = " . $config['aliases']['@webroot'] . "<br>";
    } else {
        echo "✗ @webroot не определен!<br>";
    }
    
    // Проверка компонентов
    if (isset($config['components']['request']['cookieValidationKey'])) {
        echo "✓ cookieValidationKey задан<br>";
    } else {
        echo "✗ cookieValidationKey не задан!<br>";
    }
} else {
    echo "✗ web.php НЕ найден по пути: " . $configPath . "<br>";
    exit;
}

// 4. Попытка создания приложения
echo "<h2>4. Создание приложения</h2>";
try {
    $app = new yii\web\Application($config);
    echo "✓ Приложение создано успешно!<br>";
    echo "BasePath: " . $app->basePath . "<br>";
    echo "Webroot: " . $app->getRequest()->getBaseUrl() . "<br>";
} catch (Exception $e) {
    echo "✗ Ошибка при создании приложения: " . $e->getMessage() . "<br>";
    echo "<h3>Трассировка:</h3>";
    echo nl2br($e->getTraceAsString());
}