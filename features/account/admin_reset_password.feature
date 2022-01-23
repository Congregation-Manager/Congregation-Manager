@account @admin
Feature: Resetting an administration password
  In order to login to my account when I forgot my password
  As Administrator
  I need to be able to reset my password

  Background:
    Given there is an admin user with email "admin@cm.org"

  @ui @email
  Scenario: Resetting an account password
    When I want to reset password
    And I specify customer email as "admin@cm.org"
    And I submit the forgot password
    Then I should be invited to check my email
    And an email with reset token should be sent to "admin@cm.org"

  @ui @email
  Scenario: Changing my account password with token I received
    Given I have already received a resetting password email for "admin@cm.org" administrator
    When I follow link on my email to reset my password
    And I specify my new password as "newp@ssw0rd"
    And I confirm my new password as "newp@ssw0rd"
    And I reset it
    Then I should be redirected to the login page
    And I should be able to log in as "admin@cm.org" with "newp@ssw0rd" password
