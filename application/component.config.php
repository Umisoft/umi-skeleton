<?php
namespace application;

use umi\hmvc\component\IComponent;

return [
    // класс MVC-компонента
    'componentClass'               => __NAMESPACE__ . '\Application',
    // зарегистрированные контроллеры
    IComponent::OPTION_CONTROLLERS => [
        IComponent::ERROR_CONTROLLER   => __NAMESPACE__ . '\controller\ErrorController',
        Application::LAYOUT_CONTROLLER => __NAMESPACE__ . '\controller\LayoutController',

        'index'                        => __NAMESPACE__ . '\controller\IndexController',
    ],
    // зарегистрированные модели
    IComponent::OPTION_MODELS      => [
        'user' => 'app\components\auth\model\UserModel'
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
            // тип маршрута - на основе simple-выражений
            'type'     => 'simple',
            // путь(маска) маршрута
            'route'    => '/{lang}',
            'defaults' => [
                'lang'       => 'ru-RU',
                'controller' => 'index'
            ]
        ],
    ],
];