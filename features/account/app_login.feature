@account
Feature: Signing in to the app
  In order to operates for my congregation
  As a Brother
  I want to be able to log in to the app

  @app @ui
  Scenario: Sign in with email and password
    Given there is a congregation "Carrollton"
    And there is a brother "John Barr"
    And the brother has an account for email "barrjohn@email.com" and password "barry.strawberry"
    When I want to log in
    And I specify the email as "barrjohn@email.com"
    And I specify the password as "barry.strawberry"
    And I log in
    Then I should be logged in
