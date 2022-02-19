@locales
Feature: Save user locale when switching the current locale
    In order to use app in my preferred locale
    As a Brother or Administration
    I want to that my locale is been stored when changed

    Background:
        Given there is an admin user with email "admin@cm.org"
        And there is an app user with email "walkbrend@email.com"

    @ui @app
    Scenario: Save the user locale on app user
        When I log in as "walkbrend@email.com"
        Then I should use the "English" locale
        When I switch to the "Italian" locale
        Then I should use the "Italian" locale
        When I log out
        And I switch to the "English" locale
        And I log in as "walkbrend@email.com"
        Then I should use the "Italian" locale

    @ui @admin
    Scenario: Save the user locale on admin user
        When I log in as "admin@cm.org"
        Then I should use the "English" locale
        When I switch to the "Italian" locale
        Then I should use the "Italian" locale
        When I log out
        And I switch to the "English" locale
        And I log in as "admin@cm.org"
        Then I should use the "Italian" locale
