<?php
// tests/Controller/Home/IndexController.php

namespace App\Tests\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{

    public function testHome()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertTrue($crawler->filter('html:contains("Home")')->count() > 0);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAbout()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/about');
        $this->assertTrue($crawler->filter('html:contains("About")')->count() > 0);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
