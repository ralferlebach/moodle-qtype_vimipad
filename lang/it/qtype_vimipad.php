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
 * Italian language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Forme dei nodi consentite';
$string['allowedshapes_help'] = 'Un elenco facoltativo, separato da virgole, delle forme dei nodi che lo studente può usare. Lascia vuoto per consentire tutte le forme permesse dal profilo di diagramma scelto.';
$string['answer'] = 'La tua mappa';
$string['grading'] = 'Valutazione automatica';
$string['invalidmap'] = 'La mappa inviata non è una mappa ViMi Pad valida per questa domanda.';
$string['mapsettings'] = 'Impostazioni della mappa';
$string['minnodes'] = 'Numero minimo di nodi';
$string['minnodes_help'] = 'Usato solo quando non è impostata una mappa di riferimento. Lo studente ottiene metà del punteggio quando la mappa contiene almeno questo numero di nodi. Zero significa che questa metà viene sempre assegnata.';
$string['minrelations'] = 'Numero minimo di relazioni';
$string['minrelations_help'] = 'Usato solo quando non è impostata una mappa di riferimento. Lo studente ottiene metà del punteggio quando la mappa contiene almeno questo numero di relazioni. Zero significa che questa metà viene sempre assegnata.';
$string['noscript'] = 'Questa domanda richiede JavaScript abilitato per costruire la mappa.';
$string['pleasedrawmap'] = 'Costruisci la tua mappa prima di inviare.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'Una domanda ViMi Pad chiede allo studente di costruire una mappa visiva della conoscenza (mappa concettuale, mappa mentale, albero e altro) limitata a un profilo di diagramma scelto. La mappa inviata viene valutata automaticamente rispetto alla mappa di riferimento dell’autore, oppure in base a requisiti strutturali minimi quando non è impostato alcun riferimento.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'Aggiunta di una domanda ViMi Pad';
$string['pluginnameediting'] = 'Modifica di una domanda ViMi Pad';
$string['pluginnamesummary'] = 'Consente agli studenti di costruire una mappa visiva della conoscenza come risposta, limitata a un profilo di diagramma e valutata automaticamente. Basata sull’attività ViMi Pad (mod_vimipad).';
$string['privacy:metadata'] = 'Il tipo di domanda ViMi Pad non memorizza dati personali propri. La mappa dello studente è memorizzata dal motore delle domande di Moodle come risposta al tentativo.';
$string['profile'] = 'Profilo del diagramma';
$string['profile_help'] = 'Il profilo di diagramma ViMi Pad a cui è limitata la mappa dello studente, ad esempio mappa concettuale, mappa mentale o albero. L’elenco è fornito dall’attività ViMi Pad.';
$string['referencemap'] = 'Mappa di riferimento';
$string['referencemap_help'] = 'Carica una soluzione dell’autore come mappa ViMi Pad esportata in JSON. Quando è impostata, la mappa dello studente viene valutata in base a quanti nodi e relazioni di riferimento riproduce. Lascia vuoto per valutare invece in base al numero minimo di nodi e relazioni.';
$string['referencemapincompatible'] = 'La mappa di riferimento non corrisponde al profilo scelto e alle forme consentite. Carica una mappa di riferimento compatibile oppure ripristina il profilo.';
$string['referencemapinvalid'] = 'Il file caricato non è JSON valido. Carica una mappa ViMi Pad esportata in JSON.';
$string['responsesummary'] = 'Mappa con {$a->nodes} nodo/i e {$a->relations} relazione/i';
$string['shape:ellipse'] = 'Ellisse';
$string['shape:rect'] = 'Rettangolo';
$string['shape:roundrect'] = 'Rettangolo arrotondato';
$string['shapesnotinprofile'] = 'Una o più forme selezionate non sono supportate dal profilo di diagramma scelto.';
