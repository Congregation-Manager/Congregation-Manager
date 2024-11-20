@locales
Feature: Switching the current locale
    In order to use admin in my preferred locale
    As an Administrator
    I want to be able to switch locales

    @ui @admin
    Scenario: Showing the current locale
        When I visit the administration login page
        Then I should use the "English" locale

    @ui @admin
    Scenario: Showing available locales
        When I visit the administration login page
        Then I should be able to use the "Italian italiano" locale

    @ui @admin
    Scenario: Switching the current locale
        When I visit the administration login page
        And I switch to the "Italian" locale
        Then I should use the "italiano" locale
        Then I should be able to use the "inglese English" locale
