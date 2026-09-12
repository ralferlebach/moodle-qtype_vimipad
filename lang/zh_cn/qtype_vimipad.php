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
 * Chinese (Simplified) language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = '允许的节点形状';
$string['allowedshapes_help'] = '以逗号分隔的可选列表，指定学员可使用的节点形状。留空则允许所选图示配置允许的所有形状。';
$string['answer'] = '你的图';
$string['grading'] = '自动评分';
$string['invalidmap'] = '提交的图不是此题的有效 ViMi Pad 图。';
$string['mapsettings'] = '图设置';
$string['minnodes'] = '最少节点数';
$string['minnodes_help'] = '仅在未设置参考图时使用。当图中包含至少这么多节点时，学员获得一半分数。零表示始终授予这一半。';
$string['minrelations'] = '最少关系数';
$string['minrelations_help'] = '仅在未设置参考图时使用。当图中包含至少这么多关系时，学员获得一半分数。零表示始终授予这一半。';
$string['noscript'] = '此题需要启用 JavaScript 才能构建图。';
$string['pleasedrawmap'] = '提交前请先构建你的图。';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'ViMi Pad 题目要求学员构建一个受所选图示配置约束的可视化知识图（概念图、思维导图、树等）。提交的图会依据作者的参考图自动评分；若未设置参考图，则依据最低结构要求评分。';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = '添加 ViMi Pad 题目';
$string['pluginnameediting'] = '编辑 ViMi Pad 题目';
$string['pluginnamesummary'] = '让学员构建可视化知识图作为答案，受图示配置约束并自动评分。由 ViMi Pad 活动（mod_vimipad）提供支持。';
$string['privacy:metadata'] = 'ViMi Pad 题型本身不存储任何个人数据。学员的图由 Moodle 题目引擎作为作答记录存储。';
$string['profile'] = '图示配置';
$string['profile_help'] = '学员的图所受约束的 ViMi Pad 图示配置，例如概念图、思维导图或树。该列表由 ViMi Pad 活动提供。';
$string['referencemap'] = '参考图';
$string['referencemap_help'] = '上传作者解答，作为导出为 JSON 的 ViMi Pad 图。设置后，学员的图将按其再现了多少参考节点和关系来评分。留空则改为按最少节点数和关系数评分。';
$string['referencemapincompatible'] = '参考图与所选配置和允许的形状不匹配。请上传匹配的参考图，或将配置改回。';
$string['referencemapinvalid'] = '上传的文件不是有效的 JSON。请上传导出为 JSON 的 ViMi Pad 图。';
$string['responsesummary'] = '包含 {$a->nodes} 个节点和 {$a->relations} 个关系的图';
$string['shape:ellipse'] = '椭圆';
$string['shape:rect'] = '矩形';
$string['shape:roundrect'] = '圆角矩形';
$string['shapesnotinprofile'] = '所选形状中有一个或多个不受所选图示配置支持。';
