<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\Index\IndexMultipleResponseDTO;

class IndexMultipleProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $results = new IndexMultipleResponseDTO();
        $indexs = $data->getIndexs();
        if(empty($indexs)){
            return $results;
        }
        foreach($indexs as $index){
            $this->em->persist($index);
            $this->em->flush();
            $results->addIndex($index);
        }
        return $results;
    }
}