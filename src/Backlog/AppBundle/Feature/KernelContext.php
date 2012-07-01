<?php

namespace Backlog\AppBundle\Feature;

use Symfony\Component\HttpKernel\KernelInterface;

use Behat\Behat\Context\BehatContext;
use Behat\Symfony2Extension\Context\KernelAwareInterface;

class KernelContext extends BehatContext implements KernelAwareInterface
{
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getDoctrine()
    {
        return $this->kernel->getContainer()->get('doctrine');
    }
}
