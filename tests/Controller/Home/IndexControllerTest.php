<?php
// src/Controller/Home/IndexController.php

namespace App\Controller\Home;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;
use App\Repository\Practice\QuestionRepository as QuestionRep;

class IndexControllerTest extends TestCase
{

    private $body_rep;
    private $category_rep;
    private $question_rep;
    
    public function __construct(BodyRep $body_rep, CategoryRep $category_rep, QuestionRep $question_rep)
    {
        $this->body_rep = $body_rep;
        $this->category_rep = $category_rep;
        $this->question_rep = $question_rep;
    }
    
    public function homeTest(Request $request)
    {
//        $bodies = $this->body_rep->findBodyBySlug($request);
//        $navigation = $this->category_rep->getNavigationCategories($this->category_rep, $this->question_rep);
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertSelectorTextContains('html h1', 'Home');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function aboutTest(Request $request)
    {
//        $bodies = $this->body_rep->findBodyBySlug($request)[0];
//        $navigation = $this->category_rep->getNavigationCategories($this->category_rep, $this->question_rep);
        $client = static::createClient();
        $client->request('GET', '/about');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
