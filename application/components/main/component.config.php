<?php
    namespace application\components\main;

    use umi\hmvc\component\IComponent;

    return [
        // зарегистрированные контроллеры компонента
        IComponent::OPTION_CONTROLLERS => [
            'index' => __NAMESPACE__ . '\controller\IndexController'
        ],

        // настройки шаблонизатора
        IComponent::OPTION_VIEW => [
            // тип шаблонизатора
            'type' => 'php',
            'extension' => 'phtml',
            // путь до шаблонов компонента
            'directory' => __DIR__ . '/view'
        ],

        // маршруты текущего компонента
        'routes' => [
            // базовый маршрут внутри компонента
            'index' => [
                // тип маршрута - фиксированный
                'type' => 'fixed',
                // параметры по-умолчанию
                'defaults' => [
                    'controller' => 'index'
                ],
            ],
        ]
    ];