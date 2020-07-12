<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Practice\CategoryRepository as CategoryRep;

class CategoryController extends AbstractController
{
    
    /**
     * @Method({"GET"})
     * @Route("/admin/category/listing", name="admin_category_listing")
     */
    public function listing(CategoryRep $category_rep)
    {
        $rows = $category_rep->findAll();
        return $this->render('admin/listing/category.html.twig', [
            'url' => 'admin - listing',
            'rows' => $rows,
        ]);
    }
    
    /**
     * @Method({"GET"})
     * @Route("/admin/category/edit/{id}", name="admin_category_edit")
     */
    public function edit(CategoryRep $category_rep, $id)
    {
        $category = $category_rep->find($id);
        $form = $this->createForm(\App\Form\CategoryFormType::class, $category);
        return $this->render('admin/form/category.html.twig', [
            'url' => 'admin - edit',
            'form_edit' => $form->createView(),
        ]);
    }
    
    /**
     * @Method({"GET"})
     * @Route("/admin/category/delete/{id}", name="admin_category_delete")
     */
    public function delete(CategoryRep $category_rep, $id)
    {
        $rows = $category_rep->find($id);
        return $this->render('admin/listing/category.html.twig', [
            'url' => 'admin - delete',
            'rows' => $rows,
        ]);
    }
    
}
