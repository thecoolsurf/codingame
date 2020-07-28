<?php
// src/Tests/Controller/Practice/QuestionControllerWebTest.php

namespace App\Tests\Controller\Practice;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuestionControllerWebTest extends WebTestCase
{
    
    public function testQuestion()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/practice/php/question-1');
        $this->assertTrue($crawler->filter('html:contains("Practice")')->count() > 0);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testPosition()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ajax/question/position');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
}
