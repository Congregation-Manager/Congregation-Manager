@account @app
Feature: Changing password
  In order to improve the security of my account
  As a Brother
  I want to be able to change my password

  Background:
    Given there is a congregation "Carrollton"
    And there is a sister "Ava Adams"
    And the sister has an account for email "avaadams@gmail.com" and password "helloworld!"
    And I am logged in as "avaadams@gmail.com"

  @ui
  Scenario: Changing password
    When I want to change my password
    And I specify my actual password with "helloworld!"
    And I change my password with "newpassword"
    And I confirm my password with "newpassword"
    And I update it
    And I log out
    Then I should be able to log in as "avaadams@gmail.com" with "newpassword" password
