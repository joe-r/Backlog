<?php

namespace Backlog\AppBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Alexandre Salomé <alexandre.salome@gmail.com>
 */
abstract class BaseFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function getContainer()
    {
        if (null === $this->container) {
            throw new \RuntimeException("No container set in fixture");
        }

        return $this->container;
    }
}
