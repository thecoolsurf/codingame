<?php
// src/Controller/Admin/BodyController.php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Admin\EntitiesRepository as EntitiesRep;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Entity\Body;
use App\Form\BodyFormType;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */

class BodyController extends AbstractController
{
    
    private $entities_rep;
    private $body_rep;
    private $body_edit;
 
    public function __construct(EntitiesRep $entities_rep, BodyRep $body_rep, BodyFormType $body_form)
    {
        $this->entities_rep = $entities_rep;
        $this->body_rep = $body_rep;
        $this->body_edit = $body_form;
    }
    
    /* ********************************************************************** */
    
    /**
     * LISTING
     * @Route({"GET"})
     * @Route("/admin/body/listing", name="admin_body_listing")
     */
    public function listing()
    {
        $entities = $this->entities_rep->getEntities();
        $body = $this->body_rep->findAll();
        return $this->render('admin/listing/body.html.twig', [
            'url' => 'admin - listing',
            'entities' => $entities,
            'rows' => $body,
        ]);
    }
    
    /**
     * EDIT
     * @Route({"GET"})
     * @Route("/admin/body/edit/{id}", name="admin_body_edit")
     */
    public function edit(Request $request, $id)
    {
        $entities = $this->entities_rep->getEntities();
        $body = $this->body_rep->find($id);
        $form = $this->createForm(BodyFormType::class, $body);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->body_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->render('admin/listing/body.html.twig', [
                'url' => 'admin - listing',
                'entities' => $entities,
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/body.html.twig', [
                'url' => 'admin - edit',
                'entities' => $entities,
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * NEW
     * @Route({"GET"})
     * @Route("/admin/body/new", name="admin_body_new")
     */
    public function new(Request $request)
    {
        $entities = $this->entities_rep->getEntities();
        $body = new Body();
        $form = $this->createForm(BodyFormType::class, $body);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->body_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->redirectToRoute('admin_body_listing',[
                'url' => 'admin - listing',
                'entities' => $entities,
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/body.html.twig', [
                'url' => 'admin - new',
                'entities' => $entities,
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * DELETE
     * @Route({"GET"})
     * @Route("/admin/body/delete/{id}", name="admin_body_delete")
     */
    public function delete($id)
    {
        $body = $this->body_rep->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($body);
        $em->flush();
        return $this->redirectToRoute('admin_body_listing');
    }
    
}
