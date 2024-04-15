<?php

return function(\Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator $definition): void {
    $definition->rootNode()
        ->children()
            ->arrayNode('drivers')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('wkhtmltopdf')
                        ->children()
                            ->scalarNode('driver')->defaultValue('')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end()
    ->end()
    ;
};