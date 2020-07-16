<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Practice\ResponseRepository as ResponseRep;

class ResponseController extends AbstractController
{
    
    /**
     * @Method({"GET"})
     * @Route("/admin/response/listing", name="admin_response_listing")
     */
    public function listing(ResponseRep $response_rep)
    {
        $rows = $response_rep->findAll();
        return $this->render('admin/listing/response.html.twig', [
            'url' => 'response',
            'rows' => $rows,
        ]);
    }
    
    /**
     * @Method({"GET"})
     * @Route("/admin/response/edit/{id}", name="admin_response_edit")
     */
    public function edit(ResponseRep $response_rep, $id)
    {
        $response = $response_rep->find($id);
        $form = $this->createForm(\App\Form\QuestionFormType::class, $response);
        return $this->render('admin/form/response.html.twig', [
            'url' => 'admin - edit',
            'form_edit' => $form->createView(),
        ]);
    }
    
    /**
     * @Method({"GET"})
     * @Route("/admin/response/delete/{id}", name="admin_response_delete")
     */
    public function delete(ResponseRep $response_rep, $id)
    {
        $rows = $response_rep->find($id);
        return $this->render('admin/listing/response.html.twig', [
            'url' => 'admin - delete',
            'rows' => $rows,
        ]);
    }
    
}
