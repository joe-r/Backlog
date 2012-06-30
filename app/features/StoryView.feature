Feature: View a story

    Background:
        Given I'm connected as user "user"

    Scenario: The backlog page shows me revelant informations about my backlog
      Given I am on "/"
       When I follow "User basic backlog"
       Then I should see "User basic backlog"
