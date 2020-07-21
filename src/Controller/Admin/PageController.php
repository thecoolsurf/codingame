<?php
// src/Controller/Admin/PageController.php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Home\PageRepository as PageRep;
use App\Entity\Page;
use App\Form\PageFormType;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */

class PageController extends AbstractController
{
    
    private $page_rep;
    private $page_edit;
 
    public function __construct(PageRep $page_rep, PageFormType $page_form)
    {
        $this->page_rep = $page_rep;
        $this->page_edit = $page_form;
    }
    
    /* ********************************************************************** */
    
    /**
     * LISTING
     * @Route({"GET"})
     * @Route("/admin/page/listing", name="admin_page_listing")
     */
    public function listing()
    {
        $page = $this->page_rep->findAll();
        return $this->render('admin/listing/page.html.twig', [
            'url' => 'admin - listing',
            'rows' => $page,
        ]);
    }
    
    /**
     * EDIT
     * @Route({"GET"})
     * @Route("/admin/page/edit/{id}", name="admin_page_edit")
     */
    public function edit(Request $request, $id)
    {
        if (!$this->getUser()):
            return $this->redirectToRoute('login');
        endif;
        $page = $this->page_rep->find($id);
        $form = $this->createForm(PageFormType::class, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->page_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->render('admin/listing/page.html.twig', [
                'url' => 'admin - listing',
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/page.html.twig', [
                'url' => 'admin - edit',
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * NEW
     * @Route({"GET"})
     * @Route("/admin/page/new", name="admin_page_new")
     */
    public function new(Request $request)
    {
        if (!$this->getUser()):
            return $this->redirectToRoute('login');
        endif;
        $page = new Page();
        $form = $this->createForm(PageFormType::class, $page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->page_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->redirectToRoute('admin_page_listing',[
                'url' => 'admin - listing',
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/page.html.twig', [
                'url' => 'admin - new',
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * DELETE
     * @Route({"GET"})
     * @Route("/admin/page/delete/{id}", name="admin_page_delete")
     */
    public function delete($id)
    {
        $page = $this->page_rep->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();
        return $this->redirectToRoute('admin_page_listing');
    }
    
}
