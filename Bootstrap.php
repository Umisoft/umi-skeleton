<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */

use umi\config\entity\IConfig;
use umi\config\io\IConfigIO;
use umi\hmvc\component\IComponentFactory;
use umi\hmvc\component\request\IComponentRequestFactory;
use umi\http\request\IRequest;
use umi\toolkit\IToolkit;
use umi\toolkit\Toolkit;

/**
 * Класс Bootstrap. Инициализирует приложение.
 */
class Bootstrap
{
    const OPTION_TOOLKIT = 'toolkit';
    const OPTION_SETTINGS = 'settings';

    /** Символическое имя конфигурационного файла. */
    const GENERAL_CONFIG = '~/general.php';
    /**
     * @var IToolkit $tools
     */
    protected $toolkit;
    /**
     * @var IConfig $config
     */
    protected $configuration;

    /**
     * Конструктор
     * @param array $configuration boot-конфигурация
     */
    public function __construct(array $configuration)
    {
        $this->initToolkit($configuration);
    }

    /**
     * Создает компонент приложения.
     */
    public function createApplication()
    {
        // todo: fix toArray
        $appConfig = $this->configuration->get('application')->toArray();

        /** @var IComponentFactory $componentFactory */
        $componentFactory = $this->toolkit->getService('umi\hmvc\component\IComponentFactory');
        return $componentFactory->createComponent($appConfig);
    }

    /**
     * Запускает приложение.
     */
    public function runApplication()
    {
        $application = $this->createApplication();

        try {
            $application
                ->execute($this->getComponentRequest())
                    ->send();
        } catch (\Exception $e) {
            throw new ErrorException(
                'Unhandled exception thrown.', 0, 1, __FILE__, __LINE__, $e
            );
        }
    }

    /**
     * Возвращает toolkit.
     *
     * @return IToolkit
     */
    public function getToolkit()
    {
        return $this->toolkit;
    }

    /**
     * Загружает и регистрирует конфигурацию тулбокса.
     */
    protected function initToolkit($bootConfig)
    {
        $this->toolkit = new Toolkit();

        if (isset($bootConfig[self::OPTION_TOOLKIT])) {
            $this->toolkit->registerToolboxes($bootConfig[self::OPTION_TOOLKIT]);
        }

        if (isset($bootConfig[self::OPTION_SETTINGS])) {
            $this->toolkit->setSettings($bootConfig[self::OPTION_SETTINGS]);
        }

        /**
         * @var IConfigIO $configIO
         */
        $configIO = $this->toolkit->getService('umi\config\io\IConfigIO');

        $this->configuration = $configIO->read(self::GENERAL_CONFIG);
        $this->toolkit->setSettings($this->configuration['toolkit'] ? : []);
    }

    protected function getComponentRequest()
    {
        /** @var IComponentRequestFactory $componentRequestFactory */
        $componentRequestFactory = $this->toolkit->getService('umi\hmvc\component\request\IComponentRequestFactory');

        /**
         * @var IRequest $request
         */
        $request = $this->toolkit->getService('umi\http\request\IRequest');
        $requestUrl = parse_url($request->getRequestUri(), PHP_URL_PATH);
        $requestUrl = substr($requestUrl, -1) == '/' ? substr($requestUrl, 0, -1) : $requestUrl;

        return $componentRequestFactory->createComponentRequest(
            $requestUrl
        );
    }
}
