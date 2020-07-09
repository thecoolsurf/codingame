<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;
use App\Repository\Practice\QuestionRepository as QuestionRep;

class IndexController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(BodyRep $bodyRep, CategoryRep $category_rep, QuestionRep $question_rep, Request $request)
    {
        $body = $bodyRep->findBodyBySlug($request)[0];
        $navigation = $category_rep->getNavigationCategories($category_rep, $question_rep);
        return $this->render('public/home/index.html.twig', [
            'url' => 'home',
            'body' => $body,
            'categories' => $navigation[0],
            'questions' => $navigation[1],
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(BodyRep $bodyRep, CategoryRep $category_rep, QuestionRep $question_rep, Request $request)
    {
        $body = $bodyRep->findBodyBySlug($request)[0];
        $navigation = $category_rep->getNavigationCategories($category_rep, $question_rep);
        return $this->render('public/home/index.html.twig', [
            'url' => 'home',
            'body' => $body,
            'categories' => $navigation[0],
            'questions' => $navigation[1],
        ]);
    }

}
