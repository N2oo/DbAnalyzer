<?php
namespace App\Service\Finder;

use App\Entity\Table;
use App\Repository\DbUserRepository;

class dbUserFinder
{
    public function __construct(
        private DbUserRepository $dbUserRepository
    ) {
    }

    public function findUserCanAccessTable(Table $table)
    {
        return $this->dbUserRepository->findByTableId($table);
    }
}