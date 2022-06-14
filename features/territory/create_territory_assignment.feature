@territory
Feature: Create territory assignment
  In order to register the status of territories
  As a Brother
  I want to create new assignment for territory

  @ui @app
  Scenario: Create new territory assignment
    Given there is a congregation "Carrollton"
    And there is a brother "Dylan Martinez"
    And I am logged in as "Dylan Martinez"
    And there is a territory "01"
    And I am on the assign territory "01" page
    Then I should see that the territory "01" is selected
    When I set assignment date as "2022-06-14"
    And I select brother "Dylan Martinez"
    And I save territory assignment
    Then I should be redirected to territory "01" page

