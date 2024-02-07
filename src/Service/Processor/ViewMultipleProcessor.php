<?php

namespace App\Service\Processor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\DTO\View\ViewMultipleDTO;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\DTO\View\ViewMultipleResponseDTO;

class ViewMultipleProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {

    }
    /**
     * @param ViewMultipleDTO $data
     */
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