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

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/question/engine/lib.php');
require_once($CFG->dirroot . '/question/type/vimipad/questiontype.php');
require_once($CFG->dirroot . '/question/type/vimipad/question.php');

/**
 * Unit tests for the ViMi Pad question type and its automatic grading.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_vimipad
 * @covers     \qtype_vimipad_question
 */
final class questiontype_test extends \advanced_testcase {
    /** @var \qtype_vimipad The question type under test. */
    protected $qtype;

    /**
     * Set up a fresh question type instance for each test.
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();
        $this->qtype = new \qtype_vimipad();
    }

    /**
     * The extra fields map onto the options table and all its columns.
     *
     * @return void
     */
    public function test_extra_question_fields(): void {
        $this->assertSame(
            ['qtype_vimipad_options', 'profile', 'allowedshapes',
                'referencemap', 'minnodes', 'minrelations'],
            $this->qtype->extra_question_fields()
        );
    }

    /**
     * The dependency on mod_vimipad's public profile API is present and usable.
     *
     * This is the cross-plugin contract the whole question type rests on: the
     * profile list in the edit form and the clamp in the runtime question both
     * call it. If it disappears, this test is where it should surface.
     *
     * @return void
     */
    public function test_public_profile_api_available(): void {
        $this->assertTrue(
            class_exists('\mod_vimipad\profile\profiles'),
            'qtype_vimipad depends on the mod_vimipad public profile API.'
        );
        $all = \mod_vimipad\profile\profiles::all();
        $this->assertIsArray($all);
        $this->assertContains(
            'conceptmap',
            $all,
            'The conceptmap profile is expected to be offered by mod_vimipad.'
        );
        $this->assertTrue(\mod_vimipad\profile\profiles::exists('conceptmap'));
        $this->assertFalse(\mod_vimipad\profile\profiles::exists('no_such_profile'));
    }

    /**
     * The runtime question is automatically graded, not manual.
     *
     * @return void
     */
    public function test_question_is_automatically_graded(): void {
        $question = new \qtype_vimipad_question();
        $this->assertInstanceOf(\question_graded_automatically::class, $question);
    }

    /**
     * The runtime question models the expected response contract.
     *
     * @return void
     */
    public function test_question_response_contract(): void {
        $question = new \qtype_vimipad_question();

        $this->assertSame(['answer' => PARAM_RAW], $question->get_expected_data());
        $this->assertNull($question->get_correct_response());

        $this->assertFalse($question->is_complete_response([]));
        $this->assertFalse($question->is_complete_response(['answer' => '   ']));
        $this->assertTrue($question->is_complete_response(['answer' => '{"nodes":[],"relations":[]}']));

        $this->assertTrue($question->is_gradable_response(['answer' => '{"nodes":[]}']));
        $this->assertNotEmpty($question->get_validation_error([]));
        $this->assertSame('', $question->get_validation_error(['answer' => '{"nodes":[]}']));

        $this->assertTrue($question->is_same_response(
            ['answer' => '{"a":1}'],
            ['answer' => '{"a":1}']
        ));
        $this->assertFalse($question->is_same_response(
            ['answer' => '{"a":1}'],
            ['answer' => '{"a":2}']
        ));
    }

    /**
     * grade_response scores against a reference map when one is set.
     *
     * @return void
     */
    public function test_grade_response_reference_mode(): void {
        $reference = json_encode(['nodes' => [
            ['id' => 'a', 'label' => 'Water'],
            ['id' => 'b', 'label' => 'Ice'],
        ], 'relations' => []]);

        $question = new \qtype_vimipad_question();
        $question->referencemap = $reference;
        $question->minnodes = 0;
        $question->minrelations = 0;

        [$fraction, $state] = $question->grade_response(['answer' => $reference]);
        $this->assertSame(1.0, $fraction);
        $this->assertEquals(\question_state::$gradedright, $state);

        $partial = json_encode(['nodes' => [['id' => 'a', 'label' => 'Water']], 'relations' => []]);
        [$fraction2] = $question->grade_response(['answer' => $partial]);
        $this->assertEqualsWithDelta(0.5, $fraction2, 0.0001);
    }

    /**
     * grade_response falls back to structural minimums without a reference.
     *
     * @return void
     */
    public function test_grade_response_structural_mode(): void {
        $question = new \qtype_vimipad_question();
        $question->referencemap = null;
        $question->minnodes = 2;
        $question->minrelations = 0;

        $map = json_encode(['nodes' => [
            ['id' => 'a', 'label' => 'A'],
            ['id' => 'b', 'label' => 'B'],
        ], 'relations' => []]);

        [$fraction, $state] = $question->grade_response(['answer' => $map]);
        $this->assertSame(1.0, $fraction);
        $this->assertEquals(\question_state::$gradedright, $state);
    }

    /**
     * The response summary reports node and relation counts from the map JSON.
     *
     * @return void
     */
    public function test_summarise_response(): void {
        $question = new \qtype_vimipad_question();

        $map = json_encode(['nodes' => [
            ['id' => 'n1', 'label' => 'Alpha'],
            ['id' => 'n2', 'label' => 'Beta'],
        ], 'relations' => [
            ['source' => 'n1', 'label' => 'links', 'target' => 'n2'],
        ]]);
        $summary = $question->summarise_response(['answer' => $map]);
        $this->assertStringContainsString('2', $summary);
        $this->assertStringContainsString('1', $summary);

        $this->assertNull($question->summarise_response([]));
    }
}
