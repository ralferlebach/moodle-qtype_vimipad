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
 * Dutch language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Toegestane knoopvormen';
$string['allowedshapes_help'] = 'Een optionele door komma\'s gescheiden lijst van knoopvormen die de deelnemer mag gebruiken. Laat leeg om elke vorm toe te staan die het gekozen diagramprofiel toelaat.';
$string['answer'] = 'Jouw kaart';
$string['grading'] = 'Automatische beoordeling';
$string['invalidmap'] = 'De ingediende kaart is geen geldige ViMi Pad-kaart voor deze vraag.';
$string['mapsettings'] = 'Kaartinstellingen';
$string['minnodes'] = 'Minimum aantal knopen';
$string['minnodes_help'] = 'Alleen gebruikt wanneer geen referentiekaart is ingesteld. De deelnemer verdient de helft van de punten zodra de kaart minstens dit aantal knopen bevat. Nul betekent dat deze helft altijd wordt toegekend.';
$string['minrelations'] = 'Minimum aantal relaties';
$string['minrelations_help'] = 'Alleen gebruikt wanneer geen referentiekaart is ingesteld. De deelnemer verdient de helft van de punten zodra de kaart minstens dit aantal relaties bevat. Nul betekent dat deze helft altijd wordt toegekend.';
$string['noscript'] = 'Deze vraag heeft JavaScript nodig om de kaart te bouwen.';
$string['pleasedrawmap'] = 'Bouw je kaart voordat je indient.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'Een ViMi Pad-vraag vraagt de deelnemer een visuele kennismap te bouwen (conceptmap, mindmap, boom en meer), beperkt tot een gekozen diagramprofiel. De ingediende kaart wordt automatisch beoordeeld op basis van de referentiekaart van de auteur, of op basis van minimale structurele vereisten als er geen referentie is ingesteld.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'Een ViMi Pad-vraag toevoegen';
$string['pluginnameediting'] = 'Een ViMi Pad-vraag bewerken';
$string['pluginnamesummary'] = 'Laat deelnemers een visuele kennismap als antwoord bouwen, beperkt tot een diagramprofiel en automatisch beoordeeld. Mogelijk gemaakt door de ViMi Pad-activiteit (mod_vimipad).';
$string['privacy:metadata'] = 'Het ViMi Pad-vraagtype slaat zelf geen persoonsgegevens op. De kaart van de deelnemer wordt door de Moodle-vraagengine opgeslagen als het pogingantwoord.';
$string['profile'] = 'Diagramprofiel';
$string['profile_help'] = 'Het ViMi Pad-diagramprofiel waartoe de kaart van de deelnemer is beperkt, bijvoorbeeld conceptmap, mindmap of boom. De lijst wordt geleverd door de ViMi Pad-activiteit.';
$string['referencemap'] = 'Referentiekaart';
$string['referencemap_help'] = 'Upload een auteursoplossing als een naar JSON geexporteerde ViMi Pad-kaart. Indien ingesteld, wordt de kaart van de deelnemer beoordeeld op hoeveel van de referentieknopen en -relaties deze reproduceert. Laat leeg om in plaats daarvan te beoordelen op het minimum aantal knopen en relaties.';
$string['referencemapincompatible'] = 'De referentiekaart komt niet overeen met het gekozen profiel en de toegestane vormen. Upload een passende referentiekaart of zet het profiel terug.';
$string['referencemapinvalid'] = 'Het geuploade bestand is geen geldige JSON. Upload een ViMi Pad-kaart die als JSON is geexporteerd.';
$string['responsesummary'] = 'Kaart met {$a->nodes} knoop(en) en {$a->relations} relatie(s)';
$string['shape:ellipse'] = 'Ellips';
$string['shape:rect'] = 'Rechthoek';
$string['shape:roundrect'] = 'Afgeronde rechthoek';
$string['shapesnotinprofile'] = 'Een of meer geselecteerde vormen worden niet ondersteund door het gekozen diagramprofiel.';
