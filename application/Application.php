<?php
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
