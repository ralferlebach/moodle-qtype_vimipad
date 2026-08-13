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
 * Test helper for the ViMi Pad question type.
 *
 * Provides a ready-made question instance for unit and (future) question-engine
 * walkthrough tests via test_question_maker::make_question('vimipad', ...).
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Test helper class for the ViMi Pad question type.
 */
class qtype_vimipad_test_helper extends question_test_helper {
    /**
     * The test question shortnames this helper can build.
     *
     * @return string[]
     */
    public function get_test_questions() {
        return ['stub', 'structural', 'reference'];
    }

    /**
     * Make a basic ViMi Pad question (concept-map profile).
     *
     * @return qtype_vimipad_question
     */
    public function make_vimipad_question_stub() {
        question_bank::load_question_definition_classes('vimipad');
        $q = new qtype_vimipad_question();
        test_question_maker::initialise_a_question($q);
        $q->name = 'ViMi Pad stub';
        $q->questiontext = 'Build a concept map for the topic.';
        $q->generalfeedback = 'Consider whether every node is connected.';
        $q->qtype = question_bank::get_qtype('vimipad');
        $q->profile = 'conceptmap';
        $q->allowedshapes = '';
        $q->referencemap = null;
        $q->minnodes = 0;
        $q->minrelations = 0;
        return $q;
    }

    /**
     * Make a ViMi Pad question graded against structural minimums (2 nodes, 1 relation).
     *
     * @return qtype_vimipad_question
     */
    public function make_vimipad_question_structural() {
        $q = $this->make_vimipad_question_stub();
        $q->name = 'ViMi Pad structural';
        $q->minnodes = 2;
        $q->minrelations = 1;
        return $q;
    }

    /**
     * Make a ViMi Pad question graded against a reference map.
     *
     * @return qtype_vimipad_question
     */
    public function make_vimipad_question_reference() {
        $q = $this->make_vimipad_question_stub();
        $q->name = 'ViMi Pad reference';
        $q->referencemap = json_encode([
            'profile' => 'conceptmap',
            'nodes' => [
                ['stableid' => 'a', 'label' => 'Water'],
                ['stableid' => 'b', 'label' => 'Ice'],
            ],
            'relations' => [
                ['sourceid' => 'a', 'targetid' => 'b', 'label' => 'freezes to'],
            ],
        ]);
        return $q;
    }

    /**
     * Return the raw form data for creating a ViMi Pad question.
     *
     * @return stdClass
     */
    /**
     * Edit form data for a question that carries a reference map and a shape
     * restriction, so generator-created questions can exercise the scored and
     * constrained path (not just the bare stub).
     *
     * @return stdClass The form data.
     */
    public function get_vimipad_question_form_data_reference() {
        $form = $this->get_vimipad_question_form_data_stub();
        $form->name = 'ViMi Pad reference';
        $form->allowedshapes = 'rect,ellipse';
        $form->minnodes = 2;
        $form->minrelations = 1;
        return $form;
    }

    /**
     * Edit form data for the bare stub question.
     *
     * @return stdClass The form data.
     */
    public function get_vimipad_question_form_data_stub() {
        $form = new stdClass();
        $form->name = 'ViMi Pad stub';
        $form->questiontext = ['text' => 'Build a concept map for the topic.', 'format' => FORMAT_HTML];
        $form->defaultmark = 1;
        $form->generalfeedback = ['text' => '', 'format' => FORMAT_HTML];
        $form->profile = 'conceptmap';
        $form->allowedshapes = '';
        $form->minnodes = 0;
        $form->minrelations = 0;
        return $form;
    }
}
