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
     * @Route("/practice/{slug}/question-{id}", name="practice")
     */
    public function question(BodyRep $bodyRep, CategoryRep $category_rep, QuestionRep $question_rep, Request $request, $slug, $id)
    {
        $body = $bodyRep->findBodyBySlug($request)[0];
        $navigation = $category_rep->getNavigationCategories($category_rep, $question_rep);
        $question = $question_rep->find($id);
        switch ($id):
            case 3:
                $datas = $question_rep->getRandomNumeric();
            break;
            case 4:
                $datas = $question_rep->getPosition(10,20,30,40);
            break;
            default:
                $datas = [];
            break;
        endswitch;
        return $this->render('public/practice/'.$slug.'/question-'.$id.'.html.twig', [
            'url' => 'practice',
            'body' => $body,
            'categories' => $navigation[0],
            'questions' => $navigation[1],
            'question' => $question,
            'datas' => $datas,
        ]);
    }
    
}
