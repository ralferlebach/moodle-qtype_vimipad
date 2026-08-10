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

/**
 * ViMi Pad question definition (the runtime, per-attempt object).
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Represents a ViMi Pad question at attempt time.
 *
 * The response is the serialised map (a frozen ViMi Pad snapshot in JSON), which
 * maps onto the snapshot-based assessment model of the activity. The question is
 * graded automatically: the learner's map is scored against the author's
 * reference map, or — when none is set — against configured structural minimums.
 */
class qtype_vimipad_question extends question_graded_automatically {
    /** @var string The diagram profile key this question is constrained to. */
    public $profile;

    /** @var string Comma-separated list of allowed node shapes (empty = profile default). */
    public $allowedshapes;

    /** @var string|null The author's reference map (serialised), or null. */
    public $referencemap;

    /** @var int Minimum number of nodes expected (structural grading). */
    public $minnodes = 0;

    /** @var int Minimum number of relations expected (structural grading). */
    public $minrelations = 0;

    /**
     * The single expected response field: the serialised map.
     *
     * @return array Field name => PARAM type.
     */
    public function get_expected_data() {
        return ['answer' => PARAM_RAW];
    }

    /**
     * The correct response, when a reference map is available.
     *
     * @return array|null
     */
    public function get_correct_response() {
        if ($this->referencemap !== null && trim((string)$this->referencemap) !== '') {
            return ['answer' => (string)$this->referencemap];
        }
        return null;
    }

    /**
     * A response is complete once a non-empty map has been provided.
     *
     * @param array $response The response to check.
     * @return bool
     */
    public function is_complete_response(array $response) {
        return !empty($response['answer']) && trim((string)$response['answer']) !== '';
    }

    /**
     * A response is gradable under the same condition it is complete.
     *
     * @param array $response The response to check.
     * @return bool
     */
    public function is_gradable_response(array $response) {
        return $this->is_complete_response($response);
    }

    /**
     * Validation message shown when an empty map is submitted.
     *
     * @param array $response The response to check.
     * @return string
     */
    public function get_validation_error(array $response) {
        if ($this->is_complete_response($response)) {
            return '';
        }
        return get_string('pleasedrawmap', 'qtype_vimipad');
    }

    /**
     * Two responses are the same when their serialised maps match.
     *
     * @param array $prevresponse Earlier response.
     * @param array $newresponse Later response.
     * @return bool
     */
    public function is_same_response(array $prevresponse, array $newresponse) {
        return question_utils::arrays_same_at_key_missing_is_blank(
            $prevresponse,
            $newresponse,
            'answer'
        );
    }

    /**
     * A short, plain-text summary of the submitted map for reports and grading lists.
     *
     * @param array $response The response to summarise.
     * @return string|null
     */
    public function summarise_response(array $response) {
        if (!isset($response['answer'])) {
            return null;
        }
        $counts = \qtype_vimipad\local\scorer::counts((string)$response['answer']);
        return get_string('responsesummary', 'qtype_vimipad', (object)[
            'nodes' => $counts['nodes'],
            'relations' => $counts['relations'],
        ]);
    }

    /**
     * Grade the response automatically.
     *
     * @param array $response The response to grade.
     * @return array Fraction and resulting state.
     */
    public function grade_response(array $response) {
        $answer = isset($response['answer']) ? (string)$response['answer'] : '';
        $fraction = \qtype_vimipad\local\scorer::score(
            $answer,
            $this->referencemap,
            (int)$this->minnodes,
            (int)$this->minrelations
        );
        return [$fraction, question_state::graded_state_for_fraction($fraction)];
    }

    /**
     * No embedded files in the stub response area.
     *
     * @param question_attempt $qa The question attempt being displayed.
     * @param question_display_options $options Display options.
     * @param string $component The component name.
     * @param string $filearea The file area.
     * @param array $args Remaining file path arguments.
     * @param bool $forcedownload Whether to force download.
     * @return bool
     */
    public function check_file_access($qa, $options, $component, $filearea, $args, $forcedownload) {
        return false;
    }
}
