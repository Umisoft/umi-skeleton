<?php
    namespace application;

    use umi\hmvc\component\Component;
    use umi\hmvc\component\request\IComponentRequest;
    use umi\hmvc\component\response\IComponentResponse;
    use umi\hmvc\controller\result\IControllerResult;
    use umi\i18n\ILocalizable;
    use umi\session\ISessionAware;
    use umi\session\TSessionAware;

    /**
     * MVC Application.
     *
     * @package App
     */
    class Application extends Component implements ILocalizable, ISessionAware
    {
        use TSessionAware;

        /** Контроллер для отображения сетки приложения */
        const LAYOUT_CONTROLLER = 'layout';
        /**
         * Пространство имен сессии для сохранения данных PRG.
         */
        const PRG_NAMESPACE = 'post_redirect_get';

        /**
         * {@inheritdoc}
         */
        public function execute(IComponentRequest $request)
        {
            if (null !== ($response = $this->postRedirectGet($request))) {
                return $response;
            } else {
                return parent::execute($request);
            }
        }

        /**
         * {@inheritdoc}
         */
        public function processResponse(IComponentResponse &$response, IComponentRequest $request)
        {
            if (!$this->getControllerFactory()->hasController(self::LAYOUT_CONTROLLER)) {
                return;
            }

            $controller = $this->getControllerFactory()
                ->createController(self::LAYOUT_CONTROLLER, [$response->getContent()]);

            $result = $controller($request);

            if ($result instanceof IControllerResult) {
                $view = $this->getContextView($request);

                $response
                    ->setContent($view->render($result->getTemplate(), $result->getVariables()));
            }
        }

        /**
         * Реализация паттерна Post/Redirect/Get - PRG.
         * @link http://en.wikipedia.org/wiki/Post/Redirect/Get
         */
        protected function postRedirectGet(IComponentRequest $request)
        {
            if (!$this->hasSessionNamespace(self::PRG_NAMESPACE)) {
                $this->registerSessionNamespace(self::PRG_NAMESPACE);
            }

            $prgNamespace = $this->getSessionNamespace(self::PRG_NAMESPACE);
            $prgKey = 'prg_' . md5($request->getRequestUri());

            if ($request->getMethod() == IComponentRequest::POST) {
                $prgNamespace[$prgKey] = $request->getParams(IComponentRequest::POST)->toArray();

                return $this->createComponentResponse()
                    ->getHeaders()->setHeader('Location', $request->getRequestUri());

            } elseif ($prgNamespace->has($prgKey)) {

                $request->getParams(IComponentRequest::HEADERS)->set('REQUEST_METHOD', 'POST');

                $request->getParams(IComponentRequest::POST)->setArray($prgNamespace[$prgKey]);

                $prgNamespace->del($prgKey);
                return null;
            }

            return null;
        }
    }
