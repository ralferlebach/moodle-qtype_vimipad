<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace qtype_vimipad;

use question_state;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/tests/helpers.php');

/**
 * Question-engine walkthrough tests for the ViMi Pad question type.
 *
 * These drive a whole attempt lifecycle through the engine (start, submit,
 * finish, grade) under deferred feedback, complementing the unit tests that
 * exercise the scorer and question contract in isolation.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_vimipad_question
 */
final class walkthrough_test extends \qbehaviour_walkthrough_test_base {
    /**
     * A serialised map with the given number of nodes and relations.
     *
     * @param int $nodes Number of nodes.
     * @param int $relations Number of relations (each between two of the nodes).
     * @return string JSON snapshot.
     */
    private function map(int $nodes, int $relations): string {
        $n = [];
        for ($i = 0; $i < $nodes; $i++) {
            $n[] = ['stableid' => 'n' . $i, 'label' => 'Node ' . $i];
        }
        $r = [];
        for ($i = 0; $i < $relations; $i++) {
            $r[] = [
                'sourceid' => 'n' . $i,
                'targetid' => 'n' . ($i + 1),
                'label' => 'rel' . $i,
            ];
        }
        return json_encode(['profile' => 'conceptmap', 'nodes' => $n, 'relations' => $r]);
    }

    /**
     * Structural grading: meeting both minimums earns full marks.
     *
     * @return void
     */
    public function test_deferredfeedback_structural_full(): void {
        $q = \test_question_maker::make_question('vimipad', 'structural');
        $this->start_attempt_at_question($q, 'deferredfeedback', 1);

        $this->process_submission(['answer' => $this->map(2, 1)]);
        $this->process_submission(['-finish' => 1]);

        $this->check_current_state(question_state::$gradedright);
        $this->check_current_mark(1);
    }

    /**
     * Structural grading: meeting only the node minimum earns half.
     *
     * @return void
     */
    public function test_deferredfeedback_structural_partial(): void {
        $q = \test_question_maker::make_question('vimipad', 'structural');
        $this->start_attempt_at_question($q, 'deferredfeedback', 1);

        $this->process_submission(['answer' => $this->map(2, 0)]);
        $this->process_submission(['-finish' => 1]);

        $this->check_current_state(question_state::$gradedpartial);
        $this->check_current_mark(0.5);
    }

    /**
     * Reference grading: reproducing the reference map earns full marks.
     *
     * @return void
     */
    public function test_deferredfeedback_reference_full(): void {
        $q = \test_question_maker::make_question('vimipad', 'reference');
        $this->start_attempt_at_question($q, 'deferredfeedback', 1);

        $this->process_submission(['answer' => $q->referencemap]);
        $this->process_submission(['-finish' => 1]);

        $this->check_current_state(question_state::$gradedright);
        $this->check_current_mark(1);
    }

    /**
     * Reference grading: a partial map scores strictly between zero and full.
     *
     * @return void
     */
    public function test_deferredfeedback_reference_partial(): void {
        $q = \test_question_maker::make_question('vimipad', 'reference');
        $this->start_attempt_at_question($q, 'deferredfeedback', 1);

        $partial = json_encode(['profile' => 'conceptmap', 'nodes' => [
            ['stableid' => 'a', 'label' => 'Water'],
        ], 'relations' => []]);
        $this->process_submission(['answer' => $partial]);
        $this->process_submission(['-finish' => 1]);

        $this->check_current_state(question_state::$gradedpartial);
        $mark = $this->quba->get_question_mark($this->slot);
        $this->assertGreaterThan(0, $mark);
        $this->assertLessThan(1, $mark);
    }

    /**
     * Finishing without building a map counts as given up (no gradable response).
     *
     * @return void
     */
    public function test_deferredfeedback_empty_is_gaveup(): void {
        $q = \test_question_maker::make_question('vimipad', 'structural');
        $this->start_attempt_at_question($q, 'deferredfeedback', 1);

        $this->process_submission(['-finish' => 1]);

        $this->check_current_state(question_state::$gaveup);
        $this->check_current_mark(null);
    }
}
