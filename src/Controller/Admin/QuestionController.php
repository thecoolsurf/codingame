<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Practice\QuestionRepository as QuestionRep;

class QuestionController extends AbstractController
{
    
    /**
     * @Method({"GET"})
     * @Route("/admin/question/listing", name="admin_question_listing")
     */
    public function listing(QuestionRep $question_rep)
    {
        $rows = $question_rep->findAll();
        return $this->render('admin/listing/question.html.twig', [
            'url' => 'question',
            'rows' => $rows,
        ]);
    }
    
    /**
     * @Method({"GET"})
     * @Route("/admin/question/edit/{id}", name="admin_question_edit")
     */
    public function edit(QuestionRep $question_rep, $id)
    {
        $question = $question_rep->find($id);
        $form = $this->createForm(\App\Form\QuestionFormType::class, $question);
        return $this->render('admin/form/question.html.twig', [
            'url' => 'admin - edit',
            'form_edit' => $form->createView(),
        ]);
    }
    
    /**
     * @Method({"GET"})
     * @Route("/admin/question/delete/{id}", name="admin_question_delete")
     */
    public function delete(QuestionRep $question_rep, $id)
    {
        $rows = $question_rep->find($id);
        return $this->render('admin/listing/question.html.twig', [
            'url' => 'admin - delete',
            'rows' => $rows,
        ]);
    }
    
}
