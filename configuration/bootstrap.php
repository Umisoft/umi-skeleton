<?php
    /**
     * Локальная конифгурация загрузчика приложения
     */

    use umi\config\toolbox\IConfigTools;
    use umi\i18n\toolbox\I18nToolsInterface;

    $applicationPath = dirname(__DIR__);
    $vendorDirectory = $applicationPath . '/vendor';
    $libraryPath = $vendorDirectory . '/umi/framework/library/umi';

    return [
        /**
         * Конфигурация для регистрации наборов инструментов.
         */
        Bootstrap::OPTION_TOOLKIT => [
            require($libraryPath . '/config/toolbox/config.php'),
            require($libraryPath . '/http/toolbox/config.php'),
            require($libraryPath . '/route/toolbox/config.php'),
            require($libraryPath . '/session/toolbox/config.php'),
            require($libraryPath . '/hmvc/toolbox/config.php'),
            require($libraryPath . '/templating/toolbox/config.php'),
        ],
        /**
         * Конфигурация встроенных иснтрументов
         */
        Bootstrap::OPTION_SETTINGS => [
            IConfigTools::ALIAS => [
                'aliases' => [
                    '~' => [__DIR__, __DIR__ . '/local'],
                    '~/application' => [dirname(__DIR__) . '/application']
                ]
            ],
            I18nToolsInterface::ALIAS => [
                'translator' => [
                    'dictionaries' => require('i18n.php')
                ]
            ]
        ]
    ];
