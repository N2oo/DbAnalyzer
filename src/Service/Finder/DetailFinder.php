<?php

namespace App\Service\Finder;

use App\Entity\Table;
use App\Repository\DetailRepository;

class DetailFinder
{
    public function __construct(
        private DetailRepository $detailRepository
    ) {}

    public function findByTabId(Table $table, $shouldHydrate = false){
        $results = $this->detailRepository->findByTabId($table);
        if ($shouldHydrate)
        {
            $this->hydrate($results);
        }
        return $results;
    }

    public function findByOriginalTableId(Table $table, $shouldHydrate = false)
    {
        $results = $this->detailRepository->findByOriginalTableId($table);
        if ($shouldHydrate)
        {
            $this->hydrate($results);
        }
        return $results;
    }

    private function hydrate(array $details)
    {
        $this->detailRepository->hydrate($details);
    }
    private function hydrateOne($detail)
    {
        $this->hydrate([$detail]);
    }
}