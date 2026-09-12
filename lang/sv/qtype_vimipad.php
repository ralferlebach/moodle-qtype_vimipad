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
 * Swedish language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Tillåtna nodformer';
$string['allowedshapes_help'] = 'En valfri kommaseparerad lista över nodformer som deltagaren får använda. Lämna tomt för att tillåta alla former som den valda diagramprofilen tillåter.';
$string['answer'] = 'Din karta';
$string['grading'] = 'Automatisk bedömning';
$string['invalidmap'] = 'Den inskickade kartan är inte en giltig ViMi Pad-karta för denna fråga.';
$string['mapsettings'] = 'Kartinställningar';
$string['minnodes'] = 'Minsta antal noder';
$string['minnodes_help'] = 'Används endast när ingen referenskarta är angiven. Deltagaren får hälften av poängen när kartan innehåller minst detta antal noder. Noll innebär att denna hälft alltid tilldelas.';
$string['minrelations'] = 'Minsta antal relationer';
$string['minrelations_help'] = 'Används endast när ingen referenskarta är angiven. Deltagaren får hälften av poängen när kartan innehåller minst detta antal relationer. Noll innebär att denna hälft alltid tilldelas.';
$string['noscript'] = 'Den här frågan kräver att JavaScript är aktiverat för att bygga kartan.';
$string['pleasedrawmap'] = 'Bygg din karta innan du skickar in.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'En ViMi Pad-fråga ber deltagaren bygga en visuell kunskapskarta (begreppskarta, tankekarta, träd med mera), begränsad till en vald diagramprofil. Den inskickade kartan bedöms automatiskt mot författarens referenskarta, eller mot minimikrav på struktur när ingen referens är angiven.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'Lägga till en ViMi Pad-fråga';
$string['pluginnameediting'] = 'Redigera en ViMi Pad-fråga';
$string['pluginnamesummary'] = 'Låter deltagare bygga en visuell kunskapskarta som svar, begränsad till en diagramprofil och bedömd automatiskt. Drivs av ViMi Pad-aktiviteten (mod_vimipad).';
$string['privacy:metadata'] = 'ViMi Pad-frågetypen lagrar inga egna personuppgifter. Deltagarens karta lagras av Moodles frågemotor som försökssvaret.';
$string['profile'] = 'Diagramprofil';
$string['profile_help'] = 'Den ViMi Pad-diagramprofil som deltagarens karta är begränsad till, till exempel begreppskarta, tankekarta eller träd. Listan tillhandahålls av ViMi Pad-aktiviteten.';
$string['referencemap'] = 'Referenskarta';
$string['referencemap_help'] = 'Ladda upp en författarlösning som en ViMi Pad-karta exporterad till JSON. När den är angiven bedöms deltagarens karta efter hur många av referensens noder och relationer den återger. Lämna tomt för att i stället bedöma efter minsta antal noder och relationer.';
$string['referencemapincompatible'] = 'Referenskartan matchar inte den valda profilen och de tillåtna formerna. Ladda upp en referenskarta som gör det, eller ställ tillbaka profilen.';
$string['referencemapinvalid'] = 'Den uppladdade filen är inte giltig JSON. Ladda upp en ViMi Pad-karta exporterad som JSON.';
$string['responsesummary'] = 'Karta med {$a->nodes} nod(er) och {$a->relations} relation(er)';
$string['shape:ellipse'] = 'Ellips';
$string['shape:rect'] = 'Rektangel';
$string['shape:roundrect'] = 'Rundad rektangel';
$string['shapesnotinprofile'] = 'En eller flera valda former stöds inte av den valda diagramprofilen.';
