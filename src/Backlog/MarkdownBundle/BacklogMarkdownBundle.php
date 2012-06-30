<?php

namespace Backlog\MarkdownBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Backlog\MarkdownBundle\DependencyInjection\Compiler\ConverterPass;

class BacklogMarkdownBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ConverterPass());
    }
}
