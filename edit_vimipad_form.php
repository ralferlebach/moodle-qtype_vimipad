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

        // The shape vocabulary comes from the parent plugin, so the form can only
        // offer shapes that actually exist. A free-text field let a teacher enter
        // a value the browser silently dropped while the server kept it, which
        // meant the two ends could disagree about what the question permits.
        $shapes = $mform->addElement(
            'select',
            'allowedshapes',
            get_string('allowedshapes', 'qtype_vimipad'),
            self::shape_options()
        );
        $shapes->setMultiple(true);
        $mform->addHelpButton('allowedshapes', 'allowedshapes', 'qtype_vimipad');

        $mform->addElement('header', 'gradingheader', get_string('grading', 'qtype_vimipad'));

        $mform->addElement(
            'filepicker',
            'referencemapfile',
            get_string('referencemap', 'qtype_vimipad'),
            null,
            [
                'accepted_types' => ['.json'],
                'maxfiles' => 1,
                'maxbytes' => \mod_vimipad\api\value::MAX_BYTES,
            ]
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
     * Turn the stored shape list back into the array the multiselect expects.
     *
     * @param object $question The question being edited.
     * @return object The prepared question data.
     */
    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        $stored = $question->options->allowedshapes ?? ($question->allowedshapes ?? '');
        $question->allowedshapes = array_values(array_filter(
            array_map('trim', explode(',', (string) $stored)),
            fn($shape) => $shape !== ''
        ));
        return $question;
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

        $profile = !empty($fromform['profile']) ? (string) $fromform['profile'] : null;
        $shapes = self::normalise_shapes($fromform['allowedshapes'] ?? [], $profile);

        // A shape the chosen profile does not support cannot be required.
        $unsupported = array_diff(self::normalise_shapes($fromform['allowedshapes'] ?? [], null), $shapes);
        if (!empty($unsupported)) {
            $errors['allowedshapes'] = get_string('shapesnotinprofile', 'qtype_vimipad');
        }

        $referror = self::reference_error($fromform, $profile, $shapes);
        if ($referror !== null) {
            $errors[$referror] = get_string('referencemapincompatible', 'qtype_vimipad');
        }

        return $errors;
    }

    /**
     * The shapes the parent plugin defines, as form options.
     *
     * @return array Map of shape key => label.
     */
    protected static function shape_options(): array {
        $options = [];
        foreach (self::profile_shapes(null) as $shape) {
            $options[$shape] = get_string('shape:' . $shape, 'qtype_vimipad');
        }
        return $options;
    }

    /**
     * The shapes a profile supports, or the union across all profiles when no
     * profile is given.
     *
     * @param string|null $profile The profile key, or null for the union.
     * @return array The shape keys.
     */
    protected static function profile_shapes(?string $profile): array {
        $profiles = $profile !== null
            ? [$profile]
            : array_keys(\mod_vimipad\profile\profiles::all());

        $shapes = [];
        foreach ($profiles as $key) {
            if (!\mod_vimipad\profile\profiles::exists($key)) {
                continue;
            }
            $config = \mod_vimipad\profile\profiles::form_config($key);
            foreach ($config['allowedshapes'] ?? [] as $shape) {
                $shapes[$shape] = true;
            }
        }
        return array_keys($shapes);
    }

    /**
     * Reduce a submitted shape selection to real, deduplicated shape keys,
     * optionally restricted to those the given profile supports.
     *
     * @param mixed $submitted The submitted value (array from the multiselect).
     * @param string|null $profile Restrict to this profile's shapes, or null.
     * @return array The shape keys.
     */
    protected static function normalise_shapes($submitted, ?string $profile): array {
        $values = is_array($submitted)
            ? $submitted
            : array_map('trim', explode(',', (string) $submitted));

        $known = self::profile_shapes($profile);
        $out = [];
        foreach ($values as $shape) {
            $shape = trim((string) $shape);
            if ($shape !== '' && in_array($shape, $known, true)) {
                $out[$shape] = true;
            }
        }
        return array_keys($out);
    }

    /**
     * Check the reference map that will actually be stored.
     *
     * The reference is scored against learner responses, so it must satisfy the
     * same policy they do. Both a newly uploaded file and an already saved one
     * are checked: without the second case a teacher could switch the profile or
     * tighten the shapes and leave behind a reference that no longer matches what
     * learners are now required to produce.
     *
     * @param array $fromform The submitted form data.
     * @param string|null $profile The chosen profile.
     * @param array $shapes The chosen shape restriction.
     * @return string|null The form element to attach the error to, or null.
     */
    protected static function reference_error(array $fromform, ?string $profile, array $shapes): ?string {
        $uploaded = !empty($fromform['referencemapfile']);
        $content = $uploaded
            ? \qtype_vimipad::reference_from_draft((int) $fromform['referencemapfile'])
            : null;

        if (($content === null || trim($content) === '') && !empty($fromform['id'])) {
            $content = self::stored_reference((int) $fromform['id']);
        }
        if ($content === null || trim($content) === '') {
            return null;
        }
        if (\mod_vimipad\api\value::is_valid(trim($content), $profile, $shapes)) {
            return null;
        }
        return $uploaded ? 'referencemapfile' : 'profile';
    }

    /**
     * The reference map currently stored for a question.
     *
     * @param int $questionid The question id.
     * @return string|null The stored reference, or null.
     */
    protected static function stored_reference(int $questionid): ?string {
        global $DB;
        $stored = $DB->get_field('qtype_vimipad_options', 'referencemap', ['questionid' => $questionid]);
        return ($stored === false || $stored === null) ? null : (string) $stored;
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
