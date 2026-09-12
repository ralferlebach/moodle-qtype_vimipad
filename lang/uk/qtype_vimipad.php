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
 * Ukrainian language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Дозволені форми вузлів';
$string['allowedshapes_help'] = 'Необов’язковий список форм вузлів через кому, які може використовувати студент. Залиште порожнім, щоб дозволити всі форми, які допускає вибраний профіль діаграми.';
$string['answer'] = 'Ваша карта';
$string['grading'] = 'Автоматичне оцінювання';
$string['invalidmap'] = 'Надіслана карта не є дійсною картою ViMi Pad для цього запитання.';
$string['mapsettings'] = 'Налаштування карти';
$string['minnodes'] = 'Мінімальна кількість вузлів';
$string['minnodes_help'] = 'Використовується лише коли не задано еталонну карту. Студент отримує половину оцінки, коли карта містить принаймні цю кількість вузлів. Нуль означає, що ця половина нараховується завжди.';
$string['minrelations'] = 'Мінімальна кількість зв’язків';
$string['minrelations_help'] = 'Використовується лише коли не задано еталонну карту. Студент отримує половину оцінки, коли карта містить принаймні цю кількість зв’язків. Нуль означає, що ця половина нараховується завжди.';
$string['noscript'] = 'Для побудови карти в цьому запитанні потрібно ввімкнути JavaScript.';
$string['pleasedrawmap'] = 'Будь ласка, побудуйте карту перед надсиланням.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'Запитання ViMi Pad просить студента побудувати візуальну карту знань (концептуальна карта, ментальна карта, дерево тощо), обмежену вибраним профілем діаграми. Надіслана карта оцінюється автоматично щодо еталонної карти автора або за мінімальними структурними вимогами, коли еталон не задано.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'Додавання запитання ViMi Pad';
$string['pluginnameediting'] = 'Редагування запитання ViMi Pad';
$string['pluginnamesummary'] = 'Дає змогу студентам будувати візуальну карту знань як відповідь, обмежену профілем діаграми та оцінювану автоматично. Працює на основі діяльності ViMi Pad (mod_vimipad).';
$string['privacy:metadata'] = 'Тип запитання ViMi Pad не зберігає власних персональних даних. Карта студента зберігається рушієм запитань Moodle як відповідь спроби.';
$string['profile'] = 'Профіль діаграми';
$string['profile_help'] = 'Профіль діаграми ViMi Pad, яким обмежена карта студента, наприклад концептуальна карта, ментальна карта або дерево. Список надає діяльність ViMi Pad.';
$string['referencemap'] = 'Еталонна карта';
$string['referencemap_help'] = 'Завантажте авторський розв’язок як карту ViMi Pad, експортовану у JSON. Коли її задано, карта студента оцінюється за тим, скільки вузлів і зв’язків еталона вона відтворює. Залиште порожнім, щоб натомість оцінювати за мінімальною кількістю вузлів і зв’язків.';
$string['referencemapincompatible'] = 'Еталонна карта не відповідає вибраному профілю та дозволеним формам. Завантажте відповідну еталонну карту або поверніть профіль.';
$string['referencemapinvalid'] = 'Завантажений файл не є дійсним JSON. Будь ласка, завантажте карту ViMi Pad, експортовану як JSON.';
$string['responsesummary'] = 'Карта з {$a->nodes} вузол(ами) та {$a->relations} зв’язк(ами)';
$string['shape:ellipse'] = 'Еліпс';
$string['shape:rect'] = 'Прямокутник';
$string['shape:roundrect'] = 'Заокруглений прямокутник';
$string['shapesnotinprofile'] = 'Одна або кілька вибраних форм не підтримуються вибраним профілем діаграми.';
