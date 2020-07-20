<?php
/* src/Controller/Admin/BodyController.php */

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
    
    private $body_rep;
    private $body_edit;
 
    public function __construct(BodyRep $body_rep, BodyFormType $body_form)
    {
        $this->body_rep = $body_rep;
        $this->body_edit = $body_form;
    }
    
    /* ********************************************************************** */
    
    /**
     * ENTITIES
     * @Route({"GET"})
     * @Route("/src", name="admin_entities")
     */
    public function getEntities()
    {
        $finder = new EntitiesRep();
        $entities = $finder->getEntities();
        sort($entities);
        return $entities;
    }
    
    /**
     * LISTING
     * @Route({"GET"})
     * @Route("/admin/body/listing", name="admin_body_listing")
     */
    public function listing()
    {
        $entities = $this->getEntities();
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
        if (!$this->getUser()):
            return $this->redirectToRoute('login');
        endif;
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
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/body.html.twig', [
                'url' => 'admin - edit',
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
        if (!$this->getUser()):
            return $this->redirectToRoute('login');
        endif;
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
                'rows' => $rows,
            ]);
        else:
            return $this->render('admin/form/body.html.twig', [
                'url' => 'admin - new',
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
