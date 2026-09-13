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
 * Chinese (Traditional) language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = '允許的節點形狀';
$string['allowedshapes_help'] = '以逗號分隔的選用清單，指定學員可使用的節點形狀。留空則允許所選圖示設定檔允許的所有形狀。';
$string['answer'] = '你的圖';
$string['grading'] = '自動評分';
$string['invalidmap'] = '提交的圖不是此題的有效 ViMi Pad 圖。';
$string['mapsettings'] = '圖設定';
$string['minnodes'] = '最少節點數';
$string['minnodes_help'] = '僅在未設定參考圖時使用。當圖中包含至少這麼多節點時，學員可獲得一半分數。零表示始終給予這一半。';
$string['minrelations'] = '最少關係數';
$string['minrelations_help'] = '僅在未設定參考圖時使用。當圖中包含至少這麼多關係時，學員可獲得一半分數。零表示始終給予這一半。';
$string['noscript'] = '此題需要啟用 JavaScript 才能建立圖。';
$string['pleasedrawmap'] = '提交前請先建立你的圖。';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'ViMi Pad 題目要求學員建立一個受所選圖示設定檔約束的視覺化知識圖（概念圖、心智圖、樹狀圖等）。提交的圖會依據作者的參考圖自動評分；若未設定參考圖，則依據最低結構需求評分。';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = '新增 ViMi Pad 題目';
$string['pluginnameediting'] = '編輯 ViMi Pad 題目';
$string['pluginnamesummary'] = '讓學員以視覺化知識圖作答，受圖示設定檔約束並自動評分。由 ViMi Pad 活動（mod_vimipad）提供支援。';
$string['privacy:metadata'] = 'ViMi Pad 題型本身不儲存任何個人資料。學員的圖由 Moodle 題目引擎作為作答記錄儲存。';
$string['profile'] = '圖示設定檔';
$string['profile_help'] = '學員的圖所受約束的 ViMi Pad 圖示設定檔，例如概念圖、心智圖或樹狀圖。該清單由 ViMi Pad 活動提供。';
$string['referencemap'] = '參考圖';
$string['referencemap_help'] = '上傳作者解答，作為匯出為 JSON 的 ViMi Pad 圖。設定後，學員的圖將依其重現了多少參考節點與關係來評分。留空則改以最少節點數與關係數評分。';
$string['referencemapincompatible'] = '參考圖與所選設定檔及允許的形狀不符。請上傳相符的參考圖，或將設定檔改回。';
$string['referencemapinvalid'] = '上傳的檔案不是有效的 JSON。請上傳匯出為 JSON 的 ViMi Pad 圖。';
$string['responsesummary'] = '包含 {$a->nodes} 個節點和 {$a->relations} 個關係的圖';
$string['shape:ellipse'] = '橢圓';
$string['shape:rect'] = '矩形';
$string['shape:roundrect'] = '圓角矩形';
$string['shapesnotinprofile'] = '所選形狀中有一個或多個不受所選圖示設定檔支援。';
