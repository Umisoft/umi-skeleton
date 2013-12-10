<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */

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
