@account
Feature: Signing in to the administration
  In order to manage subscribed congregations
  As Administrator
  I want to be able to log in to the administration

  @admin @ui
  Scenario: Sign in with email and password
    Given there is an admin user with email "admin@cm.org" and password "4dm1n15tr4t0r"
    When I want to log in
    And I specify the email as "admin@cm.org"
    And I specify the password as "4dm1n15tr4t0r"
    And I log in
    Then I should be logged in
