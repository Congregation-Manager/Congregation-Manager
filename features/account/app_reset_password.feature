@account @app
Feature: Resetting an app password
  In order to login to my account when I forgot my password
  As a Brother
  I need to be able to reset my password

  Background:
    Given there is a congregation "Carrollton"
    And there is a brother "Dylan Martinez"
    And the brother has an account for email "dylan.mart@outlook.it"

  @ui @email
  Scenario: Resetting an account password
    When I want to reset password
    And I specify email as "dylan.mart@outlook.it"
    And I submit the forgot password
    Then I should be invited to check my email
    And an email with reset token should be sent to "dylan.mart@outlook.it"

  @ui
  Scenario: Changing my account password with token I received
    Given I have already received a resetting password email for "dylan.mart@outlook.it" brother
    When I follow link on my email to reset my password
    And I specify my new password as "newp@ssw0rd"
    And I confirm my new password as "newp@ssw0rd"
    And I reset it
    Then I should be redirected to the login page
    And I should be able to log in as "dylan.mart@outlook.it" with "newp@ssw0rd" password
