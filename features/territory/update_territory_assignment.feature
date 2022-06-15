@territory
Feature: Update territory assignment
  In order to register the revocation of territories
  As a Brother
  I want to update assignments for territories

  Background:
    Given there is a congregation "Carrollton"
    And there is a brother "Dylan Martinez"
    And I am logged in as "Dylan Martinez"
    And there is a territory "01"
    And the territory "01" is assigned to brother "Dylan Martinez"

  @ui @app
  Scenario: Update territory assignment
    Given I am on the territory assignment update page

