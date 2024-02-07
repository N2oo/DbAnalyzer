<?php

namespace App\DependencyInjection\Compiler;

use App\Decorator\JoinResolver;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
/**
 * Ajout des décorateurs pour toutes les classes implémentant une interface donnée
 * https://stackoverflow.com/questions/57443470/decorate-all-services-that-implement-the-same-interface-by-default
 */
class MultipleEntityProcessorInterfaceDecoratorPass implements CompilerPassInterface
{
    private const TAG_NAME = "app.join_resolver_tagged";

    public function process(ContainerBuilder $container){
        
        if (!$container->has(JoinResolver::class)) {
            // If the decorator isn't registered in the container you could register it here
            return;
        }            

        $taggedServices = $container->findTaggedServiceIds(self::TAG_NAME);
        foreach ($taggedServices as $id => $tags) {

            // skip the decorator, we do it's not self-decorated
            if ($id === JoinResolver::class) {
                continue;
            }

            $decoratedServiceId = $this->generateAliasName($id);
            

            // Add the new decorated service.
            $container->register($decoratedServiceId, JoinResolver::class)
                ->setDecoratedService($id)
                ->setPublic(true)
                ->setAutowired(true);
        }
    }
    /**
     * Generate a snake_case service name from the service class name
     */
    private function generateAliasName($serviceName)
    {
        if (false !== strpos($serviceName, '\\')) {
            $parts = explode('\\', $serviceName);
            $className = end($parts);                
            $alias = strtolower(preg_replace('/[A-Z]/', '_\\0', lcfirst($className)));
        } else {
            $alias = $serviceName;
        }
        return $alias . '_decorator';            
    }
}