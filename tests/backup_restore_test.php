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

namespace qtype_vimipad;

use backup;
use backup_controller;
use restore_controller;
use restore_dbops;

/**
 * Backup and restore roundtrip for ViMi Pad questions.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \backup_qtype_vimipad_plugin
 * @covers     \restore_qtype_vimipad_plugin
 */
final class backup_restore_test extends \advanced_testcase {
    /**
     * A ViMi Pad question keeps its options through a course backup and restore.
     *
     * The reference map, profile and shape restriction are what make the
     * question gradable and constrained, so losing any of them on restore would
     * silently change how learners are assessed.
     *
     * @return void
     */
    public function test_question_options_survive_roundtrip(): void {
        global $DB, $USER, $CFG;
        require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');
        require_once($CFG->dirroot . '/backup/util/includes/restore_includes.php');

        $this->resetAfterTest();
        $this->setAdminUser();
        $CFG->backup_file_logger_level = backup::LOG_NONE;

        $course = $this->getDataGenerator()->create_course();
        $generator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $category = $generator->create_question_category(['contextid' => \context_course::instance($course->id)->id]);

        $referencemap = (string) json_encode([
            'profile' => 'conceptmap',
            'nodes' => [
                ['stableid' => 'a', 'label' => 'Water'],
                ['stableid' => 'b', 'label' => 'Ice'],
            ],
            'relations' => [
                ['stableid' => 'r1', 'sourceid' => 'a', 'targetid' => 'b', 'label' => 'freezes to'],
            ],
        ]);
        $question = $generator->create_question('vimipad', 'reference', ['category' => $category->id]);
        $DB->set_field('qtype_vimipad_options', 'referencemap', $referencemap, ['questionid' => $question->id]);
        $DB->set_field('qtype_vimipad_options', 'allowedshapes', 'rect,ellipse', ['questionid' => $question->id]);
        $DB->set_field('qtype_vimipad_options', 'profile', 'conceptmap', ['questionid' => $question->id]);

        // Back the course up and restore it into a new one.
        $bc = new backup_controller(
            backup::TYPE_1COURSE,
            $course->id,
            backup::FORMAT_MOODLE,
            backup::INTERACTIVE_NO,
            backup::MODE_IMPORT,
            $USER->id
        );
        $backupid = $bc->get_backupid();
        $bc->execute_plan();
        $bc->destroy();

        $newcourseid = restore_dbops::create_new_course('Restored', 'restored_' . uniqid(), $course->category);
        $rc = new restore_controller(
            $backupid,
            $newcourseid,
            backup::INTERACTIVE_NO,
            backup::MODE_GENERAL,
            $USER->id,
            backup::TARGET_NEW_COURSE
        );
        $this->assertTrue($rc->execute_precheck());
        $rc->execute_plan();
        $rc->destroy();

        // The restored question carries the same options.
        $restoredcontext = \context_course::instance($newcourseid);
        $sql = "SELECT o.*
                  FROM {qtype_vimipad_options} o
                  JOIN {question} q ON q.id = o.questionid
                  JOIN {question_versions} qv ON qv.questionid = q.id
                  JOIN {question_bank_entries} qbe ON qbe.id = qv.questionbankentryid
                  JOIN {question_categories} qc ON qc.id = qbe.questioncategoryid
                 WHERE qc.contextid = :contextid";
        $options = $DB->get_records_sql($sql, ['contextid' => $restoredcontext->id]);

        $this->assertCount(1, $options);
        $restored = reset($options);
        $this->assertSame($referencemap, $restored->referencemap);
        $this->assertSame('rect,ellipse', $restored->allowedshapes);
        $this->assertSame('conceptmap', $restored->profile);
    }
}
