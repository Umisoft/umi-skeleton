<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 *
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */
namespace apptest;

use umi\hmvc\component\request\IComponentRequest;
use umi\hmvc\component\response\IComponentResponse;

/**
 * Class ApplicationTestCase
 */
abstract class ApplicationTestCase extends TestCase
{

    protected function postQuery($url, $post = [], $get = [])
    {
        $this->setUpGlobals(
            IComponentRequest::METHOD_POST,
            $get,
            $post
        );

        try {
            $request = $this->createRequest($url);
            $response = $this->runApplication($request);
        } catch(\Exception $e) {
            $this->restoreGlobals();
            throw $e;
        }
        $this->restoreGlobals();

        return $response;
    }

    /**
     * @param $url
     * @param array $get
     * @return IComponentResponse
     * @throws \Exception
     */
    protected function getQuery($url, $get = [])
    {
        $this->setUpGlobals(
            IComponentRequest::METHOD_GET,
            $get
        );

        try {
            $request = $this->createRequest($url);
            $response = $this->runApplication($request);
        } catch(\Exception $e) {
            $this->restoreGlobals();
            throw $e;
        }

        $this->restoreGlobals();

        return $response;
    }

    private function runApplication(IComponentRequest $request)
    {
        $application = $this->createApplication();

        return $application->execute($request);
    }

    private function setUpGlobals($method, $get = [], $post = [])
    {
        $_GET = $get;
        $_POST = $post;
        $_REQUEST = $get + $post;

        $_SERVER['REQUEST_METHOD'] = $method;
    }

    private function restoreGlobals()
    {
        $_GET = [];
        $_POST = [];
        $_REQUEST = [];
        $_SERVER['REQUEST_METHOD'] = IComponentRequest::METHOD_CLI;
    }
}
