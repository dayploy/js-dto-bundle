<?php

namespace Dayploy\JsDtoBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('js_dto');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode->children()
            ->scalarNode('source_directory')
                ->defaultValue('/srv/app/src')
            ->end()
            ->scalarNode('destination_directory')
                ->defaultValue('/srv/app/assets/model')
            ->end()
            ->scalarNode('model_path')
                ->defaultValue('model')
            ->end()
        ;

        return $treeBuilder;
    }
}
