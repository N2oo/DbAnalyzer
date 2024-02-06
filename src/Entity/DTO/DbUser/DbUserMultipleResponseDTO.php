<?php

namespace App\Entity\DTO\DbUser;

use App\Entity\DbUser as DbUserEntity;

final class DbUserMultipleResponseDTO

{
    public function __construct(
        protected array $DbUsers = []
    )
    {}

    public function addDbUser(DbUserEntity $DbUser):void
    {
        $this->DbUsers[] = $DbUser;
    }

    /**
     * @return ?DbUserEntity[]
     */
    public function getDbUsers():?array
    {
        return $this->DbUsers;
    }
    

}