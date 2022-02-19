@locales
Feature: Switching the current locale
    In order to use app in my preferred locale
    As a Brother or Administration
    I want to be able to switch locales

    @ui @app
    Scenario: Showing the current locale as Brother
        When I visit the homepage
        Then I should use the "English" locale

    @ui @app
    Scenario: Showing available locales as Brother
        When I visit the homepage
        Then I should be able to use the "Italian" locale

    @ui @app
    Scenario: Switching the current locale as Brother
        When I visit the homepage
        And I switch to the "Italian" locale
        Then I should use the "Italian" locale
        Then I should be able to use the "English" locale

    @ui @admin
    Scenario: Showing the current locale as Administrator
        When I visit the administration login page
        Then I should use the "English" locale

    @ui @admin
    Scenario: Showing available locales as Administrator
        When I visit the administration login page
        Then I should be able to use the "Italian" locale

    @ui @admin
    Scenario: Switching the current locale as Administrator
        When I visit the administration login page
        And I switch to the "Italian" locale
        Then I should use the "Italian" locale
        Then I should be able to use the "English" locale
