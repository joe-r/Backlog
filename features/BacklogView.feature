Feature: Viewing of the backlog
    I can see informations related to my backlog
    As a user

    Background:
        Given I'm connected as user "user"

    Scenario: The backlog page shows me revelant informations about my backlog
      Given I am on "/"
       When I follow "View"
       Then I should see "User basic backlog"
