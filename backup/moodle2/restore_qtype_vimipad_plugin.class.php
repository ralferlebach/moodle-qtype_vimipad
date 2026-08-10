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
 * Restore support for the ViMi Pad question type.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Restore plugin class that provides the necessary information to restore ViMi Pad questions.
 */
class restore_qtype_vimipad_plugin extends restore_qtype_plugin {
    /**
     * Return the paths to be handled by the plugin at question level.
     *
     * @return restore_path_element[]
     */
    protected function define_question_plugin_structure() {
        $paths = [];

        $elename = 'vimipad';
        $elepath = $this->get_pathfor('/vimipad');
        $paths[] = new restore_path_element($elename, $elepath);

        return $paths;
    }

    /**
     * Process the vimipad element (a single options row).
     *
     * @param array $data The parsed element data.
     * @return void
     */
    public function process_vimipad($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;

        $questioncreated = $this->get_mappingid(
            'question_created',
            $this->get_old_parentid('question')
        ) ? true : false;

        if ($questioncreated) {
            $data->questionid = $this->get_new_parentid('question');
            $newitemid = $DB->insert_record('qtype_vimipad_options', $data);
            $this->set_mapping('qtype_vimipad_options', $oldid, $newitemid);
        }
    }
}
