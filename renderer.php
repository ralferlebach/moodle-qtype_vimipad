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
 * The response area embeds the interactive ViMi Pad editor from mod_vimipad. The
 * whole map is a single self-contained value: a hidden input carries the
 * serialised map, and the editor (mounted through mod_vimipad/editor_lazy
 * mountValue) mirrors every edit back into it, so the map is submitted with the
 * quiz form and graded automatically.
 */
class qtype_vimipad_renderer extends qtype_renderer {
    /**
     * Render the question text and the editor response area.
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
        $inputid = $inputname . '_value';
        $containerid = $inputname . '_editor';
        $current = $qa->get_last_qt_var('answer', '');

        $profile = isset($question->profile) ? (string) $question->profile : 'conceptmap';
        $readonly = !empty($options->readonly);

        // The hidden value field carries the serialised map. It only submits when
        // the attempt is editable; a read-only display still seeds the editor.
        $inputattrs = [
            'type' => 'hidden',
            'id' => $inputid,
            'value' => (string) $current,
        ];
        if (!$readonly) {
            $inputattrs['name'] = $inputname;
        }
        $hidden = html_writer::empty_tag('input', $inputattrs);

        $container = html_writer::tag('div', '', [
            'id' => $containerid,
            'class' => 'qtype_vimipad_editor',
            'style' => 'min-height:480px;',
        ]);

        $noscript = html_writer::tag(
            'noscript',
            html_writer::tag('div', get_string('noscript', 'qtype_vimipad'), ['class' => 'text-muted'])
        );

        $out .= html_writer::tag(
            'div',
            $hidden . $container . $noscript,
            ['class' => 'qtype_vimipad_response ablock']
        );

        if (!$readonly && $qa->get_state() == question_state::$invalid) {
            $out .= html_writer::nonempty_tag(
                'div',
                $question->get_validation_error(['answer' => $current]),
                ['class' => 'validationerror']
            );
        }

        $this->preload_editor_strings();
        $this->page->requires->js_call_amd('qtype_vimipad/attempt', 'init', [
            $containerid, $inputid, $profile, $readonly,
        ]);

        return $out;
    }

    /**
     * Preload the mod_vimipad editor language strings so the embedded editor
     * resolves them, without hard-coding the key list in this plugin.
     *
     * @return void
     */
    protected function preload_editor_strings() {
        $strings = get_string_manager()->load_component_strings('mod_vimipad', current_language());
        $keys = [];
        foreach (array_keys($strings) as $key) {
            if (strpos($key, 'editor:') === 0 || strpos($key, 'constraint:') === 0) {
                $keys[] = $key;
            }
        }
        if ($keys) {
            $this->page->requires->strings_for_js($keys, 'mod_vimipad');
        }
    }

    /**
     * ViMi Pad questions show no automatic specific feedback in the stub.
     *
     * @param question_attempt $qa The question attempt to display.
     * @return string HTML fragment.
     */
    public function specific_feedback(question_attempt $qa) {
        return '';
    }
}
