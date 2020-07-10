<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Practice\QuestionRepository as QuestionRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;

class BodyController extends AbstractController
{
    
    /**
     * @Method({"GET"})
     * @Route("/admin/body/listing", name="admin_body_listing")
     */
    public function listing(CategoryRep $category_rep, QuestionRep $question_rep)
    {
        $navigation = $category_rep->getNavigationCategories($category_rep, $question_rep);
        $rows = $question_rep->getRandomNumeric();
        return $this->render('admin/listing/question.html.twig', [
            'url' => 'admin',
            'categories' => $navigation[0],
            'questions' => $navigation[1],
            'rows' => $rows,
        ]);
    }
    
}
