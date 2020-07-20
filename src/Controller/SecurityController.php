<?php
/* src/Controller/SecurityController.php */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\Home\BodyRepository as BodyRep;
use App\Repository\Practice\CategoryRepository as CategoryRep;
use App\Repository\Practice\QuestionRepository as QuestionRep;


class SecurityController extends AbstractController
{

    private $body_rep;
    private $category_rep;
    private $question_rep;
    
    public function __construct(BodyRep $body_rep, CategoryRep $category_rep, QuestionRep $question_rep)
    {
        $this->body_rep = $body_rep;
        $this->category_rep = $category_rep;
        $this->question_rep = $question_rep;
    }
    
    /**
     * @Method({"POST"})
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $bodies = $this->body_rep->findBodyBySlug($request)[0];
        $navigation = $this->category_rep->getNavigationCategories($this->category_rep, $this->question_rep);
        if ($this->getUser()):
            return $this->redirectToRoute('admin_user_listing');
        endif;
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'url' => 'Login',
            'bodies' => $bodies,
            'categories' => $navigation[0],
            'questions' => $navigation[1],
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * @Method({"GET"})
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
