@account
Feature: Securing the administration
  In order to prevent access to private data
  As a Visitor
  I want to be prevented to access to administration without authentication

  @admin @ui
  Scenario: Preventing access to administration if not authenticated
    When I try to open dashboard
    Then I should be redirected to the login page
