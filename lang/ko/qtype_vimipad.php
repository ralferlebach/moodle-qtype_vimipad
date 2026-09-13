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
 * Korean language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = '허용되는 노드 모양';
$string['allowedshapes_help'] = '학습자가 사용할 수 있는 노드 모양을 쉼표로 구분한 선택 목록입니다. 비워 두면 선택한 다이어그램 프로필이 허용하는 모든 모양을 사용할 수 있습니다.';
$string['answer'] = '내 맵';
$string['grading'] = '자동 채점';
$string['invalidmap'] = '제출된 맵은 이 문제에 유효한 ViMi Pad 맵이 아닙니다.';
$string['mapsettings'] = '맵 설정';
$string['minnodes'] = '최소 노드 수';
$string['minnodes_help'] = '참조 맵이 설정되지 않은 경우에만 사용됩니다. 맵에 이 수 이상의 노드가 포함되면 학습자는 배점의 절반을 얻습니다. 0이면 이 절반은 항상 부여됩니다.';
$string['minrelations'] = '최소 관계 수';
$string['minrelations_help'] = '참조 맵이 설정되지 않은 경우에만 사용됩니다. 맵에 이 수 이상의 관계가 포함되면 학습자는 배점의 절반을 얻습니다. 0이면 이 절반은 항상 부여됩니다.';
$string['noscript'] = '이 문제에서 맵을 작성하려면 JavaScript를 활성화해야 합니다.';
$string['pleasedrawmap'] = '제출하기 전에 맵을 작성하세요.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'ViMi Pad 문제는 선택한 다이어그램 프로필로 제한된 시각적 지식 맵(개념도, 마인드맵, 트리 등)을 작성하도록 학습자에게 요구합니다. 제출된 맵은 작성자의 참조 맵을 기준으로 자동 채점되며, 참조 맵이 없으면 최소 구조 요건을 기준으로 채점됩니다.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'ViMi Pad 문제 추가';
$string['pluginnameediting'] = 'ViMi Pad 문제 편집';
$string['pluginnamesummary'] = '학습자가 답안으로 시각적 지식 맵을 작성하도록 하며, 다이어그램 프로필로 제한되고 자동으로 채점됩니다. ViMi Pad 활동(mod_vimipad)을 기반으로 합니다.';
$string['privacy:metadata'] = 'ViMi Pad 문제 유형 자체는 개인정보를 저장하지 않습니다. 학습자의 맵은 Moodle 문제 엔진이 응시 응답으로 저장합니다.';
$string['profile'] = '다이어그램 프로필';
$string['profile_help'] = '학습자의 맵이 제한되는 ViMi Pad 다이어그램 프로필입니다. 예를 들어 개념도, 마인드맵 또는 트리입니다. 목록은 ViMi Pad 활동에서 제공합니다.';
$string['referencemap'] = '참조 맵';
$string['referencemap_help'] = '작성자의 해답을 JSON으로 내보낸 ViMi Pad 맵으로 업로드하세요. 설정하면 학습자의 맵은 참조의 노드와 관계를 얼마나 재현했는지에 따라 채점됩니다. 비워 두면 대신 최소 노드 수와 관계 수로 채점합니다.';
$string['referencemapincompatible'] = '참조 맵이 선택한 프로필 및 허용된 모양과 일치하지 않습니다. 일치하는 참조 맵을 업로드하거나 프로필을 되돌리세요.';
$string['referencemapinvalid'] = '업로드한 파일이 유효한 JSON이 아닙니다. JSON으로 내보낸 ViMi Pad 맵을 업로드하세요.';
$string['responsesummary'] = '노드 {$a->nodes}개와 관계 {$a->relations}개가 있는 맵';
$string['shape:ellipse'] = '타원';
$string['shape:rect'] = '직사각형';
$string['shape:roundrect'] = '둥근 직사각형';
$string['shapesnotinprofile'] = '선택한 모양 중 하나 이상이 선택한 다이어그램 프로필에서 지원되지 않습니다.';
