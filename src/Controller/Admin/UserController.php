<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Home\UserRepository as UserRep;

class UserController extends AbstractController
{
    
    /**
     * @Method({"GET"})
     * @Route("/admin/user/listing", name="admin_user_listing")
     */
    public function listing(UserRep $user_rep)
    {
        $rows = $user_rep->findAll();
        return $this->render('admin/listing/user.html.twig', [
            'url' => 'user',
            'rows' => $rows,
        ]);
    }
    
    /**
     * @Method({"GET"})
     * @Route("/admin/user/edit/{id}", name="admin_user_edit")
     */
    public function edit(UserRep $user_rep, $id)
    {
        $user = $user_rep->find($id);
        $form = $this->createForm(\App\Form\UserFormType::class, $user);
        return $this->render('admin/form/user.html.twig', [
            'url' => 'admin - edit',
            'form_edit' => $form->createView(),
        ]);
    }
    
    /**
     * @Method({"GET"})
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     */
    public function delete(UserRep $user_rep, $id)
    {
        $rows = $user_rep->find($id);
        return $this->render('admin/listing/user.html.twig', [
            'url' => 'admin - delete',
            'rows' => $rows,
        ]);
    }
    
}
