<?php

namespace Backlog\AppBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class BacklogAppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('form.xml');
        $loader->load('twig.xml');
        $loader->load('model.xml');
        $loader->load('request.xml');
        $loader->load('test.xml');
        $loader->load('view.xml');
        $loader->load('markdown.xml');

        $container->setParameter('bl_app.markdown_converter.name', $config['markdown_converter']);
    }
}
