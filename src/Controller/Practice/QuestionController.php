<?php

namespace App\Controller\Practice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;
use App\Repository\Practice\QuestionRepository as QuestionRep;

class QuestionController extends AbstractController
{
    
    /**
     * @Route("/practice/{them}/question-{id}", name="practice_question")
     */
    public function index(BodyRep $bodyRep, CategoryRep $category_rep, QuestionRep $question_rep, Request $request)
    {
        $them = $request->query->get('them');
        $id = $request->query->get('id');
        $categories = $category_rep->findAll();
        $body = $bodyRep->findBodyBySlug($request)[0];
        $question = $question_rep->find($id);
        return $this->render('public/prractice/'.$them.'/question-'.$id.'.html.twig', [
            'url' => 'practice',
            'body' => $body,
            'categories' => $categories,
            'question' => $question,
        ]);
    }
    
}

