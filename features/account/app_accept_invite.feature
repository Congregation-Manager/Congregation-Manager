@account @app
Feature: Accept app invite
  In order to access the app
  As a Brother
  I want to be able to complete my account information

  Background:
    Given there is a congregation "Carrollton"
    And there is a brother "Luke Martin"

  @ui
  Scenario: Complete my app account
    Given I have already received an invitation email for "luke_martin@gmail.com"
    When I follow link on my email to complete my account
    And I specify my password as "newp@ssw0rd"
    And I confirm my password as "newp@ssw0rd"
    And I complete my account
    Then I should be redirected to the login page
    And I should be able to log in as "luke_martin@gmail.com" with "newp@ssw0rd" password
