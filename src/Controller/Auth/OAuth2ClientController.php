<?php

namespace App\Controller\Auth;

use App\Client\OAuth2Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OAuth2ClientController extends Controller
{
    private $auth2Client;

    public function __construct(OAuth2Client $auth2Client)
    {
        $this->auth2Client = $auth2Client;
    }

    /**
     * @Route("/login/vk/client", name="vk_oauth2_client")
     */
    public function loginVkClient()
    {
        return $this->auth2Client->redirect();
    }

    /**
     * @Route("/api", name="api")
     */
    public function login()
    {
        die(111);

//        return new Response('<html><body>Hello</body></html>');
    }
}