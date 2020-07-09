<?php

namespace App\Controller\Practice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;
use App\Repository\Practice\QuestionRepository as QuestionRep;
use App\Entity\Response as ResponseEntity;

class QuestionController extends AbstractController
{
    
    /**
     * @Method({"GET"})
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
    
    /**
     * @Method({"POST"})
     * @Route("/ajax/question/updateorinsert/{id}", name="ajax_question_updateorinsert")
     */
    public function updateOrInsertCode(Request $request, QuestionRep $question_rep, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $question = $question_rep->find($id);
        $response = $question->getResponse();
        $answer = $request->request->get('code');
        dump($answer);
        exit();
        if ($response):
            $response = new ResponseEntity();
            $response->setAnswer($answer);
            $em->persist($response);
            $em->flush();
            $msg = '<div class="alert alert-warning" role="alert">Insert successfully!</div>';
        else:
            $response->setAnswer($answer);
            $em->persist($response);
            $em->flush();
            $msg = '<div class="alert alert-success" role="alert">Update successfully!</div>';
        endif;
        return new Response($msg);
    }
    
}
