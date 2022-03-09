@account @app
Feature: Updating profile
  In order to maintain my personal information updated
  As a Brother
  I want to be able to update my profile

  Background:
    Given there is a congregation "Carrollton"
    And there is a sister "Viktoria Clarck"
    And the sister has an account for email "vic.clark@gmail.com" and password "helloworld"

  @ui
  Scenario: Changing email
    When I log in as "vic.clark@gmail.com" with password "helloworld"
    And I want to update my profile
    And I change my first name with "Victoria"
    And I change my middle name with "Elisabeth"
    And I change my last name with "Clark"
    And I update the profile
    Then I should be logged in as "Victoria Elisabeth Clark"
