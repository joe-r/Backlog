<?php

namespace Backlog\AppBundle\Feature;

use Behat\Behat\Context\BehatContext;
use Behat\Mink\Driver\SeleniumDriver;
use Behat\MinkExtension\Context\MinkContext;

use Backlog\UserBundle\Feature\UserContext;

class AppContext extends BehatContext
{
    public function __construct(array $parameters)
    {
        $this->useContext('mink', new MinkContext());
        $this->useContext('kernel', new KernelContext());
        $this->useContext('bl_user', new UserContext());
    }

    /**
     * @Given /^I wait for Selenium$/
     */
    public function waitForSelenium()
    {
        $driver = $this->getSubcontext('mink')->getMink()->getSession()->getDriver();
        if ($driver instanceof SeleniumDriver) {
            $driver->getBrowser()->waitForPageToLoad(5000);
        }
    }
}
