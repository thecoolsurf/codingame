<?php
// src/Tests/Controller/Practice/QuestionControllerTest.php

namespace App\Tests\Controller\Practice;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\Test\TypeTestCase;
use App\Entity\Question;
use App\Entity\Response;
use App\Form\ResponseFormType;

class QuestionControllerTest extends TypeTestCase
{
    
    public function question()
    {
        $client = WebTestCase::createClient();
        $crawler = $client->request('GET', '/practice/php/question-1');
        $this->assertTrue($crawler->filter('html:contains("Practice")')->count() > 0);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function testUpdateOrInsertCode()
    {
        $question = new Question();
        $response = new Response();
        $expected = new Response();
        $answer = 'hello world';
        $formData = ['answer' => $answer];
        $form = $this->factory->create(ResponseFormType::class, $response);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $expected->setQuestion($question);
        $expected->setAnswer($answer);
        $response->setQuestion($question);
        $this->assertEquals($expected, $response);
    }
    
    public function position()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/ajax/question/position');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
}
