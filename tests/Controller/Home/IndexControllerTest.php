<?php
// tests/Controller/Home/IndexController.php

namespace App\Tests\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{

    public function testHome()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAbout()
    {
        $client = static::createClient();
        $client->request('GET', '/about');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
