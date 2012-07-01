<?php

namespace Backlog\UserBundle\Feature;

use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Behat\Context\BehatContext;

class UserContext extends BehatContext
{
    /**
     * @Given /^There is no user "([^"]*)" in database$/
     */
    public function thereIsNoUserInDatabase($username)
    {
        $em = $this->getMainContext()->getSubcontext('kernel')->getDoctrine()->getEntityManager();

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
        $ctx = $this->getMainContext()->getSubcontext('mink');

        $ctx->visit("/login");
        $ctx->fillField('_username', $username);
        $ctx->fillField('_password', isset($password) ? $password : $username);
        $ctx->pressButton('Login');
        $ctx->getMainContext()->waitForSelenium();
        $ctx->assertPageContainsText('Connected as '.$username);
    }
}
