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
 * Norwegian Bokmal language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Tillatte nodeformer';
$string['allowedshapes_help'] = 'En valgfri kommaseparert liste over nodeformer som deltakeren kan bruke. La stå tom for å tillate alle former som den valgte diagramprofilen tillater.';
$string['answer'] = 'Kartet ditt';
$string['grading'] = 'Automatisk vurdering';
$string['invalidmap'] = 'Det innsendte kartet er ikke et gyldig ViMi Pad-kart for dette spørsmålet.';
$string['mapsettings'] = 'Kartinnstillinger';
$string['minnodes'] = 'Minste antall noder';
$string['minnodes_help'] = 'Brukes bare når det ikke er angitt et referansekart. Deltakeren får halvparten av poengsummen når kartet inneholder minst dette antallet noder. Null betyr at denne halvparten alltid gis.';
$string['minrelations'] = 'Minste antall relasjoner';
$string['minrelations_help'] = 'Brukes bare når det ikke er angitt et referansekart. Deltakeren får halvparten av poengsummen når kartet inneholder minst dette antallet relasjoner. Null betyr at denne halvparten alltid gis.';
$string['noscript'] = 'Dette spørsmålet krever at JavaScript er aktivert for å bygge kartet.';
$string['pleasedrawmap'] = 'Bygg kartet ditt før du sender inn.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'Et ViMi Pad-spørsmål ber deltakeren bygge et visuelt kunnskapskart (begrepskart, tankekart, tre med mer), begrenset til en valgt diagramprofil. Det innsendte kartet vurderes automatisk mot forfatterens referansekart, eller mot minstekrav til struktur når ingen referanse er angitt.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'Legge til et ViMi Pad-spørsmål';
$string['pluginnameediting'] = 'Redigere et ViMi Pad-spørsmål';
$string['pluginnamesummary'] = 'Lar deltakere bygge et visuelt kunnskapskart som svar, begrenset til en diagramprofil og vurdert automatisk. Drevet av ViMi Pad-aktiviteten (mod_vimipad).';
$string['privacy:metadata'] = 'ViMi Pad-spørsmålstypen lagrer ikke selv noen personopplysninger. Deltakerens kart lagres av Moodles spørsmålsmotor som forsøksbesvarelsen.';
$string['profile'] = 'Diagramprofil';
$string['profile_help'] = 'ViMi Pad-diagramprofilen som deltakerens kart er begrenset til, for eksempel begrepskart, tankekart eller tre. Listen leveres av ViMi Pad-aktiviteten.';
$string['referencemap'] = 'Referansekart';
$string['referencemap_help'] = 'Last opp en forfatterløsning som et ViMi Pad-kart eksportert til JSON. Når det er angitt, vurderes deltakerens kart etter hvor mange av referansens noder og relasjoner det gjengir. La stå tom for i stedet å vurdere etter minste antall noder og relasjoner.';
$string['referencemapincompatible'] = 'Referansekartet samsvarer ikke med den valgte profilen og de tillatte formene. Last opp et referansekart som passer, eller sett profilen tilbake.';
$string['referencemapinvalid'] = 'Den opplastede filen er ikke gyldig JSON. Last opp et ViMi Pad-kart eksportert som JSON.';
$string['responsesummary'] = 'Kart med {$a->nodes} node(r) og {$a->relations} relasjon(er)';
$string['shape:ellipse'] = 'Ellipse';
$string['shape:rect'] = 'Rektangel';
$string['shape:roundrect'] = 'Avrundet rektangel';
$string['shapesnotinprofile'] = 'En eller flere valgte former støttes ikke av den valgte diagramprofilen.';
