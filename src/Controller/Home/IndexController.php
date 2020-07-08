<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(BodyRep $bodyRep, CategoryRep $category_rep, Request $request)
    {
        $url = $request->query->get('url') ? $request->query->get('url') : 'home';
        $body = $bodyRep->findBodyBySlug($request)[0];
        $categories = $category_rep->findAll();
        return $this->render('public/home/index.html.twig', [
            'url' => $url,
            'body' => $body,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(BodyRep $bodyRep, CategoryRep $category_rep, Request $request)
    {
        $url = $request->query->get('url') ? $request->query->get('url') : 'home';
        $body = $bodyRep->findBodyBySlug($request)[0];
        $categories = $category_rep->findAll();
        return $this->render('public/home/about.html.twig', [
            'url' => $url,
            'body' => $body,
            'categories' => $categories,
        ]);
    }
    
}

