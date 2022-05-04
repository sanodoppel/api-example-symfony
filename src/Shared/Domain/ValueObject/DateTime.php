<?php

namespace Shared\Domain\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;

class DateTime
{
    /**
     * @param DateTimeInterface|null $date
     */
    public function __construct(private ?DateTimeInterface $date = new DateTimeImmutable())
    {
    }

    public function date(): DateTimeInterface
    {
        return $this->date;
    }

    public function value(): string
    {
        return $this->date()->format(DateTimeInterface::ATOM);
    }
}
