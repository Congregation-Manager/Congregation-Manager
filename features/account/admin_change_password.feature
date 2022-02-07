@account @admin
Feature: Changing password
  In order to improve the security of my account
  As an Administrator
  I want to be able to change my password

  Background:
    Given there is an admin user with email "admin@cm.org" and password "password"
    And I am logged in as "admin@cm.org"

  @ui
  Scenario: Changing password
    When I want to change my password
    And I specify my actual password with "password"
    And I change my password with "4dm1n15tr4t0r"
    And I confirm my password with "4dm1n15tr4t0r"
    And I update it
    And I log out
    Then I should be able to log in as "admin@cm.org" with "4dm1n15tr4t0r" password
