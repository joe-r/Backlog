<?php

namespace Backlog\AppBundle\Feature;

use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext implements KernelAwareInterface
{
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^There is no user "([^"]*)" in database$/
     */
    public function thereIsNoUserInDatabase($username)
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getEntityManager();

        $em
            ->createQuery('DELETE FROM Backlog\AppBundle\Entity\User u WHERE u.username = :username')
            ->setParameters(array('username' => $username))
            ->execute()
        ;
    }
}
