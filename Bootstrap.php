<?php
use Psr\Log\LoggerInterface;
use umi\config\entity\IConfig;
use umi\config\io\IConfigIO;
use umi\hmvc\component\IComponent;
use umi\hmvc\component\IComponentFactory;
use umi\hmvc\component\request\IComponentRequestFactory;
use umi\toolkit\IToolkit;
use umi\toolkit\Toolkit;

/**
 * Класс Bootstrap. Инициализирует приложение.
 */
class Bootstrap
{
    const OPTION_TOOLKIT = 'toolkit';
    const OPTION_SETTINGS = 'settings';
    /**
     * Символическое имя конфигурационного файла.
     */
    const GENERAL_CONFIG = '~/general.php';
    /**
     * @var IToolkit $tools
     */
    protected $toolkit;
    /**
     * @var IComponent $application
     */
    protected $application;
    /**
     * @var IConfig $config
     */
    protected $bootConfig;
    /**
     * @var IConfig $config
     */
    protected $generalConfig;
    /**
     * @var LoggerInterface $logger
     */
    protected $logger;

    /**
     * Конструктор
     * @param array $bootConfig конфигурация
     */
    public function __construct(array $bootConfig)
    {
        $this->bootConfig = $bootConfig;

        $this->configureToolkit();

        $this->createApplication();
    }

    /**
     * Запускает приложение.
     */
    public function run()
    {
        try {
            /** @var IComponentRequestFactory $requestFactory */
            $requestFactory = $this->toolkit->getService('umi\hmvc\component\request\IComponentRequestFactory');
            $request = $requestFactory->createComponentRequest($this->getUrl());

            $response = $this->application
                ->execute($request);

            $response->send();
        } catch (\Exception $e) {
            throw new ErrorException('Unhandled exception thrown.', 0, 1, __FILE__, __LINE__, $e);
        }
    }

    /**
     * Возвращает toolkit.
     * @return IToolkit
     */
    public function getToolkit()
    {
        return $this->toolkit;
    }

    /**
     * Загружает и регистрирует конфигурацию тулбокса.
     */
    protected function configureToolkit()
    {
        $this->toolkit = new Toolkit();

        if (isset($this->bootConfig[self::OPTION_TOOLKIT])) {
            $this->toolkit->registerToolboxes($this->bootConfig[self::OPTION_TOOLKIT]);
        }

        if (isset($this->bootConfig[self::OPTION_SETTINGS])) {
            $this->toolkit->setSettings($this->bootConfig[self::OPTION_SETTINGS]);
        }

        /**
         * @var IConfigIO $configIO
         */
        $configIO = $this->toolkit->getService('umi\config\io\IConfigIO');
        $this->generalConfig = $configIO->read(self::GENERAL_CONFIG);

        $this->toolkit->setSettings($this->generalConfig['toolkit'] ? : []);
    }

    /**
     * Создает компонент приложения.
     */
    protected function createApplication()
    {
        // todo: fix toArray
        $appConfig = $this->generalConfig->get('application')
            ->toArray();

        /** @var IComponentFactory $componentFactory */
        $componentFactory = $this->toolkit->getService('umi\hmvc\component\IComponentFactory');
        $this->application = $componentFactory->createComponent($appConfig);
    }

    /**
     * Получает URL запроса без параметров.
     * @return string
     */
    protected function getUrl()
    {
        $request = $this->toolkit->getService('umi\http\request\IRequest');

        $url = parse_url(
            $request->getRequestUri(),
            PHP_URL_PATH
        );

        return substr($url, -1) == '/' ? substr($url, 0, -1) : $url;
    }
}