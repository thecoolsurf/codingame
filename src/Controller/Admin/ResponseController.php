<?php
// src/Controller/Admin/ResponseController.php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Admin\EntitiesRepository as EntitiesRep;
use App\Repository\Practice\ResponseRepository as ResponseRep;
use App\Form\ResponseFormType;
use App\Entity\Response;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */

class ResponseController extends AbstractController
{
    
    private $entities_rep;
    private $response_rep;
    private $response_edit;
 
    public function __construct(EntitiesRep $entities_rep, ResponseRep $response_rep, ResponseFormType $response_form)
    {
        $this->entities_rep = $entities_rep;
        $this->response_rep = $response_rep;
        $this->response_edit = $response_form;
    }
    
    /* ********************************************************************** */
    
    /**
     * LISTING
     * @Route({"GET"})
     * @Route("/admin/response/listing", name="admin_response_listing")
     */
    public function listing()
    {
        $entities = $this->entities_rep->getEntities();
        $rows = $this->response_rep->findAll();
        return $this->render('admin/listing/response.html.twig', [
            'url' => 'admin - listing',
            'entities' => $entities,
            'rows' => $rows,
        ]);
    }
    
    /**
     * EDIT
     * @Route({"GET"})
     * @Route("/admin/response/edit/{id}", name="admin_response_edit")
     */
    public function edit(Request $request, $id)
    {
        $entities = $this->entities_rep->getEntities();
        $response = $this->response_rep->find($id);
        $form = $this->createForm(ResponseFormType::class, $response);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->response_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->render('admin/listing/response.html.twig', [
                'url' => 'admin - listing',
                'entities' => $entities,
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/response.html.twig', [
                'url' => 'admin - edit',
                'entities' => $entities,
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * NEW
     * @Route({"GET"})
     * @Route("/admin/response/new", name="admin_response_new")
     */
    public function new(Request $request)
    {
        $entities = $this->entities_rep->getEntities();
        $response = new Response();
        $form = $this->createForm(ResponseFormType::class, $response);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->response_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->redirectToRoute('admin_response_listing',[
                'url' => 'admin - listing',
                'entities' => $entities,
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/response.html.twig', [
                'url' => 'admin - new',
                'entities' => $entities,
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * DELETE
     * @Route({"GET"})
     * @Route("/admin/response/delete/{id}", name="admin_response_delete")
     */
    public function delete($id)
    {
        $response = $this->response_rep->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($response);
        $em->flush();
        return $this->redirectToRoute('admin_response_listing');
    }
    
}
