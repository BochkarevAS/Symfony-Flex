<?php

namespace App\Controller\Auth;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{

    /**
     * @Route("/login", name="user_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

//    /**
//     * @Route("/api", name="api")
//     */
//    public function loginVk()
//    {
////        die("API here");
//        return $this->render('base.html.twig');
//    }








    /**
     * @Route("/ttt", name="indexs")
     */
    public function indexAction()
    {

        die("API here");

        return array(
            'facebookAppId' => $this->container->getParameter('facebookAppId'),
            'user'          => null !== $this->get('security.context') ? $this->getUser() : $this->get('security.context')->getToken(),
        );
    }

    /**
     * @Route("/api", name="api")
     */
    public function loginS(Request $request)
    {

        return $this->redirect($request->server->get('HTTP_REFERER', $this->generateUrl('indexs')));
    }









    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout()
    {
        throw new \Exception('this should not be reached!');
    }

}