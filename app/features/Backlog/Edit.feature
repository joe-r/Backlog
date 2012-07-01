Feature: Edit a backlog list
    Background:
        Given I'm connected as user "user"

    Scenario: Change title

      Given I am on "/"
        And I follow "User basic backlog"
        And I wait for Selenium
        And I press "Options"
        And I follow "Preferences"
        And I wait for Selenium
        And I should see "Edit backlog"

       When I fill in "Title" with "New backlog title"
        And I press "Save"
        And I wait for Selenium

       Then I should see "New backlog title"

    Scenario: Change title (restore previous state)

      Given I am on "/"
        And I follow "New backlog title"
        And I wait for Selenium
        And I press "Options"
        And I follow "Preferences"
        And I wait for Selenium
        And I should see "Edit backlog"

       When I fill in "Title" with "User basic backlog"
        And I press "Save"
        And I wait for Selenium
       Then I should see "User basic backlog"
