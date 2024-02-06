<?php

namespace App\Entity\DTO\DbUser;

use App\Entity\DbUser as DbUserEntity;

final class DbUserMultipleResponseDTO

{
    public function __construct(
        protected array $dbUsers = []
    )
    {}

    public function addDbUser(DbUserEntity $dbUser):void
    {
        $this->dbUsers[] = $dbUser;
    }

    /**
     * @return ?DbUserEntity[]
     */
    public function getDbUsers():?array
    {
        return $this->dbUsers;
    }
    

}