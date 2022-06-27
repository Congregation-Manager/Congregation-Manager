@territory
Feature: Create territory assignment
  In order to register the assignments of territories
  As a Brother
  I want to create new assignments for territories

  Background:
    Given there is a congregation "Carrollton"
    And there is a brother "Dylan Martinez"
    And I am logged in as "Dylan Martinez"
    And there is a territory "01"

  @ui @app
  Scenario: Create new territory assignment
    Given I am on the assign territory "01" page
    Then I should see that the territory "01" is selected
    When I set assignment date as "2022-06-14"
    And I select brother "Dylan Martinez"
    And I save territory assignment
    Then I should be redirected to territory "01" page
    And I should see 1 territory assignment
    And the first territory assignment should be assigned starting from "2022-06-14"
    And the first territory assignment should be assigned to brother "Dylan Martinez"

  @ui @app
  Scenario: Prevent creating new territory assignment on already assigned territory
    Given the territory "01" has been assigned to brother "Dylan Martinez" on "2022-04-30"
    And I am on the assign territory "01" page
    When I set assignment date as "2022-06-14"
    And I select brother "Dylan Martinez"
    And I save territory assignment
    Then I should be informed that the territory is conflicting another
    When I view the territory "01" page
    Then I should see 1 territory assignment
    And the first territory assignment should be assigned starting from "2022-04-30"
    And the first territory assignment should be assigned to brother "Dylan Martinez"

  @ui @app
  Scenario: Prevent creating territory assignment with revocation date before assignment date
    Given I am on the assign territory "01" page
    When I set assignment date as "2022-06-14"
    And I set revocation date as "2022-06-12"
    And I save territory assignment
    Then I should be informed that revocation date should be greater or equal than "2022-06-14"
    When I view the territory "01" page
    Then I should see 0 territory assignment

  @ui @app @wip
  Scenario: Prevent creating territory assignment without assignment date
    Given I am on the assign territory "01" page
    When I save territory assignment
    Then I should be informed that assignment date is required
    When I view the territory "01" page
    Then I should see 0 territory assignment
