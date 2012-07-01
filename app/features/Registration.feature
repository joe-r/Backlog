Feature: Registering to the website
    I can create an account
    As a visitor
    To start using services

    Background:
        Given There is no user "usertest" in database

    Scenario: I can register with correct informations
      Given I am on "/register"
       When I fill in the following:
        | Fullname        | User Test            |
        | Username        | usertest             |
        | Email           | usertest@example.org |
        | Initials        | UT                   |
        | Password        | userpass             |
        | Repeat password | userpass             |
        And I press "Register"
        And I wait for Selenium
       Then I should see "Registration done!"

    Scenario: I can't register with an existing username
      Given I am on "/register"
       When I fill in the following:
        | Fullname        | User Test            |
        | Username        | user                 |
        | Email           | usertest@example.org |
        | Initials        | UT                   |
        | Password        | userpass             |
        | Repeat password | userpass             |
        And I press "Register"
        And I wait for Selenium
       Then I should see "This username is already used"
       When I fill in the following:
        | Username        | usertest |
        | Password        | test     |
        | Repeat password | test     |
        And I press "Register"
        And I wait for Selenium
       Then I should see "Registration done!"

    Scenario: I can't register with an existing email
      Given I am on "/register"
       When I fill in the following:
        | Fullname        | User Test        |
        | Username        | usertest         |
        | Email           | user@example.org |
        | Initials        | UT               |
        | Password        | userpass         |
        | Repeat password | userpass         |
        And I press "Register"
        And I wait for Selenium
       Then I should see "This email is already used"
       When I fill in the following:
        | Email           | usertest@example.org |
        | Password        | test                 |
        | Repeat password | test                 |
        And I press "Register"
        And I wait for Selenium
       Then I should see "Registration done!"
