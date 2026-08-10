@qtype @qtype_vimipad
Feature: A teacher can add ViMi Pad questions to the question bank
  In order to assess visual knowledge maps
  As a teacher
  I need to create and see ViMi Pad questions

  Background:
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "users" exist:
      | username | firstname | lastname | email             |
      | teacher1 | Tay       | Teacher  | teacher1@example.com |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    And the following "question categories" exist:
      | contextlevel | reference | name           |
      | Course       | C1        | Test questions |
    And the following "questions" exist:
      | questioncategory | qtype   | name          | template |
      | Test questions   | vimipad | Concept map 1 | stub     |

  @javascript
  Scenario: A generated ViMi Pad question appears in the course question bank
    When I am on the "Course 1" "core_question > course question bank" page logged in as teacher1
    Then I should see "Concept map 1"

  @javascript
  Scenario: A teacher creates a ViMi Pad question through the form
    Given I am on the "Course 1" "core_question > course question bank" page logged in as teacher1
    When I add a "ViMi Pad" question filling the form with:
      | Question name | Water cycle map |
      | Question text | Build a map of the cycle |
      | Minimum nodes | 3                        |
    Then I should see "Water cycle map"
