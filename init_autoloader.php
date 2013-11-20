<?php
$loader = __DIR__ . '/vendor/autoload.php';

if (!file_exists($loader)) {
    throw new RuntimeException(
        'Composer autoloader file is not found! Run "composer install" at project root directory.'
    );
}

return require $loader;
