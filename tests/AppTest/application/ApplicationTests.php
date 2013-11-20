<?php
/**
 * UMI.Framework (http://umi-framework.ru/)
 *
 * @link      http://github.com/Umisoft/framework for the canonical source repository
 * @copyright Copyright (c) 2007-2013 Umisoft ltd. (http://umisoft.ru/)
 * @license   http://umi-framework.ru/license/bsd-3 BSD-3 License
 */
namespace apptest;

/**
 * Тесты Skeleton приложения.
 */
class ApplicationTests extends ApplicationTestCase
{

    public function testIndexPage()
    {
        $response = $this->getQuery('/');
        $this->assertEquals(200, $response->getCode());
        $this->assertContains('<title>Добро пожаловать в UMI.Framework | Главная</title>', $response->getContent());
        $this->assertContains('<h1>Скелетон приложение на UMI.Framework!</h1>', $response->getContent());

        $response = $this->getQuery('/en-US');
        $this->assertContains('<title>Welcome to UMI.Framework | Home</title>', $response->getContent());
        $this->assertContains('<h1>UMI.Framework skeleton application!</h1>', $response->getContent());
    }

    public function testNotFoundPage()
    {
        $response = $this->getQuery('/wrong/url');

        $this->assertEquals(404, $response->getCode());
        $this->assertContains('<h1>A 404 error occurred</h1>', $response->getContent());
    }
}
