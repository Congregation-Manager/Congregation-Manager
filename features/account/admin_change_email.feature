@account @admin
Feature: Changing email
  In order to login to receive account information to my new email
  As an Administrator
  I need to be able to change my email

  Background:
    Given there is an admin user with email "oldadminemail@cm.org" and password "4dm1n15tr4t0r"

  @ui
  Scenario: Changing email
    When I log in as "oldadminemail@cm.org" with password "4dm1n15tr4t0r"
    And I want to change my email
    And I change my email with "admin@cm.org"
    And I log out
    Then I should be able to log in as "admin@cm.org" with "4dm1n15tr4t0r" password
