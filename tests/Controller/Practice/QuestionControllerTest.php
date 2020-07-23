<?php
// src/Tests/Controller/Practice/QuestionControllerTest.php

namespace App\Tests\Controller\Practice;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class QuestionControllerTest extends WebTestCase
{
    
    public function testQuestion()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/practice/php/question-1');
        $this->assertTrue($crawler->filter('html:contains("Practice")')->count() > 0);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testUpdateOrInsertCode()
    {
        $request = new Request();
        $client = static::createClient();
        $crawler = $client->request('POST', '/ajax/question/updateorinsert');
        $form = $crawler->selectButton('submit')->form();
        $form['id'] = $request->request->set('id', 1);
        $form['code'] = $request->request->set('code', 'sqrt(pow(($lgx-$ltx),2)+pow(($lgy-$lty),2));');
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.alert:contains("Update successfully!")')->count());
    }
    
    public function testGetPosition()
    {
        $request = new Request();
        $client = static::createClient();
        $crawler = $client->request('POST', '/ajax/question/position');
        $form = $crawler->selectButton('submit')->form();
        $form['ltx'] = $request->request->set('ltx', 10);
        $form['lty'] = $request->request->set('lty', 20);
        $form['lgx'] = $request->request->set('lgx', 30);
        $form['lgy'] = $request->request->set('lgy', 40);
        $crawler = $client->submit($form);
        $this->assertEquals(1, $crawler->filter('.alert:contains("Update successfully!")')->count());
    }
    
}
