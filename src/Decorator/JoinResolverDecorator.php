<?php

namespace App\Decorator;

use Psr\Log\LoggerInterface;
use ApiPlatform\Metadata\Operation;
use App\Service\Processor\MultipleEntityProcessorInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;

/**
 * Décorateur utilisé pour toutes les classes implémentant l'interface MultipleEntityProcessorInterface
 * https://stackoverflow.com/questions/57443470/decorate-all-services-that-implement-the-same-interface-by-default
 * 
 * Raison de la mise en place de l'attribut AutowireDecorated
 * https://symfony.com/doc/7.1/service_container/service_decoration.html#control-the-behavior-when-the-decorated-service-does-not-exist
 */
class JoinResolverDecorator implements MultipleEntityProcessorInterface
{
    public function __construct(
        #[AutowireDecorated]
        private ?MultipleEntityProcessorInterface $inner,
        private LoggerInterface $logger
    ){

    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        return $this->inner->process($data,$operation,$uriVariables,$context);
    }
}