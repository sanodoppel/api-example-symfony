<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User\UserFormType;
use App\Message\User\CreateUserMessage;
use App\Message\User\GetUserListMessage;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class UserController extends BaseController
{
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
    public function register(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $form = $this->createForm(UserFormType::class);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $commandBus->dispatch(new CreateUserMessage(
                    $form->get('username')->getData(),
                    $form->get('password')->getData())
            );
            return new JsonResponse(null, JsonResponse::HTTP_CREATED);
        }

        return new JsonResponse($this->getFormErrors($form), JsonResponse::HTTP_BAD_REQUEST);
    }

    /**
     * @param MessageBusInterface $queryBus
     * @return JsonResponse
     * @throws ExceptionInterface
     *
     * @OA\Response(
     *     response=200,
     *     description="Get list of users",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref=@Model(type=User::class, groups={"user_list"}))
     *     )
     * )
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     */
    #[Route("/api/user/list", name: "api_user_list", methods: ["GET"])]
    public function list(MessageBusInterface $queryBus): JsonResponse
    {
        return new JsonResponse(
            $this->normalizer->normalize(
                $queryBus->dispatch(new GetUserListMessage())->last(HandledStamp::class)->getResult(),
                'array',
                ['groups' => ['user_list']]
            )
        );
    }
}
