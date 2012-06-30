<?php

namespace Backlog\MarkdownBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConverterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $name = $container->getParameter('bl_markdown.converter_name');
        $container->getParameterBag()->remove('bl_markdown.converter_name');

        $tags = $container->findTaggedServiceIds('bl_markdown.converter');
        foreach ($tags as $id => $attrs) {
            foreach ($attrs as $attr) {
                if (!isset($attr['alias'])) {
                    continue;
                }

                if ($name == $attr['alias']) {
                    $container->setAlias('bl_markdown.converter', $id);

                    return;
                }
            }
        }

        throw new \InvalidArgumentException('Unable to find markdown converter named '.$name);
    }
}
