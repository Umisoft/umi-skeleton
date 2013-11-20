<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 *
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */

if (!defined('APP_PATH')) {
    define('APP_PATH', dirname(__DIR__));
}

$vendorDir = APP_PATH . '/vendor';

$loader = require APP_PATH . '/init_autoloader.php';
require APP_PATH . '/Bootstrap.php';

$loader->add('apptest', __DIR__);
