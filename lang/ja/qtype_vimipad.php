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
 * Japanese language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = '許可するノード形状';
$string['allowedshapes_help'] = '受講者が使用できるノード形状をカンマ区切りで指定する任意の一覧です。空欄にすると、選択したダイアグラムプロファイルが許可するすべての形状を使用できます。';
$string['answer'] = 'あなたのマップ';
$string['grading'] = '自動採点';
$string['invalidmap'] = '送信されたマップは、この問題に対して有効な ViMi Pad マップではありません。';
$string['mapsettings'] = 'マップ設定';
$string['minnodes'] = '最小ノード数';
$string['minnodes_help'] = '参照マップが設定されていない場合にのみ使用されます。マップにこの数以上のノードが含まれると、受講者は配点の半分を獲得します。ゼロの場合、この半分は常に付与されます。';
$string['minrelations'] = '最小リレーション数';
$string['minrelations_help'] = '参照マップが設定されていない場合にのみ使用されます。マップにこの数以上のリレーションが含まれると、受講者は配点の半分を獲得します。ゼロの場合、この半分は常に付与されます。';
$string['noscript'] = 'この問題でマップを作成するには JavaScript を有効にする必要があります。';
$string['pleasedrawmap'] = '送信する前にマップを作成してください。';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'ViMi Pad 問題は、選択したダイアグラムプロファイルに制限された視覚的な知識マップ（コンセプトマップ、マインドマップ、ツリーなど）を作成するよう受講者に求めます。送信されたマップは、作成者の参照マップに対して、または参照が設定されていない場合は最小構造要件に対して自動的に採点されます。';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'ViMi Pad 問題の追加';
$string['pluginnameediting'] = 'ViMi Pad 問題の編集';
$string['pluginnamesummary'] = '受講者が回答として、ダイアグラムプロファイルに制限され自動採点される視覚的な知識マップを作成できるようにします。ViMi Pad 活動（mod_vimipad）を利用しています。';
$string['privacy:metadata'] = 'ViMi Pad 問題タイプ自体は個人データを保存しません。受講者のマップは、受験の応答として Moodle の問題エンジンによって保存されます。';
$string['profile'] = 'ダイアグラムプロファイル';
$string['profile_help'] = '受講者のマップが制限される ViMi Pad ダイアグラムプロファイルです。たとえばコンセプトマップ、マインドマップ、ツリーなどです。一覧は ViMi Pad 活動から提供されます。';
$string['referencemap'] = '参照マップ';
$string['referencemap_help'] = '作成者の解答を JSON にエクスポートした ViMi Pad マップとしてアップロードします。設定すると、受講者のマップは参照のノードとリレーションをどれだけ再現しているかで採点されます。空欄にすると、代わりに最小ノード数とリレーション数で採点されます。';
$string['referencemapincompatible'] = '参照マップが選択したプロファイルと許可された形状に一致しません。一致する参照マップをアップロードするか、プロファイルを元に戻してください。';
$string['referencemapinvalid'] = 'アップロードされたファイルは有効な JSON ではありません。JSON にエクスポートした ViMi Pad マップをアップロードしてください。';
$string['responsesummary'] = '{$a->nodes} 個のノードと {$a->relations} 個のリレーションを含むマップ';
$string['shape:ellipse'] = '楕円';
$string['shape:rect'] = '四角形';
$string['shape:roundrect'] = '角丸四角形';
$string['shapesnotinprofile'] = '選択した形状のうち 1 つ以上が、選択したダイアグラムプロファイルでサポートされていません。';
