<?php

namespace App\Message\User;

use App\Entity\User;

class GetUserListMessage
{
    /**
     * @param int $limit
     * @param int $offset
     */
    public function __construct(
        protected int $limit = User::LIMIT,
        protected int $offset = 0
    ) {
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }
}
