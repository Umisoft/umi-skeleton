<?php
namespace application\controller;

use umi\hmvc\controller\type\StaticPageController;

/**
 * Контроллер Index. Выводит статическую главную страницу.
 */
class IndexController extends StaticPageController
{
    /**
     * @var string $template шаблон страницы
     */
    protected $template = 'index';
}
