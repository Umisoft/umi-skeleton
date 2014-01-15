<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */

/**
 * Локальная конифгурация загрузчика приложения
 */

use umi\config\toolbox\ConfigTools;
use umi\i18n\toolbox\I18nTools;

$applicationPath = dirname(__DIR__);
$vendorDirectory = $applicationPath . '/vendor';
$libraryPath = $vendorDirectory . '/umi/framework/library';

return [
    /**
     * Используемый набор инструментов.
     */
    Bootstrap::OPTION_TOOLKIT  => [
        require($libraryPath . '/i18n/toolbox/config.php'),
        require($libraryPath . '/config/toolbox/config.php'),
        require($libraryPath . '/http/toolbox/config.php'),
        require($libraryPath . '/route/toolbox/config.php'),
        require($libraryPath . '/hmvc/toolbox/config.php'),
        require($libraryPath . '/templating/toolbox/config.php'),
    ],
    /**
     * Настройки инструментов.
     */
    Bootstrap::OPTION_SETTINGS => [
        ConfigTools::NAME       => [
            'aliases' => [
                '~'             => [__DIR__, __DIR__ . '/local'],
                '~/application' => [dirname(__DIR__) . '/application']
            ]
        ],
        I18nTools::NAME => [
            'translatorDictionaries' => require('i18n.php')
        ]
    ]
];
