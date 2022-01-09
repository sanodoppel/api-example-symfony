<?php

namespace App\MessageHandler\User;

use App\Message\User\GetUserListMessage;
use App\MessageHandler\QueryHandlerInterface;
use App\Service\UserService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetUserListMessageHandler implements MessageHandlerInterface, QueryHandlerInterface
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * @param GetUserListMessage $message
     * @return array
     */
    public function __invoke(GetUserListMessage $message): array
    {
        return $this->userService->list($message->getLimit(), $message->getOffset());
    }
}
