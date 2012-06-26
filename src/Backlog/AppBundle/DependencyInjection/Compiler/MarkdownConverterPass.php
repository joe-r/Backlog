<?php

namespace Backlog\AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MarkdownConverterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $name = $container->getParameter('bl_app.markdown_converter.name');
        $container->getParameterBag()->remove('bl_app.markdown_converter.name');

        $tags = $container->findTaggedServiceIds('bl_app.markdown_converter');
        foreach ($tags as $id => $attrs) {
            foreach ($attrs as $attr) {
                if (!isset($attr['alias'])) {
                    continue;
                }

                if ($name == $attr['alias']) {
                    $container->setAlias('bl_app.markdown_converter', $id);

                    return;
                }
            }
        }

        throw new \InvalidException('Unable to find markdown converter named '.$name);
    }
}
