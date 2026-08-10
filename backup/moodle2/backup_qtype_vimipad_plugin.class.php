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
 * Backup support for the ViMi Pad question type.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Provides the information to back up ViMi Pad questions.
 */
class backup_qtype_vimipad_plugin extends backup_qtype_plugin {
    /**
     * Return the qtype information to attach to the question element.
     *
     * @return backup_plugin_element
     */
    protected function define_question_plugin_structure() {
        $plugin = $this->get_plugin_element(null, '../../qtype', 'vimipad');

        $pluginwrapper = new backup_nested_element($this->get_recommended_name());
        $plugin->add_child($pluginwrapper);

        $options = new backup_nested_element(
            'vimipad',
            ['id'],
            ['profile', 'allowedshapes', 'referencemap', 'minnodes', 'minrelations']
        );
        $pluginwrapper->add_child($options);

        $options->set_source_table('qtype_vimipad_options', ['questionid' => backup::VAR_PARENTID]);

        return $plugin;
    }
}
