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
 * Danish language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Tilladte knudeformer';
$string['allowedshapes_help'] = 'En valgfri kommasepareret liste over knudeformer, som den studerende må bruge. Lad feltet være tomt for at tillade alle former, som den valgte diagramprofil tillader.';
$string['answer'] = 'Dit kort';
$string['grading'] = 'Automatisk bedømmelse';
$string['invalidmap'] = 'Det indsendte kort er ikke et gyldigt ViMi Pad-kort til dette spørgsmål.';
$string['mapsettings'] = 'Kortindstillinger';
$string['minnodes'] = 'Mindste antal knuder';
$string['minnodes_help'] = 'Bruges kun, når der ikke er angivet et referencekort. Den studerende opnår halvdelen af karakteren, når kortet indeholder mindst dette antal knuder. Nul betyder, at denne halvdel altid tildeles.';
$string['minrelations'] = 'Mindste antal relationer';
$string['minrelations_help'] = 'Bruges kun, når der ikke er angivet et referencekort. Den studerende opnår halvdelen af karakteren, når kortet indeholder mindst dette antal relationer. Nul betyder, at denne halvdel altid tildeles.';
$string['noscript'] = 'Dette spørgsmål kræver, at JavaScript er aktiveret for at bygge kortet.';
$string['pleasedrawmap'] = 'Byg venligst dit kort, før du indsender.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'Et ViMi Pad-spørgsmål beder den studerende om at bygge et visuelt videnskort (begrebskort, mindmap, træ med mere), begrænset til en valgt diagramprofil. Det indsendte kort bedømmes automatisk i forhold til forfatterens referencekort eller i forhold til minimumskrav til strukturen, når der ikke er angivet en reference.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'Tilføjelse af et ViMi Pad-spørgsmål';
$string['pluginnameediting'] = 'Redigering af et ViMi Pad-spørgsmål';
$string['pluginnamesummary'] = 'Lader studerende bygge et visuelt videnskort som svar, begrænset til en diagramprofil og bedømt automatisk. Drevet af ViMi Pad-aktiviteten (mod_vimipad).';
$string['privacy:metadata'] = 'ViMi Pad-spørgsmålstypen gemmer ikke selv nogen personoplysninger. Den studerendes kort gemmes af Moodles spørgsmålsmotor som forsøgsbesvarelsen.';
$string['profile'] = 'Diagramprofil';
$string['profile_help'] = 'Den ViMi Pad-diagramprofil, som den studerendes kort er begrænset til, for eksempel begrebskort, mindmap eller træ. Listen leveres af ViMi Pad-aktiviteten.';
$string['referencemap'] = 'Referencekort';
$string['referencemap_help'] = 'Upload en forfatterløsning som et ViMi Pad-kort eksporteret til JSON. Når det er angivet, bedømmes den studerendes kort efter, hvor mange af referencens knuder og relationer det gengiver. Lad feltet være tomt for i stedet at bedømme efter minimumsantallet af knuder og relationer.';
$string['referencemapincompatible'] = 'Referencekortet passer ikke til den valgte profil og de tilladte former. Upload et referencekort, der passer, eller skift profilen tilbage.';
$string['referencemapinvalid'] = 'Den uploadede fil er ikke gyldig JSON. Upload venligst et ViMi Pad-kort eksporteret som JSON.';
$string['responsesummary'] = 'Kort med {$a->nodes} knude(r) og {$a->relations} relation(er)';
$string['shape:ellipse'] = 'Ellipse';
$string['shape:rect'] = 'Rektangel';
$string['shape:roundrect'] = 'Afrundet rektangel';
$string['shapesnotinprofile'] = 'En eller flere valgte former understøttes ikke af den valgte diagramprofil.';
