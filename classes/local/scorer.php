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
 * Grading logic for ViMi Pad questions.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace qtype_vimipad\local;

/**
 * Deterministic, context-free grading for ViMi Pad questions.
 *
 * Reference grading is delegated to the mod_vimipad public scoring facade
 * ({@see \mod_vimipad\api\score}), so a question is graded by exactly the same
 * engine as the activity - no scorer is duplicated here. When the author has not
 * supplied a reference map, a question-type-specific structural-minimum score is
 * used instead: half the mark for meeting the minimum node count, half for the
 * minimum relation count.
 */
class scorer {
    /**
     * Grade a response map, returning a fraction in the range [0, 1].
     *
     * @param string|null $responsejson The learner's serialised map (snapshot JSON).
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
        if ($referencejson !== null && trim($referencejson) !== '') {
            $fraction = \mod_vimipad\api\score::fraction((string) $responsejson, $referencejson);
            return $fraction === null ? 0.0 : self::clamp((float) $fraction);
        }
        return self::score_structural((string) $responsejson, $minnodes, $minrelations);
    }

    /**
     * Structural-minimum fraction: half the mark for meeting the node minimum,
     * half for the relation minimum. A minimum of 0 is auto-satisfied.
     *
     * @param string $json The learner's serialised map.
     * @param int $minnodes Minimum node count.
     * @param int $minrelations Minimum relation count.
     * @return float
     */
    protected static function score_structural(string $json, int $minnodes, int $minrelations): float {
        $counts = self::counts($json);
        $nodesok = $counts['nodes'] >= max(0, $minnodes);
        $relationsok = $counts['relations'] >= max(0, $minrelations);
        return self::clamp(($nodesok ? 0.5 : 0.0) + ($relationsok ? 0.5 : 0.0));
    }

    /**
     * The number of nodes and relations in a serialised map.
     *
     * @param string|null $json The serialised map.
     * @return array Keys 'nodes' and 'relations' with integer counts.
     */
    public static function counts(?string $json): array {
        $decoded = json_decode((string) $json, true);
        $nodes = (is_array($decoded) && isset($decoded['nodes']) && is_array($decoded['nodes']))
            ? count($decoded['nodes']) : 0;
        $relations = (is_array($decoded) && isset($decoded['relations']) && is_array($decoded['relations']))
            ? count($decoded['relations']) : 0;
        return ['nodes' => $nodes, 'relations' => $relations];
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
