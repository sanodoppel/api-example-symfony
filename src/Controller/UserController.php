<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User\UserFormType;
use App\Service\UserService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class UserController extends BaseController
{
    /**
     * @param UserService $userService
     */
    public function __construct(private UserService $userService)
    {
    }

    /**
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *         @OA\Schema(ref=@Model(type=UserFormType::class))
     *     )
     * )
     * @OA\Response(
     *     response=201,
     *     description="Register new user",
     *     @OA\JsonContent(
     *         type="object"
     *     )
     * )
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     */
    #[Route("/api/user/register", name: "api_user_register", methods: ["POST"])]
    public function register(Request $request): JsonResponse
    {
        $form = $this->createForm(UserFormType::class, new User());
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->register($form);

            return new JsonResponse(null, JsonResponse::HTTP_CREATED);
        }

        return new JsonResponse($this->getFormErrors($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @return JsonResponse
     * @throws ExceptionInterface
     *
     * @OA\Response(
     *     response=200,
     *     description="Get current user",
     *     @OA\JsonContent(
     *         ref=@Model(type=User::class, groups={"user_get"})
     *     )
     * )
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     */
    #[Route("/api/user", name: "api_user_get", methods: ["GET"])]
    public function get(): JsonResponse
    {
        return new JsonResponse($this->normalizer->normalize($this->getUser(), 'array', ['groups' => ['user_get']]));
    }
}
