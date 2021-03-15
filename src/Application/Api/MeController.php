<?php
declare(strict_types=1);

namespace App\Application\Api;

use App\Application\Normalizer\UserNormalizer;
use App\Infrastructure\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route(path="/me", name="me_")
 */
class MeController extends AbstractController
{
    /**
     * @Route(path="", name="index", methods={"GET"})
     *
     * @param \Symfony\Component\Serializer\SerializerInterface $serializer
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(SerializerInterface $serializer): JsonResponse
    {
        $user = $this->getUser();

        $userJson = $serializer->serialize($user, 'json');

        return JsonResponse::fromJsonString($userJson);
    }
}
