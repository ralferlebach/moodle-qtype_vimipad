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
require_once($CFG->dirroot . '/question/type/vimipad/question.php');

use mod_vimipad\api\value;

/**
 * Boundary tests for what a ViMi Pad question accepts as a response.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_vimipad_question
 */
final class response_policy_test extends \advanced_testcase {
    /**
     * Build a question with the given options.
     *
     * @param string $profile The diagram profile.
     * @param string $allowedshapes Comma-separated permitted shapes.
     * @return \qtype_vimipad_question The question.
     */
    private function question(string $profile = 'conceptmap', string $allowedshapes = ''): \qtype_vimipad_question {
        $question = new \qtype_vimipad_question();
        $question->profile = $profile;
        $question->allowedshapes = $allowedshapes;
        return $question;
    }

    /**
     * A map with the given nodes.
     *
     * @param array $nodes The node definitions.
     * @param string $profile The profile key.
     * @return string The map JSON.
     */
    private function map(array $nodes, string $profile = 'conceptmap'): string {
        return (string) json_encode([
            'profile' => $profile,
            'nodes' => $nodes,
            'relations' => [],
        ]);
    }

    /**
     * A response larger than the policy allows is refused.
     *
     * @return void
     */
    public function test_oversized_response_is_refused(): void {
        $this->resetAfterTest();
        $question = $this->question();
        $huge = str_repeat('x', value::MAX_BYTES + 1);

        $this->assertFalse($question->is_complete_response(['answer' => $huge]));
        $this->assertNotEmpty($question->get_validation_error(['answer' => $huge]));
    }

    /**
     * A structurally broken map is refused even though it parses as JSON.
     *
     * @return void
     */
    public function test_malformed_map_is_refused(): void {
        $this->resetAfterTest();
        $question = $this->question();

        $this->assertFalse($question->is_complete_response(['answer' => '{"nodes":[{}]}']));
        $this->assertFalse($question->is_complete_response(['answer' => 'not json']));
    }

    /**
     * A map from another diagram profile is refused.
     *
     * @return void
     */
    public function test_wrong_profile_is_refused(): void {
        $this->resetAfterTest();
        $question = $this->question('conceptmap');
        $other = $this->map([['stableid' => 'n1', 'label' => 'One']], 'mindmap');

        $this->assertFalse($question->is_complete_response(['answer' => $other]));
    }

    /**
     * A shape the question does not permit is refused, and a permitted one is
     * accepted. This is the restriction the edit form promises.
     *
     * @return void
     */
    public function test_disallowed_shape_is_refused(): void {
        $this->resetAfterTest();
        $question = $this->question('conceptmap', 'circle,rectangle');

        $bad = $this->map([['stableid' => 'n1', 'label' => 'One', 'shape' => 'diamond']]);
        $good = $this->map([['stableid' => 'n1', 'label' => 'One', 'shape' => 'circle']]);

        $this->assertFalse($question->is_complete_response(['answer' => $bad]));
        $this->assertTrue($question->is_complete_response(['answer' => $good]));
    }

    /**
     * With no shape restriction configured, any shape is accepted.
     *
     * @return void
     */
    public function test_unrestricted_shapes_accept_anything(): void {
        $this->resetAfterTest();
        $question = $this->question('conceptmap', '');
        $map = $this->map([['stableid' => 'n1', 'label' => 'One', 'shape' => 'diamond']]);

        $this->assertSame([], $question->allowed_shapes());
        $this->assertTrue($question->is_complete_response(['answer' => $map]));
    }

    /**
     * The shape list tolerates spacing and empty entries.
     *
     * @return void
     */
    public function test_shape_list_parsing(): void {
        $this->resetAfterTest();
        $question = $this->question('conceptmap', ' circle , , rectangle ');

        $this->assertSame(['circle', 'rectangle'], $question->allowed_shapes());
    }
}
