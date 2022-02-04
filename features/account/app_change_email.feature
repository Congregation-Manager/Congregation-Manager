@account @app
Feature: Changing email
  In order to login to receive account information to my new email
  As a Brother
  I need to be able to change my email

  Background:
    Given there is an app user with email "avaadams.old@gmail.com" and password "helloworld!"
    And I am logged in as "avaadams.old@gmail.com"

  @ui
  Scenario: Changing email
    When I want to change my email
    And I change my email with "avaadams@gmail.com"
    And I log out
    Then I should be able to log in as "avaadams@gmail.com" with "helloworld!" password
