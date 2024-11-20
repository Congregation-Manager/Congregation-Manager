@territory
Feature: Update territory assignment
    In order to register the revocation of territories
    As a Brother
    I want to update assignments for territories

    Background:
        Given there is a congregation "Carrollton"
        And there is a brother "Dylan Martinez"
        And there is a brother "Christian Martinez"
        And I am logged in as "Dylan Martinez"
        And there is a territory "01"
        And the territory "01" has been assigned to brother "Dylan Martinez" on "2022-06-14"

    @ui @app
    Scenario: Update territory assignment
        Given I am on the update page of assignment of territory "01" of "Dylan Martinez" starting on "2022-06-14"
        Then I should see that the territory "01" is selected
        When I select brother "Christian Martinez"
        And I set revocation date as "2022-07-10"
        And I save territory assignment
        Then I should be redirected to territory "01" page
        And I should see 1 territory assignment
        And the first territory assignment should be assigned starting from "2022-06-14"
        And the first territory assignment should be assigned to brother "Christian Martinez"

    @ui @app
    Scenario: Prevent updating territory assignment by making it conflict with another assignment
        Given the territory "01" has been assigned to brother "Christian Martinez" from "2022-04-30" to "2022-05-31"
        And I am on the update page of assignment of territory "01" of "Dylan Martinez" starting on "2022-06-14"
        When I set assignment date as "2022-05-25"
        And I save territory assignment
        Then I should be informed that the territory is conflicting another
        When I view the territory "01" page
        Then I should see 2 territory assignment
        And the first territory assignment should be assigned starting from "2022-04-30"
        And the first territory assignment should be assigned to brother "Christian Martinez"
        And the last one territory assignment should be assigned starting from "2022-06-14"
        And the last one territory assignment should be assigned to brother "Dylan Martinez"

    @ui @app
    Scenario: Prevent updating territory assignment with revocation date before assignment date
        Given I am on the update page of assignment of territory "01" of "Dylan Martinez" starting on "2022-06-14"
        When I set assignment date as "2022-06-14"
        And I set revocation date as "2022-06-12"
        And I save territory assignment
        Then I should be informed that revocation date should be greater or equal than "2022-06-14"
        When I view the territory "01" page
        Then I should see 1 territory assignment
