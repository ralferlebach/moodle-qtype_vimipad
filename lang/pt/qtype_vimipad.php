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
 * Portuguese language strings for qtype_vimipad.
 *
 * Machine-drafted starter translation for functional and RTL/CJK testing.
 * Not a certified translation; refine via AMOS. English is the source of truth.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['allowedshapes'] = 'Formas de nó permitidas';
$string['allowedshapes_help'] = 'Uma lista opcional, separada por vírgulas, das formas de nó que o estudante pode usar. Deixe vazio para permitir todas as formas que o perfil de diagrama escolhido permitir.';
$string['answer'] = 'O seu mapa';
$string['grading'] = 'Avaliação automática';
$string['invalidmap'] = 'O mapa enviado não é um mapa ViMi Pad válido para esta pergunta.';
$string['mapsettings'] = 'Definições do mapa';
$string['minnodes'] = 'Número mínimo de nós';
$string['minnodes_help'] = 'Usado apenas quando não está definido um mapa de referência. O estudante obtém metade da nota quando o mapa contém pelo menos este número de nós. Zero significa que esta metade é sempre atribuída.';
$string['minrelations'] = 'Número mínimo de relações';
$string['minrelations_help'] = 'Usado apenas quando não está definido um mapa de referência. O estudante obtém metade da nota quando o mapa contém pelo menos este número de relações. Zero significa que esta metade é sempre atribuída.';
$string['noscript'] = 'Esta pergunta precisa de JavaScript ativado para construir o mapa.';
$string['pleasedrawmap'] = 'Construa o seu mapa antes de submeter.';
$string['pluginname'] = 'ViMi Pad';
$string['pluginname_help'] = 'Uma pergunta ViMi Pad pede ao estudante que construa um mapa visual de conhecimento (mapa conceptual, mapa mental, árvore e mais) limitado a um perfil de diagrama escolhido. O mapa enviado é avaliado automaticamente em relação ao mapa de referência do autor, ou em relação a requisitos estruturais mínimos quando não há referência definida.';
$string['pluginname_link'] = 'question/type/vimipad';
$string['pluginnameadding'] = 'Adicionar uma pergunta ViMi Pad';
$string['pluginnameediting'] = 'Editar uma pergunta ViMi Pad';
$string['pluginnamesummary'] = 'Permite aos estudantes construir um mapa visual de conhecimento como resposta, limitado a um perfil de diagrama e avaliado automaticamente. Desenvolvido pela atividade ViMi Pad (mod_vimipad).';
$string['privacy:metadata'] = 'O tipo de pergunta ViMi Pad não armazena dados pessoais próprios. O mapa do estudante é armazenado pelo motor de perguntas do Moodle como a resposta da tentativa.';
$string['profile'] = 'Perfil de diagrama';
$string['profile_help'] = 'O perfil de diagrama ViMi Pad a que o mapa do estudante está limitado, por exemplo mapa conceptual, mapa mental ou árvore. A lista é fornecida pela atividade ViMi Pad.';
$string['referencemap'] = 'Mapa de referência';
$string['referencemap_help'] = 'Carregue uma solução do autor como um mapa ViMi Pad exportado para JSON. Quando definido, o mapa do estudante é pontuado consoante quantos nós e relações de referência reproduz. Deixe vazio para avaliar antes pelo número mínimo de nós e relações.';
$string['referencemapincompatible'] = 'O mapa de referência não corresponde ao perfil escolhido nem às formas permitidas. Carregue um mapa de referência compatível ou reponha o perfil.';
$string['referencemapinvalid'] = 'O ficheiro carregado não é JSON válido. Carregue um mapa ViMi Pad exportado como JSON.';
$string['responsesummary'] = 'Mapa com {$a->nodes} nó(s) e {$a->relations} relação(ões)';
$string['shape:ellipse'] = 'Elipse';
$string['shape:rect'] = 'Retângulo';
$string['shape:roundrect'] = 'Retângulo arredondado';
$string['shapesnotinprofile'] = 'Uma ou mais formas selecionadas não são suportadas pelo perfil de diagrama escolhido.';
