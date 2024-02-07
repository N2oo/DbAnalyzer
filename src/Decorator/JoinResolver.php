<?php

namespace App\Decorator;

use Psr\Log\LoggerInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Service\Processor\MultipleEntityProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(ProcessorInterface::class)]
class JoinResolver implements MultipleEntityProcessorInterface
{
    public function __construct(
        private ProcessorInterface $inner,
        private LoggerInterface $logger
    ){

    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $this->logger->critical("hello");
        $this->inner->process($data,$operation,$uriVariables,$context);
    }
}