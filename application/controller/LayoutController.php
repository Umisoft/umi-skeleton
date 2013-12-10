<?php
namespace application\controller;

use umi\hmvc\component\request\IComponentRequest;
use umi\hmvc\component\response\IComponentResponse;
use umi\hmvc\component\response\model\DisplayModel;
use umi\hmvc\controller\type\BaseController;

/**
 * Контроллер сетки приложения.
 */
class LayoutController extends BaseController
{
    /**
     * @var IComponentResponse $response содержимое страницы
     */
    protected $response;

    /**
     * Конструктор.
     * @param IComponentResponse $response
     */
    public function __construct(IComponentResponse $response)
    {
        $this->response = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(IComponentRequest $request)
    {
        return $this->response
            ->setContent(
                new DisplayModel('layout', ['content' => $this->response->getContent()])
            );
    }
}
