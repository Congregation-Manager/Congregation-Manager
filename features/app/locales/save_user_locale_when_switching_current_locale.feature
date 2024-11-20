@locales
Feature: Save user locale when switching the current locale
    In order to use app in my preferred locale
    As a Brother
    I want to be able to save my locale when switching it

    @ui @app
    Scenario: Save the user locale
        Given there is a congregation "Carrollton"
        And there is a brother "Walker Brenden"
        And the brother has an account for email "wbrenden@email.com"
        When I log in as "wbrenden@email.com"
        Then I should use the "English" locale
        When I switch to the "Italian" locale
        Then I should use the "italiano" locale
        When I log out
        And I switch to the "English" locale
        And I log in as "wbrenden@email.com"
        Then I should use the "italiano" locale
