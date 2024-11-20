@locales
Feature: Save user locale when switching the current locale
    In order to use admin in my preferred locale
    As an Administrator
    I want to save my locale when switching it

    @ui @admin
    Scenario: Save the user locale
        Given there is an admin user with email "admin@cm.org"
        When I log in as "admin@cm.org"
        Then I should use the "English" locale
        When I switch to the "Italian" locale
        Then I should use the "italiano" locale
        When I log out
        And I switch to the "English" locale
        And I log in as "admin@cm.org"
        Then I should use the "italiano" locale
