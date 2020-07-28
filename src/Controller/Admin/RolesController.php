<?php
// src/Controller/Admin/BodyController.php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Admin\EntitiesRepository as EntitiesRep;
use App\Repository\Security\RolesRepository as RolesRep;
use App\Entity\Roles;
use App\Form\RolesFormType;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */

class RolesController extends AbstractController
{
    
    private $entities_rep;
    private $roles_rep;
    private $roles_edit;
 
    public function __construct(EntitiesRep $entities_rep, RolesRep $roles_rep, RolesFormType $roles_form)
    {
        $this->entities_rep = $entities_rep;
        $this->roles_rep = $roles_rep;
        $this->roles_edit = $roles_form;
    }
    
    /* ********************************************************************** */
    
    /**
     * LISTING
     * @Route({"GET"})
     * @Route("/admin/roles/listing", name="admin_roles_listing")
     */
    public function listing()
    {
        $entities = $this->entities_rep->getEntities();
        $roles = $this->roles_rep->findAll();
        return $this->render('admin/listing/roles.html.twig', [
            'title' => 'Admin - listing roles',
            'entities' => $entities,
            'rows' => $roles,
        ]);
    }
    
    /**
     * EDIT
     * @Route({"GET"})
     * @Route("/admin/roles/edit/{id}", name="admin_roles_edit")
     */
    public function edit(Request $request, $id)
    {
        $entities = $this->entities_rep->getEntities();
        $roles = $this->roles_rep->find($id);
        $form = $this->createForm(RolesFormType::class, $roles);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->roles_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->render('admin/listing/roles.html.twig', [
                'title' => 'Admin - listing roles',
                'entities' => $entities,
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/roles.html.twig', [
                'title' => 'Admin - edit roles',
                'entities' => $entities,
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * NEW
     * @Route({"GET"})
     * @Route("/admin/roles/new", name="admin_roles_new")
     */
    public function new(Request $request)
    {
        $entities = $this->entities_rep->getEntities();
        $roles = new Roles();
        $form = $this->createForm(RolesFormType::class, $roles);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->roles_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->redirectToRoute('admin_roles_listing',[
                'title' => 'Admin - listing roles',
                'entities' => $entities,
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/roles.html.twig', [
                'title' => 'Admin - new roles',
                'entities' => $entities,
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * DELETE
     * @Route({"GET"})
     * @Route("/admin/roles/delete/{id}", name="admin_roles_delete")
     */
    public function delete($id)
    {
        $roles = $this->roles_rep->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($roles);
        $em->flush();
        return $this->redirectToRoute('admin_roles_listing');
    }
    
}
