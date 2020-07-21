<?php
// src/Controller/Home/IndexController.php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;

class IndexController extends AbstractController
{

    private $body_rep;
    private $category_rep;
    
    public function __construct(BodyRep $body_rep, CategoryRep $category_rep)
    {
        $this->body_rep = $body_rep;
        $this->category_rep = $category_rep;
    }
    
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request)
    {
        $bodies = $this->body_rep->findBodyBySlug($request);
        $navigation = $this->category_rep->getNavigationCategories();
        return $this->render('public/home/index.html.twig', [
            'url' => 'home',
            'bodies' => $bodies,
            'categories' => $navigation[0],
            'questions' => $navigation[1],
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(Request $request)
    {
        $bodies = $this->body_rep->findBodyBySlug($request)[0];
        $navigation = $this->category_rep->getNavigationCategories();
        return $this->render('public/home/index.html.twig', [
            'url' => 'home',
            'bodies' => $bodies,
            'categories' => $navigation[0],
            'questions' => $navigation[1],
        ]);
    }

}
