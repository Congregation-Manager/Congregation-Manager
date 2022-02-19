@locales
Feature: Redirect to browser locale
    In order to facilitate the use of the app
    As a Brother or Administrator
    I want to be redirected to my browser preferred locale

    @ui @app
    Scenario: Redirect to browser locale if it is available
        Given I use a browser set in the "Italian" preferred language
        When I visit the homepage
        Then I should use the "Italian" locale

    @ui @app
    Scenario: Redirect to default locale if it is not available
        Given I use a browser set in the "French" preferred language
        When I visit the homepage
        Then I should use the "English" locale

    @ui @admin
    Scenario: Redirect to browser locale if it is available
        Given I use a browser set in the "Italian" preferred language
        When I visit the administration login page
        Then I should use the "Italian" locale

    @ui @admin
    Scenario: Redirect to default locale if it is not available
        Given I use a browser set in the "French" preferred language
        When I visit the administration login page
        Then I should use the "English" locale
