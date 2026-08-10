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
 * The ViMi Pad question type definition class.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');

/**
 * The ViMi Pad question type.
 *
 * A ViMi Pad question presents the learner with an embeddable visual-map editor
 * constrained to a chosen diagram profile. The learner's map is stored as the
 * attempt response and graded manually by the teacher (teacher-in-the-loop),
 * mirroring the snapshot-based assessment model of the mod_vimipad activity.
 *
 * This is an early stub: the option storage, edit form and manual-grading
 * response contract are in place; the interactive editor embed (a ViMi Pad
 * ServiceTransport bound to the question attempt) replaces the plain-text
 * response area in a follow-up step.
 */
class qtype_vimipad extends question_type {
    /**
     * The extra options table and its per-question columns.
     *
     * Returning the table here lets the base class handle load, save and delete
     * of the option row automatically.
     *
     * @return array Table name followed by column names.
     */
    public function extra_question_fields() {
        return ['qtype_vimipad_options', 'profile', 'allowedshapes',
            'referencemap', 'minnodes', 'minrelations'];
    }

    /**
     * Copy the stored options onto the runtime question instance.
     *
     * The chosen profile is clamped through the public profile API so a stale or
     * unknown profile key can never reach the editor.
     *
     * @param question_definition $question Runtime question instance.
     * @param object $questiondata Loaded question data including ->options.
     * @return void
     */
    protected function initialise_question_instance(question_definition $question, $questiondata) {
        parent::initialise_question_instance($question, $questiondata);
        $profile = $questiondata->options->profile ?? 'conceptmap';
        if (class_exists('\mod_vimipad\profile\profiles')) {
            $profile = \mod_vimipad\profile\profiles::exists($profile) ? $profile : 'conceptmap';
        }
        $question->profile = $profile;
        $question->allowedshapes = $questiondata->options->allowedshapes ?? '';
        $question->referencemap = $questiondata->options->referencemap ?? null;
        $question->minnodes = (int)($questiondata->options->minnodes ?? 0);
        $question->minrelations = (int)($questiondata->options->minrelations ?? 0);
    }

    /**
     * There is no meaningful random-guess score for an open-ended map.
     *
     * @param object $questiondata Loaded question data.
     * @return float
     */
    public function get_random_guess_score($questiondata) {
        return 0;
    }

    /**
     * Manually graded questions expose no automatic response classes.
     *
     * @param object $questiondata Loaded question data.
     * @return array
     */
    public function get_possible_responses($questiondata) {
        return [];
    }

    /**
     * Save the per-question options, applying safe defaults.
     *
     * @param object $formdata Submitted edit-form data.
     * @return object|null
     */
    public function save_question_options($formdata) {
        if (empty($formdata->profile)) {
            $formdata->profile = 'conceptmap';
        }
        if (!isset($formdata->allowedshapes)) {
            $formdata->allowedshapes = '';
        }
        if (!isset($formdata->referencemap)) {
            $formdata->referencemap = '';
        }
        $formdata->minnodes = max(0, (int)($formdata->minnodes ?? 0));
        $formdata->minrelations = max(0, (int)($formdata->minrelations ?? 0));
        return parent::save_question_options($formdata);
    }
}
