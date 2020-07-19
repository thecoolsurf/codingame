<?php
/* src/Controller/Practice/QuestionController.php */

namespace App\Controller\Practice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;
use App\Repository\Practice\QuestionRepository as QuestionRep;
use App\Repository\Practice\ResponseRepository as ResponseRep;
use App\Entity\Response as ResponseEntity;

class QuestionController extends AbstractController
{
    
    /**
     * Public display question by ID
     * @Method({"GET"})
     * @Route("/practice/{slug}/question-{id}", name="practice")
     */
    public function question(BodyRep $bodyRep, CategoryRep $category_rep, QuestionRep $question_rep, ResponseRep $response_rep, Request $request, $slug, $id)
    {
        $body = $bodyRep->findBodyBySlug($request)[0];
        $navigation = $category_rep->getNavigationCategories($category_rep, $question_rep);
        $question = $question_rep->find($id);
        // response
        if (array_key_exists(0, $response_rep->findBy(['question'=>$id]))):
            $response = $response_rep->findBy(['question'=>$id])[0];
        else:
            $response = $response_rep->findBy(['question'=>$id]);
        endif;
        // CAUTION: carefull with Datafixture auto increment
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
        return $this->render('public/practice/'.$slug.'/question.html.twig', [
            'url' => 'practice',
            'slug' => $slug,
            'body' => $body,
            'categories' => $navigation[0],
            'questions' => $navigation[1],
            'question' => $question,
            'response' => $response,
            'datas' => $datas,
        ]);
    }
    
    /**
     * Update or insert response by question ID
     * @Method({"POST"})
     * @Route("/ajax/question/updateorinsert", name="ajax_question_updateorinsert")
     */
    public function updateOrInsertCode(Request $request, QuestionRep $question_rep, ResponseRep $response_rep)
    {
        $id = $request->request->get('id');
        $code = $request->request->get('code');
        $em = $this->getDoctrine()->getManager();
        $question = $question_rep->find($id);
        // response
        if (array_key_exists(0, $response_rep->findBy(['question'=>$id]))):
            $response = $response_rep->findBy(['question'=>$id])[0];
        else:
            $response = $response_rep->findBy(['question'=>$id]);
        endif;
        if ($response):
            $alert_class = 'alert-warning';
            $alert_label = 'Update successfully!';
        else:
            $alert_class = 'alert-success';
            $alert_label = 'Insert successfully!';
            $response = new ResponseEntity();
        endif;
        $response->setQuestion($question);
        $response->setAnswer(trim($code));
        $em->persist($response);
        $em->flush();
        $msg  = '<div class="alert '.$alert_class.'" role="alert">';
        $msg .= $alert_label;
        $msg .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        $msg .= '<span aria-hidden="true">&times;</span>';
        $msg .= '</button>';
        $msg .= '</div>';
        return new Response($msg);
    }
    
    /**
     * Display result code for the question number 4
     * @Method({"POST"})
     * @Route("/ajax/question/position", name="ajax_question_position")
     */
    public function getPosition(Request $request)
    {
        $ltx = $request->request->get('ltx');
        $lty = $request->request->get('lty');
        $lgx = $request->request->get('lgx');
        $lgy = $request->request->get('lgy');
        $result = sqrt(pow(($lgx-$ltx),2)+pow(($lgy-$lty),2));
        return New Response($result);
    }
    
}
