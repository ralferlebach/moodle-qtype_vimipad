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
 * Self-contained structural scorer for ViMi Pad questions.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace qtype_vimipad\local;

/**
 * A small, deterministic, context-free scorer for the automatic grading of
 * ViMi Pad questions.
 *
 * This is a first-stub scorer that lives inside the question type on purpose:
 * mod_vimipad's real scorers (the vimipadassess subplugins) are internal and
 * are NOT part of its stable public API, so a satellite plugin may not call
 * them. The intended long-term design is a public scoring facade on mod_vimipad
 * that the question type delegates to, so that the activity and the question
 * type score identically instead of maintaining two scorers. Until that facade
 * exists, this class provides an honest, testable placeholder.
 *
 * Two grading modes, chosen automatically:
 *   - Reference mode: if the author stored a reference map, the fraction is the
 *     recall of reference elements (nodes matched by normalised label, relations
 *     matched by normalised source/label/target triple) found in the response.
 *   - Structural-minimum mode: otherwise, the fraction rewards meeting the
 *     configured minimum node and relation counts (each half of the mark).
 */
class scorer {
    /**
     * Grade a response map, returning a fraction in the range [0, 1].
     *
     * @param string|null $responsejson The learner's serialised map.
     * @param string|null $referencejson The author's reference map, or null/empty for structural mode.
     * @param int $minnodes Minimum number of nodes expected (structural mode).
     * @param int $minrelations Minimum number of relations expected (structural mode).
     * @return float Fraction of the full mark, clamped to [0, 1].
     */
    public static function score(
        ?string $responsejson,
        ?string $referencejson,
        int $minnodes,
        int $minrelations
    ): float {
        $response = self::normalise_map($responsejson);

        $reference = self::normalise_map($referencejson);
        $hasreference = !empty($reference['nodes']) || !empty($reference['relations']);

        if ($hasreference) {
            return self::score_against_reference($response, $reference);
        }
        return self::score_structural($response, $minnodes, $minrelations);
    }

    /**
     * Recall-based fraction against a reference map.
     *
     * @param array $response Normalised response map.
     * @param array $reference Normalised reference map.
     * @return float
     */
    protected static function score_against_reference(array $response, array $reference): float {
        $refnodes = $reference['nodes'];
        $refrelations = $reference['relations'];
        $total = count($refnodes) + count($refrelations);
        if ($total === 0) {
            return 0.0;
        }

        $responsenodes = array_flip($response['nodes']);
        $responserelations = array_flip($response['relations']);

        $matched = 0;
        foreach ($refnodes as $label) {
            if (isset($responsenodes[$label])) {
                $matched++;
            }
        }
        foreach ($refrelations as $triple) {
            if (isset($responserelations[$triple])) {
                $matched++;
            }
        }

        return self::clamp($matched / $total);
    }

    /**
     * Structural-minimum fraction: half the mark for meeting the node minimum,
     * half for meeting the relation minimum. A minimum of 0 is auto-satisfied.
     *
     * @param array $response Normalised response map.
     * @param int $minnodes Minimum node count.
     * @param int $minrelations Minimum relation count.
     * @return float
     */
    protected static function score_structural(array $response, int $minnodes, int $minrelations): float {
        $nodesok = count($response['nodes']) >= max(0, $minnodes);
        $relationsok = count($response['relations']) >= max(0, $minrelations);
        return self::clamp(($nodesok ? 0.5 : 0.0) + ($relationsok ? 0.5 : 0.0));
    }

    /**
     * Normalise a serialised map into de-duplicated node labels and relation triples.
     *
     * Accepts the common serialisation shapes: nodes carry a `label` or `text`;
     * relations carry `source`/`target` (or `from`/`to`) plus an optional `label`.
     * Relation endpoints are resolved to node labels when the endpoint is a node
     * id, and otherwise used verbatim.
     *
     * @param string|null $json The serialised map.
     * @return array Sorted, unique labels and triples.
     */
    public static function normalise_map(?string $json): array {
        $empty = ['nodes' => [], 'relations' => []];
        if ($json === null || trim($json) === '') {
            return $empty;
        }
        $decoded = json_decode($json, true);
        if (!is_array($decoded)) {
            return $empty;
        }

        $rawnodes = isset($decoded['nodes']) && is_array($decoded['nodes']) ? $decoded['nodes'] : [];
        $rawrelations = isset($decoded['relations']) && is_array($decoded['relations'])
            ? $decoded['relations'] : [];

        $idtolabel = [];
        $nodelabels = [];
        foreach ($rawnodes as $node) {
            if (!is_array($node)) {
                continue;
            }
            $label = self::text_of($node);
            if ($label === '') {
                continue;
            }
            $nodelabels[] = $label;
            if (isset($node['id'])) {
                $idtolabel[(string)$node['id']] = $label;
            }
        }

        $relationtriples = [];
        foreach ($rawrelations as $relation) {
            if (!is_array($relation)) {
                continue;
            }
            $source = self::endpoint_of($relation, ['source', 'from', 'subject'], $idtolabel);
            $target = self::endpoint_of($relation, ['target', 'to', 'object'], $idtolabel);
            if ($source === '' && $target === '') {
                continue;
            }
            $label = self::text_of($relation);
            $relationtriples[] = $source . "\x1f" . $label . "\x1f" . $target;
        }

        $nodelabels = array_values(array_unique($nodelabels));
        $relationtriples = array_values(array_unique($relationtriples));
        sort($nodelabels, SORT_STRING);
        sort($relationtriples, SORT_STRING);

        return ['nodes' => $nodelabels, 'relations' => $relationtriples];
    }

    /**
     * Extract and normalise the textual label from a node or relation record.
     *
     * @param array $record Node or relation array.
     * @return string Lower-cased, whitespace-collapsed label (may be empty).
     */
    protected static function text_of(array $record): string {
        foreach (['label', 'text', 'title', 'name'] as $key) {
            if (isset($record[$key]) && is_string($record[$key]) && trim($record[$key]) !== '') {
                return self::normalise_text($record[$key]);
            }
        }
        return '';
    }

    /**
     * Resolve a relation endpoint to a normalised node label or verbatim value.
     *
     * @param array $relation The relation record.
     * @param string[] $keys Candidate endpoint keys in priority order.
     * @param array $idtolabel Map of node id => normalised label.
     * @return string
     */
    protected static function endpoint_of(array $relation, array $keys, array $idtolabel): string {
        foreach ($keys as $key) {
            if (!isset($relation[$key])) {
                continue;
            }
            $value = (string)$relation[$key];
            if ($value === '') {
                continue;
            }
            if (isset($idtolabel[$value])) {
                return $idtolabel[$value];
            }
            return self::normalise_text($value);
        }
        return '';
    }

    /**
     * Lower-case and collapse whitespace so trivial formatting differences match.
     *
     * @param string $value Raw text.
     * @return string
     */
    protected static function normalise_text(string $value): string {
        $value = trim(\core_text::strtolower($value));
        return (string)preg_replace('/\s+/u', ' ', $value);
    }

    /**
     * Clamp a fraction into the range [0, 1].
     *
     * @param float $fraction Raw fraction.
     * @return float
     */
    protected static function clamp(float $fraction): float {
        return max(0.0, min(1.0, $fraction));
    }
}
