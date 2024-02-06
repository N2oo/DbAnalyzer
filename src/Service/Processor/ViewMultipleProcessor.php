<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\View\ViewMultipleResponseDTO;

class ViewMultipleProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $results = new ViewMultipleResponseDTO();
        $views = $data->getViews();
        if(empty($views)){
            return $results;
        }
        foreach($views as $view){
            $this->em->persist($view);
            $this->em->flush();
            $results->addView($view);
        }
        return $results;
    }
}