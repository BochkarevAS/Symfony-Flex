<?php

namespace App\Controller\API\VK;

use App\Service\API\VK\VkUserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VkUserInfoController extends Controller
{

    private $vkUserService;

    public function __construct(VkUserInterface $vkUserService) {
        $this->vkUserService = $vkUserService;
    }

    /**
     * @Route("/vk/user/info", name="vk_user_info")
     */
    public function userInfo(Request $request) {
        $id = $request->query->get('id');

        $user = $this->vkUserService->userInfo($id);

        return $this->render('vk/user_info.html.twig', [
            'user' => $user
        ]);
    }

}