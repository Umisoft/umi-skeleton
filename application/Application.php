<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */

namespace application;

use umi\hmvc\component\Component;
use umi\hmvc\component\request\IComponentRequest;
use umi\hmvc\component\response\IComponentResponse;
use umi\hmvc\context\Context;
use umi\i18n\ILocalesService;
use umi\toolkit\IToolkitAware;
use umi\toolkit\TToolkitAware;

/**
 * MVC Application.
 */
class Application extends Component implements IToolkitAware
{
    use TToolkitAware;

    /** Контроллер для отображения сетки приложения */
    const LAYOUT_CONTROLLER = 'layout';

    /**
     * {@inheritdoc}
     */
    protected function route(IComponentRequest $request)
    {
        $result = parent::route($request);

        /**
         * @var ILocalesService $service
         */
        $service = $this->getToolkit()
            ->getService('umi\i18n\ILocalesService');
        $service->setCurrentLocale(
            $request->getVar(IComponentRequest::ROUTE, 'lang', 'en-US')
        );

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function processResponse(IComponentResponse &$response, IComponentRequest $request)
    {
        if (!$this->getControllerFactory()->hasController(self::LAYOUT_CONTROLLER)) {
            return;
        }

        $context = new Context($this, $request);
        $controller = $this->getControllerFactory()->createController(self::LAYOUT_CONTROLLER, [$response]);

        $response = $this->callController($controller, $context);
    }
}
