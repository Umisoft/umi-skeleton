<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */

namespace application;

use umi\hmvc\component\IComponent;
use umi\route\IRouteFactory;

return [
    // класс MVC-компонента
    'componentClass'               => __NAMESPACE__ . '\Application',

    // зарегистрированные контроллеры
    IComponent::OPTION_CONTROLLERS => [
        IComponent::ERROR_CONTROLLER   => __NAMESPACE__ . '\controller\ErrorController',
        Application::LAYOUT_CONTROLLER => __NAMESPACE__ . '\controller\LayoutController',

        'index'                        => __NAMESPACE__ . '\controller\IndexController',
    ],

    // настройки шаблонизатора
    IComponent::OPTION_VIEW        => [
        // тип шаблонизатора
        'type'      => 'php',
        'extension' => 'phtml',
        // путь до шаблонов компонента
        'directory' => __DIR__ . '/view',
    ],

    // маршруты текущего компонента
    IComponent::OPTION_ROUTES      => [
        // базовый маршрут внутри компонента
        'home' => [
            // тип маршрута - простой расширеный
            'type'     => IRouteFactory::ROUTE_EXTENDED,
            // путь(маска) маршрута
            'route'    => '/{lang}',

            'rules' => [
                'lang' => '[a-z]{2}-[A-Z]{2}'
            ],

            'defaults' => [
                'lang'       => 'ru-RU',
                'controller' => 'index'
            ]
        ],
    ],
];