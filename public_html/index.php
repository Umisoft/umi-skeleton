<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */

$appDirectory = dirname(__DIR__);

require dirname(__DIR__) . '/init_autoloader.php';

$bootstrapConfigFile = $appDirectory . '/configuration/bootstrap.php';
if (!is_readable($bootstrapConfigFile)) {
    throw new RuntimeException('Invalid bootstrap configuration file.');
}

require $appDirectory . '/Bootstrap.php';
$bootstrap = new Bootstrap(require $bootstrapConfigFile);
$bootstrap->runApplication();