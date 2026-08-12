@qtype @qtype_vimipad
Feature: Attempt and review a ViMi Pad question in a quiz
  In order to be assessed on a knowledge map
  As a learner
  I need to answer a ViMi Pad question in a quiz and see it scored

  Background:
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Tay       | Teacher  | teacher1@example.com |
      | student1 | Sam       | Student  | student1@example.com |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
      | student1 | C1     | student        |
    And the following "question categories" exist:
      | contextlevel | reference | name           |
      | Course       | C1        | Test questions |
    And the following "questions" exist:
      | questioncategory | qtype   | name          | template  |
      | Test questions   | vimipad | Concept map 1 | reference |
    And the following "activities" exist:
      | activity | name   | course | idnumber |
      | quiz     | Quiz 1 | C1     | quiz1    |
    And quiz "Quiz 1" contains the following questions:
      | question      | page |
      | Concept map 1 | 1    |

  @javascript
  Scenario: The editor is offered when a learner attempts the question
    When I am on the "Quiz 1" "mod_quiz > View" page logged in as student1
    And I press "Attempt quiz"
    Then I should see "Concept map 1"
    And ".qtype_vimipad_editor" "css_element" should exist

  @javascript
  Scenario: A teacher can preview the question
    When I am on the "Course 1" "core_question > course question bank" page logged in as teacher1
    Then I should see "Concept map 1"
