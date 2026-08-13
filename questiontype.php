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
 * attempt response and scored automatically against the question's reference map
 * through mod_vimipad's public scoring facade, mirroring the assessment model of
 * the mod_vimipad activity. Teachers can still override the grade.
 *
 * The interactive editor is embedded directly in the attempt: a ViMi Pad
 * transport bound to the question response carries the map, so what the learner
 * submits is exactly what the editor produced. Responses are validated against
 * the public map policy before they are accepted or graded.
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
        global $DB;
        if (empty($formdata->profile)) {
            $formdata->profile = 'conceptmap';
        }
        // The form posts a multiselect; the option column stores a plain list.
        if (!isset($formdata->allowedshapes)) {
            $formdata->allowedshapes = '';
        } else if (is_array($formdata->allowedshapes)) {
            $formdata->allowedshapes = implode(',', array_map('strval', $formdata->allowedshapes));
        }
        // Preserve any stored reference map so an edit without a new upload keeps it.
        $existing = '';
        if (!empty($formdata->id)) {
            $existing = (string)$DB->get_field(
                'qtype_vimipad_options',
                'referencemap',
                ['questionid' => $formdata->id]
            );
        }
        $formdata->referencemap = $existing;
        // A freshly uploaded ViMi Pad JSON export replaces the stored reference map.
        if (!empty($formdata->referencemapfile)) {
            $uploaded = self::reference_from_draft((int)$formdata->referencemapfile);
            if ($uploaded !== null && trim($uploaded) !== '') {
                $formdata->referencemap = $uploaded;
            }
        }
        $formdata->minnodes = max(0, (int)($formdata->minnodes ?? 0));
        $formdata->minrelations = max(0, (int)($formdata->minrelations ?? 0));
        return parent::save_question_options($formdata);
    }

    /**
     * Read the content of a JSON file uploaded via the reference-map filepicker.
     *
     * @param int $draftitemid The draft area item id produced by the filepicker.
     * @return string|null The uploaded file content, or null when nothing was uploaded.
     */
    public static function reference_from_draft(int $draftitemid): ?string {
        global $USER;
        if (empty($draftitemid)) {
            return null;
        }
        $usercontext = context_user::instance($USER->id);
        $fs = get_file_storage();
        $files = $fs->get_area_files(
            $usercontext->id,
            'user',
            'draft',
            $draftitemid,
            'id DESC',
            false
        );
        $file = reset($files);
        if (!$file) {
            return null;
        }
        // Check the size before reading: a draft area can be manipulated
        // independently of the form, so the picker's limit is not sufficient on
        // its own and get_content() would pull the whole file into memory first.
        if ($file->get_filesize() > \mod_vimipad\api\value::MAX_BYTES) {
            return null;
        }
        return $file->get_content();
    }
}
