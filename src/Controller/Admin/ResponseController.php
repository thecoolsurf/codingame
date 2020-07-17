<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\Practice\ResponseRepository as ResponseRep;
use App\Form\ResponseFormType;
use App\Entity\Response;

class ResponseController extends AbstractController
{
    
    private $response_rep;
    private $response_edit;
 
    public function __construct(ResponseRep $response_rep, ResponseFormType $response_form)
    {
        $this->response_rep = $response_rep;
        $this->response_edit = $response_form;
    }
    
    /* ********************************************************************** */
    
    /**
     * LISTING
     * @Method({"GET"})
     * @Route("/admin/response/listing", name="admin_response_listing")
     */
    public function listing()
    {
        $rows = $this->response_rep->findAll();
        return $this->render('admin/listing/response.html.twig', [
            'url' => 'admin - listing',
            'rows' => $rows,
        ]);
    }
    
    /**
     * EDIT
     * @Method({"GET"})
     * @Route("/admin/response/edit/{id}", name="admin_response_edit")
     */
    public function edit(Request $request, $id)
    {
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
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/response.html.twig', [
                'url' => 'admin - edit',
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * NEW
     * @Method({"GET"})
     * @Route("/admin/response/new", name="admin_response_new")
     */
    public function new(Request $request)
    {
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
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/response.html.twig', [
                'url' => 'admin - new',
                'form_edit' => $form->createView(),
            ]);
        endif;
    }
    
    /**
     * DELETE
     * @Method({"GET"})
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
