Feature: View backlog

    Background:
        Given I'm connected as user "user"

    Scenario: View title and rows
      Given I am on "/"
       When I follow "User basic backlog"
        And I wait for Selenium
       Then I should see "User basic backlog"
        And I should see "First story"
        And I should see "Second story"
        And I should see "Third story"
        And I should see "First milestone"
