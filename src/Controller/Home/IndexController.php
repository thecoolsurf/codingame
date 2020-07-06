<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BodyRepository as BodyRep;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(BodyRep $bodyRep, Request $request)
    {
        $url = $request->query->get('url') ? $request->query->get('url') : 'home';
        $body = $bodyRep->findBodyBySlug($request)[0];
        return $this->render('public/home/index.html.twig', [
            'url' => $url,
            'body' => $body,
        ]);
    }
}

