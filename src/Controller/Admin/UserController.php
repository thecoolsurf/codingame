<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository as UserRep;
use App\Form\UserFormType;
use App\Entity\User;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */

class UserController extends AbstractController
{
    
    private $user_rep;
    private $user_edit;
 
    public function __construct(UserRep $user_rep, UserFormType $user_form)
    {
        $this->user_rep = $user_rep;
        $this->user_edit = $user_form;
    }
    
    /* ********************************************************************** */
    
    /**
     * LISTING
     * @Route({"GET"})
     * @Route("/admin/user/listing", name="admin_user_listing")
     */
    public function listing()
    {
        $rows = $this->user_rep->findAll();
        return $this->render('admin/listing/user.html.twig', [
            'url' => 'admin - listing',
            'rows' => $rows,
        ]);
    }
    
    /**
     * EDIT
     * @Route({"GET"})
     * @Route("/admin/user/edit/{id}", name="admin_user_edit")
     */
    public function edit(Request $request, $id)
    {
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
                'url' => 'admin - listing',
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/user.html.twig', [
                'url' => 'admin - edit',
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * NEW
     * @Route({"GET"})
     * @Route("/admin/user/new", name="admin_user_new")
     */
    public function new(Request $request)
    {
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
                'url' => 'admin - listing',
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/user.html.twig', [
                'url' => 'admin - new',
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * DELETE
     * @Route({"GET"})
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
