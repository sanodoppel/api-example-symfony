<?php

namespace App\Controller;

use App\DTO\CreateUserDTO;
use Management\Command\CreateUser;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends BaseController
{
    /**
     * @OA\RequestBody(
     *     @OA\MediaType(mediaType="application/json",
     *         @OA\Schema(ref=@Model(type=CreateUser::class))
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
     */
    #[Route("/api/user/register", name: "api_user_register", methods: ["POST"])]
    public function register(Request $request, MessageBusInterface $commandBus): JsonResponse
    {

        $data = json_decode($request->getContent(), false);
        $dto = new CreateUserDTO($data->username, $data->password);
        $errors = $this->validator->validate(new CreateUserDTO($data->username, $data->password));

        if (!$errors->count()) {
            $commandBus->dispatch(new CreateUser($dto));
            return new JsonResponse(null, JsonResponse::HTTP_CREATED);
        }

        return new JsonResponse($this->getErrors($errors), JsonResponse::HTTP_BAD_REQUEST);
    }
}
