<?php

namespace Backlog\AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('backlog_app');

        $rootNode
            ->children()
                ->scalarNode('markdown_converter')->defaultValue('simple')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
