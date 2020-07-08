<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\QuestionRepository as QuestionRep;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(BodyRep $bodyRep, QuestionRep $question_rep, Request $request)
    {
        $body = $bodyRep->findBodyBySlug($request)[0];
        $questions = $question_rep->findQuetionForNavigation();
        return $this->render('public/home/index.html.twig', [
            'url' => 'home',
            'body' => $body,
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(BodyRep $bodyRep, QuestionRep $question_rep, Request $request)
    {
        $body = $bodyRep->findBodyBySlug($request)[0];
        $questions = $question_rep->findQuetionForNavigation();
        return $this->render('public/home/about.html.twig', [
            'url' => 'about',
            'body' => $body,
            'questions' => $questions,
        ]);
    }
    
}

