<?php

namespace App\Controller\API\VK;

use App\Service\API\VK\VkFollowerService;
use App\Service\API\VK\VkFriendService;
use App\Service\API\VK\VkRenderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class VkUserInfoController extends Controller
{
//    private $vkRenderService;

//    public function __construct(VkRenderInterface $vkRenderService)
//    {
//        $this->vkRenderService = $vkRenderService;
//    }

    /**
     * @Route("/vk/user/followers", name="vk_user_followers", options={"expose"=true})
     */
    public function getFollowers(Request $request, VkRenderInterface $followerService)
    {
        $id = $request->query->get('id');
//        $followerService = $this->container->get(VkFollowerService::class);
        $followers = $followerService->render($id);
        $json = $this->get('serializer')->serialize($followers, 'json');

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/vk/user/friends", name="vk_user_friends", options={"expose"=true})
     */
    public function getFriends(Request $request)
    {
        $id = $request->query->get('id');
//        $friends = $this->vkRenderService->render($id);
        $friendService = $this->container->get(VkFriendService::class);
        $friends = $friendService->render($id);
        $json = $this->get('serializer')->serialize($friends, 'json');

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/vk/user/info", name="vk_user_info")
     */
    public function userInfo(Request $request)
    {
        $id = $request->query->get('id');

        return $this->render('vk/user_info.html.twig', [
            'user_id' => $id
        ]);
    }
}