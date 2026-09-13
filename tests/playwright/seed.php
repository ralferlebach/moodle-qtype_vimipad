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
 * CLI seed for the qtype_vimipad Playwright user stories.
 *
 * Creates a course with a teacher and a student, a ViMi Pad question with a
 * reference map in a course question category, and a quiz containing it. Prints
 * the environment the Playwright run reads. For a disposable dev/CI site only.
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
require_once($CFG->dirroot . '/mod/quiz/locallib.php');

/**
 * Create or fetch an enrolled user with a known password.
 *
 * @param string $base Username stem.
 * @param string $first First name.
 * @param string $last Last name.
 * @param string $pass Password.
 * @param int $courseid Course to enrol into.
 * @param string $rolename Archetype role shortname.
 * @return stdClass The user record.
 */
function qtype_seed_user($base, $first, $last, $pass, $courseid, $rolename) {
    global $DB, $CFG;
    $username = $base . '_' . $courseid;
    $user = $DB->get_record('user', ['username' => $username]);
    if (!$user) {
        $user = (object) [
            'username' => $username, 'auth' => 'manual', 'confirmed' => 1,
            'firstname' => $first, 'lastname' => $last,
            'email' => $username . '@example.invalid', 'mnethostid' => $CFG->mnet_localhost_id,
        ];
        $user->id = user_create_user($user, false, false);
    }
    update_internal_user_password($DB->get_record('user', ['id' => $user->id]), $pass);
    $role = $DB->get_record('role', ['archetype' => $rolename], '*', MUST_EXIST);
    $manual = enrol_get_plugin('manual');
    $instance = $DB->get_record('enrol', ['courseid' => $courseid, 'enrol' => 'manual'], '*', MUST_EXIST);
    $manual->enrol_user($instance, $user->id, $role->id);
    return $user;
}

$now = time();
$course = create_course((object) [
    'fullname' => 'ViMi qtype stories ' . $now,
    'shortname' => 'vqstories' . $now,
    'category' => 1,
    'numsections' => 1,
]);
$teacher = qtype_seed_user('vqt_t', 'Tay', 'Teacher', 'Vimi!qt_T1', $course->id, 'editingteacher');
$student = qtype_seed_user('vqt_s', 'Sam', 'Student', 'Vimi!qt_S1', $course->id, 'student');
$coursecontext = context_course::instance($course->id);

// Question category + a ViMi Pad question with a reference map.
$category = (object) [
    'name' => 'Story questions', 'contextid' => $coursecontext->id, 'info' => '', 'infoformat' => FORMAT_HTML,
    'stamp' => make_unique_id_code(), 'parent' => 0, 'sortorder' => 999,
];
$category->id = $DB->insert_record('question_categories', $category);

$referencemap = json_encode([
    'profile' => 'conceptmap',
    'nodes' => [['stableid' => 'a', 'label' => 'Water'], ['stableid' => 'b', 'label' => 'Ice']],
    'relations' => [['stableid' => 'r1', 'sourceid' => 'a', 'targetid' => 'b', 'label' => 'freezes to']],
]);
$entry = (object) ['questioncategoryid' => $category->id, 'idnumber' => null, 'ownerid' => $teacher->id];
$entry->id = $DB->insert_record('question_bank_entries', $entry);
$question = (object) [
    'parent' => 0, 'name' => 'States of water', 'questiontext' => 'Map how water changes state.',
    'questiontextformat' => FORMAT_HTML, 'generalfeedback' => '', 'generalfeedbackformat' => FORMAT_HTML,
    'defaultmark' => 1, 'penalty' => 0, 'qtype' => 'vimipad', 'length' => 1,
    'stamp' => make_unique_id_code(), 'timecreated' => $now, 'timemodified' => $now,
    'createdby' => $teacher->id, 'modifiedby' => $teacher->id,
];
$question->id = $DB->insert_record('question', $question);
$DB->insert_record('question_versions', (object) [
    'questionbankentryid' => $entry->id, 'version' => 1, 'questionid' => $question->id, 'status' => 'ready',
]);
$DB->insert_record('qtype_vimipad_options', (object) [
    'questionid' => $question->id, 'profile' => 'conceptmap', 'allowedshapes' => '',
    'referencemap' => $referencemap, 'minnodes' => 0, 'minrelations' => 0,
]);

// Quiz containing the question.
$module = $DB->get_record('modules', ['name' => 'quiz'], '*', MUST_EXIST);
// The quiz module has NOT NULL columns without database defaults (password,
// subnet, the review-option bitmasks and the timing fields). add_moduleinfo()
// does not fill them in, so they must be supplied explicitly or the insert
// aborts the transaction with a not-null violation.
$created = add_moduleinfo((object) [
    'modulename' => 'quiz', 'module' => $module->id, 'course' => $course->id, 'section' => 1,
    'visible' => 1, 'name' => 'Water quiz', 'intro' => '', 'introformat' => FORMAT_HTML,
    'preferredbehaviour' => 'deferredfeedback', 'attempts' => 0, 'grade' => 100,
    'timeopen' => 0, 'timeclose' => 0, 'timelimit' => 0, 'overduehandling' => 'autosubmit',
    'graceperiod' => 0, 'grademethod' => 1, 'decimalpoints' => 2, 'questiondecimalpoints' => -1,
    'questionsperpage' => 1, 'navmethod' => 'free', 'shuffleanswers' => 1,
    // quiz_add_instance() overwrites password from the form field quizpassword
    // (lib.php: $quiz->password = $quiz->quizpassword), so setting 'password'
    // alone leaves the column null and the insert fails. Supply both.
    'sumgrades' => 0, 'quizpassword' => '', 'password' => '', 'subnet' => '',
    'browsersecurity' => '-',
    'delay1' => 0, 'delay2' => 0, 'showuserpicture' => 0, 'showblocks' => 0,
    'completionattemptsexhausted' => 0, 'completionminattempts' => 0, 'allowofflineattempts' => 0,
    'reviewattempt' => 69904, 'reviewcorrectness' => 4368, 'reviewmarks' => 4368,
    'reviewspecificfeedback' => 4368, 'reviewgeneralfeedback' => 4368,
    'reviewrightanswer' => 4368, 'reviewoverallfeedback' => 4368,
], $course);
$quizcmid = (int) $created->coursemodule;
$quiz = $DB->get_record('quiz', ['id' => $created->instance], '*', MUST_EXIST);
quiz_add_quiz_question($question->id, $quiz);

$quizpath = '/mod/quiz/view.php?id=' . $quizcmid;

echo "export VIMIQTYPE_BASE_URL='{$CFG->wwwroot}'\n";
echo "export VIMIQTYPE_QUIZ_PATH='{$quizpath}'\n";
echo "export VIMIQTYPE_QUIZ_CMID='{$quizcmid}'\n";
echo "export VIMIQTYPE_COURSE_ID='{$course->id}'\n";
echo "export VIMIQTYPE_TEACHER='{$teacher->username}'\n";
echo "export VIMIQTYPE_TEACHER_PASS='Vimi!qt_T1'\n";
echo "export VIMIQTYPE_TEACHER_NAME='Tay Teacher'\n";
echo "export VIMIQTYPE_STUDENT='{$student->username}'\n";
echo "export VIMIQTYPE_STUDENT_PASS='Vimi!qt_S1'\n";
echo "export VIMIQTYPE_STUDENT_NAME='Sam Student'\n";
