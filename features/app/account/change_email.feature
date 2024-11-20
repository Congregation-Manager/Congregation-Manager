@account @app
Feature: Changing email
    In order to login to receive account information to my new email
    As a Brother
    I need to be able to change my email

    Background:
        Given there is a congregation "Carrollton"
        And there is a sister "Ava Adams"
        And the sister has an account for email "avaadams.old@gmail.com" and password "helloworld!"

    @ui
    Scenario: Changing email
        When I log in as "avaadams.old@gmail.com" with password "helloworld!"
        And I want to change my email
        And I change my email with "avaadams@gmail.com"
        And I log out
        Then I should be able to log in as "avaadams@gmail.com" with "helloworld!" password
