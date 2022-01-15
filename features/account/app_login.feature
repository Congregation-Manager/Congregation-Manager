@account
Feature: Signing in to the app
  In order to operates for my congregation
  As a Brother
  I want to be able to log in to the app

  @app @ui
  Scenario: Sign in with email and password
    Given there is an app user with email "barrjhon@email.com" and password "barry.strawberry"
    When I want to log in
    And I specify the email as "barrjhon@email.com"
    And I specify the password as "barry.strawberry"
    And I log in
    Then I should be logged in
