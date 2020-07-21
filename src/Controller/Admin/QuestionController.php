<?php
// src/Controller/Admin/QuestionController.php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Practice\QuestionRepository as QuestionRep;
use App\Form\QuestionFormType;
use App\Entity\Question;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */

class QuestionController extends AbstractController
{
    
    private $question_rep;
    private $question_edit;
 
    public function __construct(QuestionRep $question_rep, QuestionFormType $question_form)
    {
        $this->question_rep = $question_rep;
        $this->question_edit = $question_form;
    }
    
    /* ********************************************************************** */
    
    /**
     * LISTING
     * @Route({"GET"})
     * @Route("/admin/question/listing", name="admin_question_listing")
     */
    public function listing()
    {
        $rows = $this->question_rep->findAll();
        return $this->render('admin/listing/question.html.twig', [
            'url' => 'admin - listing',
            'rows' => $rows,
        ]);
    }
    
    /**
     * EDIT
     * @Route({"GET"})
     * @Route("/admin/question/edit/{id}", name="admin_question_edit")
     */
    public function edit(Request $request, $id)
    {
        $question = $this->question_rep->find($id);
        $form = $this->createForm(QuestionFormType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->question_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->render('admin/listing/question.html.twig', [
                'url' => 'admin - listing',
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/question.html.twig', [
                'url' => 'admin - edit',
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * NEW
     * @Route({"GET"})
     * @Route("/admin/question/new", name="admin_question_new")
     */
    public function new(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionFormType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->question_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->redirectToRoute('admin_question_listing',[
                'url' => 'admin - listing',
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/question.html.twig', [
                'url' => 'admin - new',
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * DELETE
     * @Route({"GET"})
     * @Route("/admin/question/delete/{id}", name="admin_question_delete")
     */
    public function delete($id)
    {
        $question = $this->question_rep->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();
        return $this->redirectToRoute('admin_question_listing');
    }
    
}
