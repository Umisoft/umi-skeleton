<?php
$appDirectory = dirname(__DIR__);

require dirname(__DIR__) . '/init_autoloader.php';

$bootstrapConfigFile = $appDirectory . '/configuration/bootstrap.php';
if (!is_readable($bootstrapConfigFile)) {
    throw new RuntimeException('Invalid bootstrap configuration file.');
}

require $appDirectory . '/Bootstrap.php';
$bootstrap = new Bootstrap(require $bootstrapConfigFile);
$bootstrap->run();