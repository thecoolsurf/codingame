<?php
// src/Tests/Controller/Practice/QuestionControllerTypeTest.php

namespace App\Tests\Controller\Practice;

use Symfony\Component\Form\Test\TypeTestCase;
use App\Entity\User;
use App\Entity\Question;
use App\Entity\Response;
use App\Form\ResponseFormType;

class QuestionControllerTypeTest extends TypeTestCase
{
    
    public function updateOrInsertCode()
    {
        $user = new User();
        $question = new Question();
        $response = new Response();
        $expected = new Response();
        $answer = 'hello world';
        $formData = ['answer' => $answer];
        $form = $this->factory->create(ResponseFormType::class, $response);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        // test
        $expected->setUser($user);
        $expected->setQuestion($question);
        $expected->setAnswer($answer);
        // object
        $response->setUser($user);
        $response->setQuestion($question);
        $this->assertEquals($expected, $response);
    }
    
}
