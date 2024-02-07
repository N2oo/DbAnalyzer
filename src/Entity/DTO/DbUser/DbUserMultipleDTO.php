<?php

namespace App\Entity\DTO\DbUser;

use App\Entity\DbUser as DbUserEntity;

final class DbUserMultipleDTO
{
    public function __construct(
        private ?array $dbUsers = null
    )
    {}

    /**
     * @return ?DbUserEntity[]
     */
    public function getDbUsers(): ?array
    {
        return $this->dbUsers;
    }
}