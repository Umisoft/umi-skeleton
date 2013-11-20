<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 *
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */
namespace apptest;

use Bootstrap;
use umi\hmvc\component\IComponentFactory;
use umi\hmvc\component\request\IComponentRequest;
use umi\hmvc\component\request\IComponentRequestFactory;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Bootstrap $bootstrap
     */
    private $bootstrap;

    public function setUp()
    {
        $this->bootstrap = new Bootstrap(require APP_PATH . '/configuration/bootstrap.php');
        $this->setUpFixtures();
    }

    public function setUpFixtures()
    {
    }


    protected function getToolkit()
    {
        return $this->bootstrap->getToolkit();
    }

    protected function createApplication()
    {
        return $this->bootstrap->createApplication();
    }

    /**
     * @param $url
     * @return IComponentRequest
     */
    protected function createRequest($url)
    {
        $url = substr($url, -1) == '/' ? substr($url, 0, -1) : $url;

        /** @var IComponentRequestFactory $componentRequestFactory */
        $componentRequestFactory = $this->getToolkit()->getService('umi\hmvc\component\request\IComponentRequestFactory');

        return $componentRequestFactory->createComponentRequest(
            $url
        );
    }

    protected function createComponent(array $configuration)
    {
        /**
         * @var IComponentFactory $componentFactory
         */
        $componentFactory = $this->getToolkit()
            ->getService('umi\hmvc\component\IComponentFactory');

        return $componentFactory->createComponent($configuration);
    }
}
