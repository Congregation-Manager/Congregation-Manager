@locales
Feature: Switching the current locale
    In order to use app in my preferred locale
    As a Brother
    I want to be able to switch locales

    @ui @app
    Scenario: Showing the current locale
        When I visit the homepage
        Then I should use the "English" locale

    @ui @app
    Scenario: Showing available locales
        When I visit the homepage
        Then I should be able to use the "Italian italiano" locale

    @ui @app
    Scenario: Switching the current locale
        When I visit the homepage
        And I switch to the "Italian" locale
        Then I should use the "italiano" locale
        Then I should be able to use the "inglese English" locale
