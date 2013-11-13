<?php
namespace application\controller;

use umi\hmvc\component\request\IComponentRequest;
use umi\hmvc\controller\type\BaseController;

/**
 * Контроллер сетки приложения.
 * @package App
 */
class LayoutController extends BaseController
{
    /**
     * @var string $content содержимое страницы
     */
    public $content;

    /**
     * Конструктор.
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(IComponentRequest $request)
    {
        return $this->createControllerResult(
            'layout',
            [
                'content' => $this->content
            ]
        );
    }
}