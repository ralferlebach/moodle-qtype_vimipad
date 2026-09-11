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
 * CLI seed for the qtype_vimipad JMeter/k6 load test.
 *
 * Creates a course with a quiz holding several ViMi Pad questions, each with a
 * large reference map, plus a set of students. Unlike mod_vimipad and the
 * gallery, this question type exposes no web service: a learner meets it through
 * ordinary quiz pages. The load runs are therefore session-based — they log in
 * and request the quiz view and attempt pages, which is exactly where the
 * embedded editor, the reference map and the response validation are paid for.
 *
 * Usage: php question/type/vimipad/tests/load/seed_large.php [questions] [nodes] [users]
 *   questions  ViMi Pad questions in the quiz (default 5)
 *   nodes      nodes in each reference map (default 300)
 *   users      students to create (default 25)
 *
 * Intended for a disposable dev/staging site — never point it at production.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('CLI_SCRIPT', true);

require(__DIR__ . '/../../../../../config.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/course/modlib.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->libdir . '/enrollib.php');
require_once($CFG->libdir . '/questionlib.php');

$questioncount = isset($argv[1]) ? max(1, (int) $argv[1]) : 5;
$nodecount = isset($argv[2]) ? max(1, (int) $argv[2]) : 300;
$usercount = isset($argv[3]) ? max(1, (int) $argv[3]) : 25;
$now = time();
$password = 'Vimi!load_1';

// Course.
$course = create_course((object) [
    'fullname' => 'qtype ViMi Pad load ' . $now,
    'shortname' => 'qtvpload' . $now,
    'category' => 1,
    'summaryformat' => FORMAT_HTML,
]);
$coursecontext = context_course::instance($course->id);
$studentrole = $DB->get_record('role', ['archetype' => 'student'], '*', MUST_EXIST);
$manual = enrol_get_plugin('manual');
$enrol = $DB->get_record('enrol', ['courseid' => $course->id, 'enrol' => 'manual'], '*', MUST_EXIST);

// Students. The load run cycles through them so attempts are not serialised on
// a single user's records.
$usernames = [];
for ($i = 0; $i < $usercount; $i++) {
    $username = 'qtvp_load_' . $now . '_' . $i;
    $user = (object) [
        'username' => $username,
        'auth' => 'manual',
        'confirmed' => 1,
        'firstname' => 'Quiz',
        'lastname' => 'Load' . $i,
        'email' => $username . '@example.invalid',
        'mnethostid' => $CFG->mnet_localhost_id,
    ];
    $user->id = user_create_user($user, false, false);
    update_internal_user_password($DB->get_record('user', ['id' => $user->id]), $password);
    $manual->enrol_user($enrol, $user->id, $studentrole->id);
    $usernames[] = $username;
}

// Quiz.
$module = $DB->get_record('modules', ['name' => 'quiz'], '*', MUST_EXIST);
$created = add_moduleinfo((object) [
    'modulename' => 'quiz',
    'module' => $module->id,
    'course' => $course->id,
    'section' => 0,
    'name' => 'Load quiz',
    'intro' => '',
    'introformat' => FORMAT_HTML,
    // Add_moduleinfo passes these straight to the module's callbacks, which read
    // them without checking: mod_data's grade-item update dereferences
    // cmidnumber, so omitting it raises a PHP warning during seeding.
    'cmidnumber' => '',
    'groupmode' => NOGROUPS,
    'groupingid' => 0,
    'completion' => COMPLETION_TRACKING_NONE,
    'visible' => 1,
    'preferredbehaviour' => 'deferredfeedback',
    'attempts' => 0,
    'grade' => 100,
], $course);
$cmid = (int) $created->coursemodule;
$quizid = (int) $created->instance;

// Question category in the course context.
$category = (object) [
    'name' => 'Load questions',
    'contextid' => $coursecontext->id,
    'info' => '',
    'infoformat' => FORMAT_HTML,
    'stamp' => make_unique_id_code(),
    'parent' => 0,
    'sortorder' => 999,
];
$category->id = $DB->insert_record('question_categories', $category);

// A large reference map, reused by every question.
$nodes = [];
$relations = [];
for ($i = 0; $i < $nodecount; $i++) {
    $nodes[] = ['stableid' => 'n' . $i, 'label' => 'Concept ' . $i];
}
for ($i = 0; $i < $nodecount - 1; $i++) {
    $relations[] = [
        'stableid' => 'r' . $i,
        'sourceid' => 'n' . $i,
        'targetid' => 'n' . ($i + 1),
        'label' => 'links',
    ];
}
$referencemap = (string) json_encode([
    'profile' => 'conceptmap',
    'nodes' => $nodes,
    'relations' => $relations,
]);

// Questions, wired into the quiz.
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
for ($q = 0; $q < $questioncount; $q++) {
    $entry = (object) [
        'questioncategoryid' => $category->id,
        'idnumber' => null,
        'ownerid' => 2,
    ];
    $entry->id = $DB->insert_record('question_bank_entries', $entry);

    $question = (object) [
        'parent' => 0,
        'name' => 'Load map ' . $q,
        'questiontext' => 'Build a concept map.',
        'questiontextformat' => FORMAT_HTML,
        'generalfeedback' => '',
        'generalfeedbackformat' => FORMAT_HTML,
        'defaultmark' => 1,
        'penalty' => 0,
        'qtype' => 'vimipad',
        'length' => 1,
        'stamp' => make_unique_id_code(),
        'timecreated' => $now,
        'timemodified' => $now,
        'createdby' => 2,
        'modifiedby' => 2,
    ];
    $question->id = $DB->insert_record('question', $question);
    $DB->insert_record('question_versions', (object) [
        'questionbankentryid' => $entry->id,
        'version' => 1,
        'questionid' => $question->id,
        'status' => 'ready',
    ]);
    $DB->insert_record('qtype_vimipad_options', (object) [
        'questionid' => $question->id,
        'profile' => 'conceptmap',
        'allowedshapes' => '',
        'referencemap' => $referencemap,
        'minnodes' => 0,
        'minrelations' => 0,
    ]);
    quiz_add_quiz_question($question->id, $DB->get_record('quiz', ['id' => $quizid], '*', MUST_EXIST));
}

echo "export BASE_URL='{$CFG->wwwroot}'\n";
echo "export CMID='{$cmid}'\n";
echo "export USERNAMES='" . implode(',', $usernames) . "'\n";
echo "export PASSWORD='{$password}'\n";
echo "# Quiz: {$questioncount} ViMi Pad questions, reference map {$nodecount} nodes ("
    . strlen($referencemap) . " bytes); {$usercount} students.\n";
echo "# Run: make jmeter  (or: make load-k6)\n";
