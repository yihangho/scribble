Feature: Creating new Scribble
  In order to create a new Scribble
  As a user
  I should see the input form, etc
  
  Scenario: First visit the main page
    Given I am on "/index.php"
    When I do nothing
    Then I should see a "textarea" element

  Scenario: Saving new Scribble with valid data
    Given I am on "/index.php"
    When I fill in "data[Scribble][title]" with "Scribble Title"
    And I fill in "data[Scribble][body]" with "Scribble Body"
    And I press "Scribble!"
    Then I should see "created"
    And I should see "Scribble Title"
    And I should see "Scribble Body"

  @mink:selenium2
  Scenario: Saving new Scribble with invalid data
    Given I am on "/index.php"
    When I fill in "data[Scribble][title]" with "Scribble Title"
    And I press "Scribble!"
    Then I should not see "created"

  Scenario: Saving new Scribble without a title
    Given I am on "/index.php"
    When I fill in "data[Scribble][body]" with "something"
    And I press "Scribble!"
    Then I should see "Untitled Scribble"