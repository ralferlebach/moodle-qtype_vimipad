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
 * Spanish language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Formas de nodo permitidas';
$string['allowedshapes_help'] = 'Una lista opcional, separada por comas, de las formas de nodo que el estudiante puede usar. Déjalo vacío para permitir todas las formas que permita el perfil de diagrama elegido.';
$string['answer'] = 'Tu mapa';
$string['grading'] = 'Calificación automática';
$string['invalidmap'] = 'El mapa enviado no es un mapa ViMi Pad válido para esta pregunta.';
$string['mapsettings'] = 'Configuración del mapa';
$string['minnodes'] = 'Número mínimo de nodos';
$string['minnodes_help'] = 'Se usa solo cuando no hay un mapa de referencia establecido. El estudiante obtiene la mitad de la calificación cuando su mapa contiene al menos este número de nodos. Cero significa que esta mitad siempre se otorga.';
$string['minrelations'] = 'Número mínimo de relaciones';
$string['minrelations_help'] = 'Se usa solo cuando no hay un mapa de referencia establecido. El estudiante obtiene la mitad de la calificación cuando su mapa contiene al menos este número de relaciones. Cero significa que esta mitad siempre se otorga.';
$string['noscript'] = 'Esta pregunta necesita JavaScript activado para construir el mapa.';
$string['pleasedrawmap'] = 'Construye tu mapa antes de enviar.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'Una pregunta ViMi Pad pide al estudiante construir un mapa visual de conocimiento (mapa conceptual, mapa mental, árbol y más) limitado a un perfil de diagrama elegido. El mapa enviado se califica automáticamente frente al mapa de referencia del autor, o frente a requisitos estructurales mínimos cuando no hay referencia establecida.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'Añadir una pregunta ViMi Pad';
$string['pluginnameediting'] = 'Editar una pregunta ViMi Pad';
$string['pluginnamesummary'] = 'Permite a los estudiantes construir un mapa visual de conocimiento como respuesta, limitado a un perfil de diagrama y calificado automáticamente. Con la tecnología de la actividad ViMi Pad (mod_vimipad).';
$string['privacy:metadata'] = 'El tipo de pregunta ViMi Pad no almacena datos personales propios. El mapa del estudiante lo almacena el motor de preguntas de Moodle como respuesta del intento.';
$string['profile'] = 'Perfil de diagrama';
$string['profile_help'] = 'El perfil de diagrama ViMi Pad al que se limita el mapa del estudiante, por ejemplo mapa conceptual, mapa mental o árbol. La lista la proporciona la actividad ViMi Pad.';
$string['referencemap'] = 'Mapa de referencia';
$string['referencemap_help'] = 'Sube una solución del autor como un mapa ViMi Pad exportado a JSON. Cuando se establece, el mapa del estudiante se puntúa según cuántos nodos y relaciones de referencia reproduce. Déjalo vacío para calificar en su lugar según el número mínimo de nodos y relaciones.';
$string['referencemapincompatible'] = 'El mapa de referencia no coincide con el perfil elegido ni con las formas permitidas. Sube un mapa de referencia que coincida o vuelve a cambiar el perfil.';
$string['referencemapinvalid'] = 'El archivo subido no es JSON válido. Sube un mapa ViMi Pad exportado como JSON.';
$string['responsesummary'] = 'Mapa con {$a->nodes} nodo(s) y {$a->relations} relación(es)';
$string['shape:ellipse'] = 'Elipse';
$string['shape:rect'] = 'Rectángulo';
$string['shape:roundrect'] = 'Rectángulo redondeado';
$string['shapesnotinprofile'] = 'Una o más formas seleccionadas no son compatibles con el perfil de diagrama elegido.';
