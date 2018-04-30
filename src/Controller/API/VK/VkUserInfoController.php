<?php

namespace App\Controller\API\VK;

use App\Service\API\VK\VkUserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class VkUserInfoController extends Controller
{

    private $vkUserService;

    public function __construct(VkUserInterface $vkUserService) {
        $this->vkUserService = $vkUserService;
    }

    /**
     * @Route("/vk/user/followers", name="vk_user_followers", options={"expose"=true})
     */
    public function userFollowers(Request $request) {
        $id = $request->query->get('id');
        $followers = $this->vkUserService->getUserFollowers($id);
        $json = $this->get('serializer')->serialize($followers, 'json');

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/vk/user/friends", name="vk_user_friends", options={"expose"=true})
     */
    public function userFriends(Request $request) {
        $id = $request->query->get('id');
        $friends = $this->vkUserService->getUserFriends($id);
        $json = $this->get('serializer')->serialize($friends, 'json');

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/vk/user/info", name="vk_user_info")
     */
    public function userInfo(Request $request) {
        $id = $request->query->get('id');

        return $this->render('vk/user_info.html.twig', [
            'user_id' => $id
        ]);
    }
}