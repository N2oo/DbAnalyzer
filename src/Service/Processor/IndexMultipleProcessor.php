<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DTO\Index\IndexMultipleDTO;
use App\Entity\DTO\Index\IndexMultipleResponseDTO;

class IndexMultipleProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }
    /**
     * @param IndexMultipleDTO $data
     */
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