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
 * Editing form for the ViMi Pad question type.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * ViMi Pad question editing form.
 *
 * The profile list and their display names come from the public profile API of
 * mod_vimipad, so the question type always offers exactly the diagram profiles
 * the activity supports — no duplicated list to keep in sync.
 */
class qtype_vimipad_edit_form extends question_edit_form {
    /**
     * Add the ViMi-Pad-specific fields to the editing form.
     *
     * @param MoodleQuickForm $mform The form being built.
     * @return void
     */
    protected function definition_inner($mform) {
        $mform->addElement('header', 'vimipadheader', get_string('mapsettings', 'qtype_vimipad'));

        $mform->addElement(
            'select',
            'profile',
            get_string('profile', 'qtype_vimipad'),
            $this->profile_options()
        );
        $mform->setDefault('profile', 'conceptmap');
        $mform->addHelpButton('profile', 'profile', 'qtype_vimipad');

        $mform->addElement(
            'text',
            'allowedshapes',
            get_string('allowedshapes', 'qtype_vimipad'),
            ['size' => 60]
        );
        $mform->setType('allowedshapes', PARAM_TEXT);
        $mform->addHelpButton('allowedshapes', 'allowedshapes', 'qtype_vimipad');

        $mform->addElement('header', 'gradingheader', get_string('grading', 'qtype_vimipad'));

        $mform->addElement(
            'filepicker',
            'referencemapfile',
            get_string('referencemap', 'qtype_vimipad'),
            null,
            ['accepted_types' => ['.json'], 'maxfiles' => 1]
        );
        $mform->addHelpButton('referencemapfile', 'referencemap', 'qtype_vimipad');

        $mform->addElement('text', 'minnodes', get_string('minnodes', 'qtype_vimipad'), ['size' => 6]);
        $mform->setType('minnodes', PARAM_INT);
        $mform->setDefault('minnodes', 0);
        $mform->addHelpButton('minnodes', 'minnodes', 'qtype_vimipad');

        $mform->addElement(
            'text',
            'minrelations',
            get_string('minrelations', 'qtype_vimipad'),
            ['size' => 6]
        );
        $mform->setType('minrelations', PARAM_INT);
        $mform->setDefault('minrelations', 0);
        $mform->addHelpButton('minrelations', 'minrelations', 'qtype_vimipad');
    }

    /**
     * Build the profile select options from the public profile API.
     *
     * @return array Profile key => human-readable name.
     */
    protected function profile_options(): array {
        $options = [];
        if (class_exists('\mod_vimipad\profile\profiles')) {
            foreach (\mod_vimipad\profile\profiles::all() as $key) {
                $config = \mod_vimipad\profile\profiles::form_config($key);
                $options[$key] = $config['name'] ?? $key;
            }
        }
        if (empty($options)) {
            // Defensive fallback; the declared dependency should make this unreachable.
            $options['conceptmap'] = 'conceptmap';
        }
        return $options;
    }

    /**
     * Reject an uploaded reference map that is not valid JSON.
     *
     * @param array $fromform Submitted form data.
     * @param array $files Submitted files.
     * @return array Validation errors keyed by element name.
     */
    public function validation($fromform, $files) {
        $errors = parent::validation($fromform, $files);
        if (!empty($fromform['referencemapfile'])) {
            $content = \qtype_vimipad::reference_from_draft((int)$fromform['referencemapfile']);
            if ($content !== null && trim($content) !== '' && json_decode($content) === null) {
                $errors['referencemapfile'] = get_string('referencemapinvalid', 'qtype_vimipad');
            }
        }
        return $errors;
    }

    /**
     * The question type name.
     *
     * @return string
     */
    public function qtype() {
        return 'vimipad';
    }
}
