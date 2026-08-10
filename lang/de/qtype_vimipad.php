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
 * German language strings for qtype_vimipad.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Erlaubte Knotenformen';
$string['allowedshapes_help'] = 'Eine optionale, kommagetrennte Liste von Knotenformen, die die Lernenden verwenden dürfen. Leer lassen, um alle vom gewählten Diagrammprofil erlaubten Formen zuzulassen.';
$string['answer'] = 'Deine Map';
$string['grading'] = 'Automatische Bewertung';
$string['mapsettings'] = 'Map-Einstellungen';
$string['minnodes'] = 'Mindestanzahl Knoten';
$string['minnodes_help'] = 'Wird nur verwendet, wenn keine Musterlösung hinterlegt ist. Die Lernenden erhalten die Hälfte der Punkte, sobald ihre Map mindestens so viele Knoten enthaelt. Null bedeutet, dass diese Hälfte immer vergeben wird.';
$string['minrelations'] = 'Mindestanzahl Relationen';
$string['minrelations_help'] = 'Wird nur verwendet, wenn keine Musterlösung hinterlegt ist. Die Lernenden erhalten die Hälfte der Punkte, sobald ihre Map mindestens so viele Relationen enthaelt. Null bedeutet, dass diese Hälfte immer vergeben wird.';
$string['pleasedrawmap'] = 'Bitte erstelle deine Map, bevor du sie abgibst.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'Eine ViMi-Pad-Frage fordert die Lernenden auf, eine visuelle Wissensmap (Concept Map, Mindmap, Baum und mehr) innerhalb eines gewählten Diagrammprofils zu erstellen. Die abgegebene Map wird automatisch gegen die Musterlösung der Autorin bzw. des Autors bewertet oder, wenn keine hinterlegt ist, gegen strukturelle Mindestanforderungen.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'ViMi-Pad-Frage hinzufügen';
$string['pluginnameediting'] = 'ViMi-Pad-Frage bearbeiten';
$string['pluginnamesummary'] = 'Lässt Lernende eine visuelle Wissensmap als Antwort erstellen, eingeschränkt auf ein Diagrammprofil und automatisch bewertet. Basiert auf der ViMi-Pad-Aktivität (mod_vimipad).';
$string['privacy:metadata'] = 'Der Fragetyp ViMi Pad speichert selbst keine personenbezogenen Daten. Die Map der Lernenden wird von der Moodle-Frage-Engine als Versuchsantwort gespeichert.';
$string['profile'] = 'Diagrammprofil';
$string['profile_help'] = 'Das ViMi-Pad-Diagrammprofil, auf das die Map der Lernenden eingeschränkt wird, zum Beispiel Concept Map, Mindmap oder Baum. Die Liste stammt aus der ViMi-Pad-Aktivität.';
$string['referencemap'] = 'Musterlösung (Map)';
$string['referencemap_help'] = 'Eine optionale Musterlösung als serialisierte ViMi-Pad-Map (JSON). Wenn hinterlegt, wird die Map der Lernenden danach bewertet, wie viele der Referenzknoten und -relationen sie reproduziert. Leer lassen, um stattdessen gegen die Mindestanzahl an Knoten und Relationen zu bewerten.';
$string['responsesummary'] = 'Map mit {$a->nodes} Knoten und {$a->relations} Relation(en)';
$string['stubhint'] = 'Frühe Vorschau: Serialisierte Map hier einfügen oder eingeben. Der interaktive ViMi-Pad-Editor ersetzt dieses Feld.';
