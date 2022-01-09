<?php

namespace App\MessageHandler\User;

use App\Message\User\CreateUserMessage;
use App\MessageHandler\CommandHandlerInterface;
use App\Service\UserService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateUserMessageHandler implements MessageHandlerInterface, CommandHandlerInterface
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * @param CreateUserMessage $message
     */
    public function __invoke(CreateUserMessage $message): void
    {
        $this->userService->register($message->getUsername(), $message->getPassword());
    }
}
