<?php
// src/Tests/Controller/Practice/QuestionControllerTypeTest.php

namespace App\Tests\Controller\Practice;

use Symfony\Component\Form\Test\TypeTestCase;
use App\Entity\Question;
use App\Entity\Response;
use App\Form\ResponseFormType;

class QuestionControllerTypeTest extends TypeTestCase
{
    
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
