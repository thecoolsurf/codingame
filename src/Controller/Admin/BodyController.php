<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Entity\Body;

class BodyController extends AbstractController
{
    
    /**
     * @Method({"GET"})
     * @Route("/admin/body/listing", name="admin_body_listing")
     */
    public function listing(BodyRep $body_rep)
    {
        $rows = $body_rep->findAll();
        return $this->render('admin/listing/body.html.twig', [
            'url' => 'admin - listing',
            'rows' => $rows,
        ]);
    }
    
    /**
     * @Method({"GET"})
     * @Route("/admin/body/edit/{id}", name="admin_body_edit")
     */
    public function edit(BodyRep $body_rep, $id)
    {
        $body = $body_rep->find($id);
        $form = $this->createForm(\App\Form\BodyFormType::class, $body);
        return $this->render('admin/form/body.html.twig', [
            'url' => 'admin - edit',
            'form_edit' => $form->createView(),
        ]);
    }
    
    /**
     * @Method({"GET"})
     * @Route("/admin/body/delete/{id}", name="admin_body_delete")
     */
    public function delete(BodyRep $body_rep, $id)
    {
        $rows = $body_rep->find($id);
        return $this->render('admin/listing/body.html.twig', [
            'url' => 'admin - delete',
            'rows' => $rows,
        ]);
    }
    
}
