<?php

namespace Shared\Domain;

use Shared\Domain\Event\Event;
use Shared\Domain\ValueObject\Uuid;

abstract class AggregateRoot
{
    protected Uuid $id;

    private array $events = [];

    public function __construct()
    {
        $this->id = Uuid::random();
    }

    final public function pullEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    final protected function record(Event $event): void
    {
        $this->events[] = $event;
    }
}
