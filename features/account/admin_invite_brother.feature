@account @admin
Feature: Invite a new user
  In order to invite a new brother to access the app
  As an Administrator
  I want to be able to inviate a user from a brother

  Background:
    Given there is an admin user with email "admin@cm.org" and password "password"
    And there is a congregation "Carrollton"
    And there is a brother "Luke Martin"

  @ui
  Scenario: Changing password
    When I log in as "admin@cm.org" with password "password"
    And I want to see brother "Luke Martin" details
    Then I should see that the brother does not have a user
