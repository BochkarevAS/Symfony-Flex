<?php

namespace App\Controller;

use GuzzleHttp\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VkOAuthController extends Controller
{

    private $scope = [
        'notify', 'friends', 'photos', 'audio', 'video', 'stories', 'pages',
        'status', 'notes', 'wall', 'ads', 'offline', 'docs', 'groups',
        'notifications', 'stats', 'email', 'market'
    ];

    /**
     * @Route("/vk_oauth", name="vk_authorize_start")
     */
    public function redirectToAuthorization() {

        $token = $this->get('session')->get('token');

        if ($token) {
            return $this->render('vk/main.html.twig', [
                'token' => $token
            ]);
        }

        $http = [
            'client_id'     => '6453345',
            'redirect_uri'  => 'http://127.0.0.1:8000/vk_oauth/receive',
            'display'       => 'page',
            'response_type' => 'code',
            'scope'         => implode(',', $this->scope)
        ];

        $url = "https://oauth.vk.com/authorize?" . http_build_query($http);

        return $this->redirect($url);
    }

    /**
     * @Route("/vk_oauth/receive/", name="vk_oauth_receive")
     */
    public function receiveAuthorizationCode(Request $request) {

        $code = $request->query->get('code');

        // Если вдруг ошибка. То обработаем по человечески !!!
        if (!$code) {
            $error = $request->get('error');
            $errorDescription = $request->get('error_description');

            return $this->render('error/vk_failed_authorization.html.twig', [
                'error' => $error,
                'errorDescription' => $errorDescription
            ]);
        }

        $client = new Client([
            'base_uri' => 'https://oauth.vk.com',
            'timeout' => 10
        ]);

        $response = $client->request('POST', '/access_token', [
            'form_params' => [
                'client_id'     => '6453345',
                'client_secret' => 'kKI7eT4hIQRNL3i0VV3X',
                'redirect_uri'  => 'http://127.0.0.1:8000/vk_oauth/receive',
                'code'          => $code
            ]
        ]);

        $contents = $response->getBody()->getContents();

        $list = json_decode($contents, true);
        $token = $list['access_token'];

        $this->get('session')->set('token', $token);

        dump($list);
        die;
    }
}