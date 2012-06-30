<?php

namespace Backlog\AppBundle\Feature;

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
            ->createQuery('DELETE FROM Backlog\UserBundle\Entity\User u WHERE u.username = :username')
            ->setParameters(array('username' => $username))
            ->execute()
        ;
    }

    /**
     * @Given /^I\'m connected as user "([^"]*)"$/
     */
    public function iMConnectedAsUser($username, $password = null)
    {
        $this->visit("/login");

        $this->fillField('_username', $username);
        $this->fillField('_password', isset($password) ? $password : $username);
        $this->pressButton('Login');
        $this->assertPageContainsText('Connected as '.$username);
    }
}
