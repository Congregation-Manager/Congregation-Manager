@locales
Feature: Redirect to user locale after login
    In order to facilitate the use of the app
    As a Brother
    I want to be redirected to my preferred locale after login

    @ui @app
    Scenario: Redirect to user locale if it is available
        Given there is a congregation "Carrollton"
        And there is a brother "Walker Brenden"
        And the brother has an account for email "wbrenden@email.com"
        And The app user "wbrenden@email.com" has "Italian" as preferred language
        When I visit the homepage
        Then I should use the "English" locale
        When I log in as "wbrenden@email.com"
        Then I should use the "italiano" locale

    @ui @app
    Scenario: Do not change the current locale if it is not available
        Given there is a congregation "Carrollton"
        And there is a brother "Walker Brenden"
        And the brother has an account for email "wbrenden@email.com"
        And The app user "wbrenden@email.com" has "French" as preferred language
        When I visit the homepage
        Then I should use the "English" locale
        When I log in as "wbrenden@email.com"
        Then I should use the "English" locale
