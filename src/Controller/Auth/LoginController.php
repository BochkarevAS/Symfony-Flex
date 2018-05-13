<?php

namespace App\Controller\Auth;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{

    /**
     * @Route("/login", name="login")
     */
    public function loginCheck(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

//    /**
//     * @Route("/login", name="login")
//     */
//    public function login(Request $request, AuthenticationUtils $authenticationUtils)
//    {
//        return $this->render('home/homepage.html.twig');
//    }

    /**
     * @Route("/api", name="api")
     */
    public function loginAPI(Request $request)
    {
//        return $this->redirect($request->server->get('HTTP_REFERER', $this->generateUrl('user_login')));

        return new Response('<html><body>Hello</body></html>');
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout()
    {
        throw new \Exception('this should not be reached!');
    }
}