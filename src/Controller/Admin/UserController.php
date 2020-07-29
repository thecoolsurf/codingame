<?php
// src/Controller/Admin/UserController.php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Admin\EntitiesRepository as EntitiesRep;
use App\Repository\UserRepository as UserRep;
use App\Form\Admin\UserFormType;
use App\Entity\User;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */

class UserController extends AbstractController
{
    
    private $entities_rep;
    private $user_rep;
    private $user_edit;
 
    public function __construct(EntitiesRep $entities_rep, UserRep $user_rep, UserFormType $user_form)
    {
        $this->entities_rep = $entities_rep;
        $this->user_rep = $user_rep;
        $this->user_edit = $user_form;
    }
    
    /* ********************************************************************** */
    
    /**
     * LISTING
     * @Route("/admin/user/listing", name="admin_user_listing")
     */
    public function listing()
    {
        $entities = $this->entities_rep->getEntities();
        $rows = $this->user_rep->findAll();
        return $this->render('admin/listing/user.html.twig', [
            'title' => 'Admin - listing user',
            'entities' => $entities,
            'rows' => $rows,
        ]);
    }
    
    /**
     * EDIT
     * @Route("/admin/user/edit/{id}", name="admin_user_edit")
     */
    public function edit(Request $request, $id)
    {
        $entities = $this->entities_rep->getEntities();
        $user = $this->user_rep->find($id);
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->user_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->render('admin/listing/user.html.twig', [
                'title' => 'Admin - listing user',
                'entities' => $entities,
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/user.html.twig', [
                'title' => 'Admin - edit user',
                'entities' => $entities,
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * NEW
     * @Route("/admin/user/new", name="admin_user_new")
     */
    public function new(Request $request)
    {
        $entities = $this->entities_rep->getEntities();
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->user_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->redirectToRoute('admin_user_listing',[
                'title' => 'Admin - listing user',
                'entities' => $entities,
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/user.html.twig', [
                'title' => 'Admin - new user',
                'entities' => $entities,
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * DELETE
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     */
    public function delete($id)
    {
        $user = $this->user_rep->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('admin_user_listing');
    }
    
}
