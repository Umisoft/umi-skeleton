<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */

$loader = __DIR__ . '/vendor/autoload.php';

if (!file_exists($loader)) {
    throw new RuntimeException(
        'Composer autoloader file is not found! Run "composer install" at project root directory.'
    );
}

return require $loader;
