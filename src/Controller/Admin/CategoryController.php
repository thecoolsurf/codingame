<?php
// src/Controller/Admin/CategoryController.php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Admin\EntitiesRepository as EntitiesRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;
use App\Form\CategoryFormType;
use App\Entity\Category;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 * @IsGranted("ROLE_ADMIN")
 */

class CategoryController extends AbstractController
{
    
    private $entities_rep;
    private $category_rep;
    private $category_edit;
 
    public function __construct(EntitiesRep $entities_rep, CategoryRep $category_rep, CategoryFormType $category_form)
    {
        $this->entities_rep = $entities_rep;
        $this->category_rep = $category_rep;
        $this->category_edit = $category_form;
    }
    
    /* ********************************************************************** */
    
    /**
     * LISTING
     * @Route({"GET"})
     * @Route("/admin/category/listing", name="admin_category_listing")
     */
    public function listing()
    {
        $entities = $this->entities_rep->getEntities();
        $rows = $this->category_rep->findAll();
        return $this->render('admin/listing/category.html.twig', [
            'url' => 'admin - listing',
            'entities' => $entities,
            'rows' => $rows,
        ]);
    }
    
    /**
     * EDIT
     * @Route({"GET"})
     * @Route("/admin/category/edit/{id}", name="admin_category_edit")
     */
    public function edit(Request $request, $id)
    {
        $entities = $this->entities_rep->getEntities();
        $category = $this->category_rep->find($id);
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->category_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->render('admin/listing/category.html.twig', [
                'url' => 'admin - listing',
                'entities' => $entities,
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/category.html.twig', [
                'url' => 'admin - edit',
                'entities' => $entities,
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * NEW
     * @Route({"GET"})
     * @Route("/admin/category/new", name="admin_category_new")
     */
    public function new(Request $request)
    {
        $entities = $this->entities_rep->getEntities();
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $rows = $this->category_rep->findAll();
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
            return $this->redirectToRoute('admin_category_listing',[
                'url' => 'admin - listing',
                'entities' => $entities,
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/category.html.twig', [
                'url' => 'admin - new',
                'entities' => $entities,
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * DELETE
     * @Route({"GET"})
     * @Route("/admin/category/delete/{id}", name="admin_category_delete")
     */
    public function delete($id)
    {
        $category = $this->category_rep->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('admin_category_listing');
    }
    
}
