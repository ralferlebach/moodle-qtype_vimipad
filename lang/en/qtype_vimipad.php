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
 * English language strings for qtype_vimipad.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Allowed node shapes';
$string['allowedshapes_help'] = 'An optional comma-separated list of node shapes the learner may use. Leave empty to allow every shape the chosen diagram profile permits.';
$string['answer'] = 'Your map';
$string['grading'] = 'Automatic grading';
$string['mapsettings'] = 'Map settings';
$string['minnodes'] = 'Minimum nodes';
$string['minnodes_help'] = 'Used only when no reference map is set. The learner earns half of the mark once their map contains at least this many nodes. Zero means this half is always awarded.';
$string['minrelations'] = 'Minimum relations';
$string['minrelations_help'] = 'Used only when no reference map is set. The learner earns half of the mark once their map contains at least this many relations. Zero means this half is always awarded.';
$string['pleasedrawmap'] = 'Please build your map before submitting.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'A ViMi Pad question asks the learner to build a visual knowledge map (concept map, mind map, tree and more) constrained to a chosen diagram profile. The submitted map is graded automatically against the author\'s reference map, or against minimum structural requirements when no reference is set.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'Adding a ViMi Pad question';
$string['pluginnameediting'] = 'Editing a ViMi Pad question';
$string['pluginnamesummary'] = 'Lets learners build a visual knowledge map as their answer, constrained to a diagram profile and graded automatically. Powered by the ViMi Pad activity (mod_vimipad).';
$string['privacy:metadata'] = 'The ViMi Pad question type stores no personal data of its own. The learner\'s map is stored by the Moodle question engine as the attempt response.';
$string['profile'] = 'Diagram profile';
$string['profile_help'] = 'The ViMi Pad diagram profile the learner\'s map is constrained to, for example concept map, mind map or tree. The list is provided by the ViMi Pad activity.';
$string['referencemap'] = 'Reference map';
$string['referencemap_help'] = 'Upload an author solution as a ViMi Pad map exported to JSON. When set, the learner\'s map is scored on how many of the reference nodes and relations it reproduces. Leave empty to grade against the minimum node and relation counts instead.';
$string['referencemapinvalid'] = 'The uploaded file is not valid JSON. Please upload a ViMi Pad map exported as JSON.';
$string['responsesummary'] = 'Map with {$a->nodes} node(s) and {$a->relations} relation(s)';
$string['stubhint'] = 'Early preview: paste or type the serialised map here. The interactive ViMi Pad editor will replace this field.';
