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
 * ViMi Pad question renderer.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Generates the output for ViMi Pad questions.
 *
 * Stub behaviour: the response area is a plain-text field carrying the
 * serialised map so that attempts can already be submitted and manually graded.
 * The interactive ViMi Pad editor embed — mounting mod_vimipad/editor_lazy with
 * a ServiceTransport bound to the question attempt — replaces this field in a
 * follow-up step.
 */
class qtype_vimipad_renderer extends qtype_renderer {
    /**
     * Render the question text and the (stub) response area.
     *
     * @param question_attempt $qa The question attempt to display.
     * @param question_display_options $options Controls what may be shown.
     * @return string HTML fragment.
     */
    public function formulation_and_controls(question_attempt $qa, question_display_options $options) {
        $question = $qa->get_question();

        $questiontext = $question->format_questiontext($qa);
        $out = html_writer::tag('div', $questiontext, ['class' => 'qtext']);

        $inputname = $qa->get_qt_field_name('answer');
        $current = $qa->get_last_qt_var('answer', '');

        if ($options->readonly) {
            $summary = $question->summarise_response(['answer' => $current]);
            $out .= html_writer::tag(
                'div',
                s((string)$summary),
                ['class' => 'qtype_vimipad_response readonly']
            );
            return $out;
        }

        $label = html_writer::tag(
            'label',
            get_string('answer', 'qtype_vimipad'),
            ['for' => $inputname, 'class' => 'sr-only']
        );
        $textarea = html_writer::tag('textarea', s((string)$current), [
            'id' => $inputname,
            'name' => $inputname,
            'rows' => 6,
            'class' => 'form-control qtype_vimipad_answer',
            'spellcheck' => 'false',
        ]);
        $hint = html_writer::tag(
            'div',
            get_string('stubhint', 'qtype_vimipad'),
            ['class' => 'qtype_vimipad_stubhint text-muted']
        );

        $out .= html_writer::tag(
            'div',
            $label . $textarea . $hint,
            ['class' => 'qtype_vimipad_response ablock']
        );

        if ($qa->get_state() == question_state::$invalid) {
            $out .= html_writer::nonempty_tag(
                'div',
                $question->get_validation_error(['answer' => $current]),
                ['class' => 'validationerror']
            );
        }

        return $out;
    }

    /**
     * Manually graded questions show no automatic specific feedback.
     *
     * @param question_attempt $qa The question attempt to display.
     * @return string HTML fragment.
     */
    public function specific_feedback(question_attempt $qa) {
        return '';
    }
}
