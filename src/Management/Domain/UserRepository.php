<?php

namespace Management\Domain;

interface UserRepository
{
    public function save(User $user): void;
}
