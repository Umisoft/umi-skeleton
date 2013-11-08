<?php
    namespace application\components\main\controller;

    use umi\hmvc\controller\type\StaticPageController;

    /**
     * Контроллер Index. Выводит статическую главную страницу.
     * @package App\Main
     */
    class IndexController extends StaticPageController
    {
        /**
         * @var string $template шаблон страницы
         */
        protected $template = 'index';
    }