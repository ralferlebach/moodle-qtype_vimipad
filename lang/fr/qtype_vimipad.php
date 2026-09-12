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
 * French language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Formes de nœud autorisées';
$string['allowedshapes_help'] = 'Liste facultative, séparée par des virgules, des formes de nœud que l’apprenant peut utiliser. Laissez vide pour autoriser toutes les formes permises par le profil de diagramme choisi.';
$string['answer'] = 'Votre carte';
$string['grading'] = 'Notation automatique';
$string['invalidmap'] = 'La carte soumise n’est pas une carte ViMi Pad valide pour cette question.';
$string['mapsettings'] = 'Paramètres de la carte';
$string['minnodes'] = 'Nombre minimal de nœuds';
$string['minnodes_help'] = 'Utilisé uniquement lorsqu’aucune carte de référence n’est définie. L’apprenant obtient la moitié de la note dès que sa carte contient au moins ce nombre de nœuds. Zéro signifie que cette moitié est toujours attribuée.';
$string['minrelations'] = 'Nombre minimal de relations';
$string['minrelations_help'] = 'Utilisé uniquement lorsqu’aucune carte de référence n’est définie. L’apprenant obtient la moitié de la note dès que sa carte contient au moins ce nombre de relations. Zéro signifie que cette moitié est toujours attribuée.';
$string['noscript'] = 'Cette question nécessite l’activation de JavaScript pour construire la carte.';
$string['pleasedrawmap'] = 'Veuillez construire votre carte avant de soumettre.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'Une question ViMi Pad demande à l’apprenant de construire une carte visuelle de connaissances (carte conceptuelle, carte mentale, arbre, etc.) limitée à un profil de diagramme choisi. La carte soumise est notée automatiquement par rapport à la carte de référence de l’auteur, ou selon des exigences structurelles minimales lorsqu’aucune référence n’est définie.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'Ajout d’une question ViMi Pad';
$string['pluginnameediting'] = 'Modification d’une question ViMi Pad';
$string['pluginnamesummary'] = 'Permet aux apprenants de construire une carte visuelle de connaissances comme réponse, limitée à un profil de diagramme et notée automatiquement. Propulsé par l’activité ViMi Pad (mod_vimipad).';
$string['privacy:metadata'] = 'Le type de question ViMi Pad ne stocke lui-même aucune donnée personnelle. La carte de l’apprenant est stockée par le moteur de questions de Moodle en tant que réponse à la tentative.';
$string['profile'] = 'Profil de diagramme';
$string['profile_help'] = 'Le profil de diagramme ViMi Pad auquel la carte de l’apprenant est limitée, par exemple carte conceptuelle, carte mentale ou arbre. La liste est fournie par l’activité ViMi Pad.';
$string['referencemap'] = 'Carte de référence';
$string['referencemap_help'] = 'Téléversez une solution de l’auteur sous forme de carte ViMi Pad exportée en JSON. Lorsqu’elle est définie, la carte de l’apprenant est notée selon le nombre de nœuds et de relations de référence qu’elle reproduit. Laissez vide pour noter plutôt selon les nombres minimaux de nœuds et de relations.';
$string['referencemapincompatible'] = 'La carte de référence ne correspond pas au profil choisi ni aux formes autorisées. Téléversez une carte de référence compatible ou rétablissez le profil.';
$string['referencemapinvalid'] = 'Le fichier téléversé n’est pas un JSON valide. Veuillez téléverser une carte ViMi Pad exportée en JSON.';
$string['responsesummary'] = 'Carte avec {$a->nodes} nœud(s) et {$a->relations} relation(s)';
$string['shape:ellipse'] = 'Ellipse';
$string['shape:rect'] = 'Rectangle';
$string['shape:roundrect'] = 'Rectangle arrondi';
$string['shapesnotinprofile'] = 'Une ou plusieurs formes sélectionnées ne sont pas prises en charge par le profil de diagramme choisi.';
