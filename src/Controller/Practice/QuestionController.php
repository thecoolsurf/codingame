<?php

namespace App\Controller\Practice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\QuestionRepository as QuestionRep;

class QuestionController extends AbstractController
{
    
    /**
     * @Route("/practice/{slug}/question-{id}", name="practice_question")
     */
    public function index(BodyRep $bodyRep, QuestionRep $question_rep, Request $request)
    {
        $slug = $request->query->get('slug');
        $id = $request->query->get('id');
        $questions = $question_rep->findQuetionForNavigation();
        $body = $bodyRep->findBodyBySlug($request)[0];
        $question = $question_rep->find($id);
        return $this->render('public/prractice/'.$slug.'/question-'.$id.'.html.twig', [
            'url' => 'practice',
            'body' => $body,
            'questions' => $questions,
            'question' => $question,
        ]);
    }
    
}

