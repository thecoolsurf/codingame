<?php
// src/Controller/Security/UserController.php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;
use App\Form\Publics\UserFormType;
use App\Entity\User;


class UserController extends AbstractController
{

    private $body_rep;
    private $category_rep;
    
    public function __construct(BodyRep $body_rep, CategoryRep $category_rep)
    {
        $this->body_rep = $body_rep;
        $this->category_rep = $category_rep;
    }
    
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $bodies = $this->body_rep->findBodyBySlug('login');
        $navigation = $this->category_rep->getNavigationCategories();
        // create user
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
        endif;
        // security
        if ($this->getUser() && $this->isGranted('ROLE_USER')):
            return $this->redirectToRoute('profil');
        elseif ($this->getUser() && $this->isGranted('ROLE_ADMIN')):
            return $this->redirectToRoute('admin_user_listing');
        endif;
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('public/security/login.html.twig', [
            'title' => 'login',
            'bodies' => $bodies,
            'categories' => $navigation[0],
            'questions' => $navigation[1],
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function profil(Request $request)
    {
        $bodies = $this->body_rep->findBodyBySlug('profil');
        $navigation = $this->category_rep->getNavigationCategories();
        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()):
            $datas = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($datas);
            $em->flush();
        endif;
        return $this->render('public/security/register.html.twig', [
            'title' => 'User profil',
            'bodies' => $bodies,
            'categories' => $navigation[0],
            'questions' => $navigation[1],
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    
}
