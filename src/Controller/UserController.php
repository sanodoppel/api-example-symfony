<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User\UserFormType;
use App\Service\UserService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[OA\Tag(name: 'User')]
#[Security(name: 'Bearer')]
class UserController extends BaseController
{
    /**
     * @param UserService $userService
     */
    public function __construct(private readonly UserService $userService)
    {
    }

    #[OA\RequestBody(
        content: new OA\MediaType(
            mediaType: 'application/json',
            schema: new OA\Schema(
                ref: new Model(type: UserFormType::class)
            )
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Create new user',
        content: new OA\JsonContent(
            type: 'object'
        )
    )]
    #[Route('/api/user', name: 'api_user_create', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $form = $this->createForm(UserFormType::class, new User());
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isValid()) {
            $this->userService->create($form);

            return new JsonResponse(null, JsonResponse::HTTP_CREATED);
        }

        return new JsonResponse($this->getFormErrors($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    #[OA\Response(
        response: 200,
        description: 'Get current user',
        content: new OA\JsonContent(
            ref: new Model(type: User::class, groups: ['user_get'])
        )
    )]
    #[Route('/api/user', name: 'api_user_get', methods: ['GET'])]
    public function get(): JsonResponse
    {
        return new JsonResponse($this->normalizer->normalize($this->getUser(), 'array', ['groups' => ['user_get']]));
    }
}
