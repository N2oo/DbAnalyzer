<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\DbUser\DbUserMultipleDTO;
use App\Entity\DTO\DbUser\DbUserMultipleResponseDTO;

class DbUserMultipleProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }
    /**
     * @param DbUserMultipleDTO $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $results = new DbUserMultipleResponseDTO();
        $dbUsers = $data->getDbUsers();
        if(empty($dbUsers)){
            return $results;
        }
        foreach($dbUsers as $dbUser){
            $this->em->persist($dbUser);
            $this->em->flush();
            $results->addDbUser($dbUser);
        }
        return $results;
    }
}