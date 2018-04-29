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
     * @Route("/vk/user/followers", name="vk_user_followers")
     */
    public function userInfo(Request $request) {
        $id = $request->query->get('id');

        $followers = $this->vkUserService->getUserFollowers($id);
        $friends = $this->vkUserService->getUserFriends($id);

        return $this->render('vk/user_followers.html.twig', [
            'followers' => $followers,
            'friends' => $friends
        ]);
    }

}