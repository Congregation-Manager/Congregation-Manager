@locales
Feature: Save user locale when switching the current locale
    In order to use app in my preferred locale
    As a Brother or Administration
    I want to that my locale is been stored when changed

    @ui @app
    Scenario: Save the user locale on app user
        Given there is a congregation "Carrollton"
        And there is a brother "Walker Brenden"
        And the brother has an account for email "walkbrend@email.com"
        When I log in as "walkbrend@email.com"
        Then I should use the "English" locale
        When I switch to the "Italian [italiano]" locale
        Then I should use the "italiano [italiano]" locale
        When I log out
        And I switch to the "English" locale
        And I log in as "walkbrend@email.com"
        Then I should use the "italiano" locale

    @ui @admin
    Scenario: Save the user locale on admin user
        Given there is an admin user with email "admin@cm.org"
        When I log in as "admin@cm.org"
        Then I should use the "English" locale
        When I switch to the "Italian [italiano]" locale
        Then I should use the "italiano" locale
        When I log out
        And I switch to the "English" locale
        And I log in as "admin@cm.org"
        Then I should use the "italiano" locale
