@locales
Feature: Redirect to user locale after login
  In order to facilitate the use of the app
  As a Brother or Administrator
  I want to be redirected to my preferred locale after login

  @ui @app
  Scenario: Redirect to user locale if it is available
    Given there is a congregation "Carrollton"
    And there is a brother "Walker Brenden"
    And the brother has an account for email "walkbrend@email.com"
    And The app user "walkbrend@email.com" has "Italian" as preferred language
    When I visit the homepage
    Then I should use the "English [English]" locale
    When I log in as "walkbrend@email.com"
    Then I should use the "italiano" locale

  @ui @app
  Scenario: Do not change the current locale if it is not available
    Given there is a congregation "Carrollton"
    And there is a brother "Walker Brenden"
    And the brother has an account for email "walkbrend@email.com"
    And The app user "walkbrend@email.com" has "French" as preferred language
    When I visit the homepage
    Then I should use the "English [English]" locale
    When I log in as "walkbrend@email.com"
    Then I should use the "English" locale

  @ui @admin
  Scenario: Redirect to user locale if it is available
    Given there is an admin user with email "admin@cm.org"
    And The admin user "admin@cm.org" has "Italian" as preferred language
    When I visit the administration login page
    Then I should use the "English" locale
    When I log in as "admin@cm.org"
    Then I should use the "italiano" locale

  @ui @admin
  Scenario: Do not change the current locale if it is not available
    Given there is an admin user with email "admin@cm.org"
    And The admin user "admin@cm.org" has "French" as preferred language
    When I visit the administration login page
    Then I should use the "English" locale
    When I log in as "admin@cm.org"
    Then I should use the "English" locale
