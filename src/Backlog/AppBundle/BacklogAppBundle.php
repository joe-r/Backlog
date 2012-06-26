<?php

namespace Backlog\AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Backlog\AppBundle\DependencyInjection\Compiler\MarkdownConverterPass;

class BacklogAppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MarkdownConverterPass());
    }
}
