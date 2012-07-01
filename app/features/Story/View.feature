Feature: View a story

    Background:
        Given I'm connected as user "user"

    Scenario: View the story description
      Given I am on "/"
       When I follow "User basic backlog"
        And I wait for Selenium
        And I follow "First story"
        And I wait for Selenium
       Then I should see "Assignee"
        And I should see "First Story" in the "dl>dd.title" element
        And I should see "This is description of first story" in the "dl>dd.description" element
        And I should see "User" in the "dl > dd.assignee" element
        And I should see "you" in the "dl > dd.assignee .label" element
        And I should see "1" in the "dl > dd.complexity" element
