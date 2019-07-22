<?php

namespace App\DependencyInjection\Compiler;

use App\Service\Calculator\CalculatorChain;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CalculatorPass implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(CalculatorChain::class)) {
            return;
        }

        $definition = $container->findDefinition(CalculatorChain::class);

        $taggedServices = $container->findTaggedServiceIds('app.calculator');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addCalculator', [new Reference($id)]);
        }
    }
}
