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

namespace qtype_vimipad;

use qtype_vimipad\local\scorer;

/**
 * Unit tests for the ViMi Pad automatic structural scorer.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_vimipad\local\scorer
 */
final class scorer_test extends \advanced_testcase {
    /**
     * Build a serialised map from simple node labels and relation triples.
     *
     * @param string[] $nodes Node labels.
     * @param array $relations Source/label/target triples.
     * @return string JSON map.
     */
    private function map(array $nodes, array $relations = []): string {
        $n = [];
        $ids = [];
        foreach ($nodes as $i => $label) {
            $id = 'n' . $i;
            $ids[$label] = $id;
            $n[] = ['id' => $id, 'label' => $label];
        }
        $r = [];
        foreach ($relations as $rel) {
            [$source, $label, $target] = $rel;
            $r[] = [
                'source' => $ids[$source] ?? $source,
                'label' => $label,
                'target' => $ids[$target] ?? $target,
            ];
        }
        return json_encode(['nodes' => $n, 'relations' => $r]);
    }

    /**
     * An empty or malformed response scores zero in reference mode.
     *
     * @return void
     */
    public function test_empty_response_reference_mode(): void {
        $reference = $this->map(['Water', 'Ice'], [['Water', 'freezes to', 'Ice']]);
        $this->assertSame(0.0, scorer::score('', $reference, 0, 0));
        $this->assertSame(0.0, scorer::score('not json', $reference, 0, 0));
        $this->assertSame(0.0, scorer::score(null, $reference, 0, 0));
    }

    /**
     * A response identical to the reference scores a full mark.
     *
     * @return void
     */
    public function test_full_match_reference_mode(): void {
        $reference = $this->map(['Water', 'Ice'], [['Water', 'freezes to', 'Ice']]);
        $this->assertSame(1.0, scorer::score($reference, $reference, 0, 0));
    }

    /**
     * Partial recall against the reference yields a proportional fraction.
     *
     * Reference has 2 nodes + 1 relation = 3 elements; the response reproduces
     * both nodes but not the relation, so 2/3.
     *
     * @return void
     */
    public function test_partial_match_reference_mode(): void {
        $reference = $this->map(['Water', 'Ice'], [['Water', 'freezes to', 'Ice']]);
        $response = $this->map(['Water', 'Ice']);
        $this->assertEqualsWithDelta(2 / 3, scorer::score($response, $reference, 0, 0), 0.0001);
    }

    /**
     * Matching ignores case and surrounding whitespace.
     *
     * @return void
     */
    public function test_matching_is_case_and_whitespace_insensitive(): void {
        $reference = $this->map(['Water Cycle'], []);
        $response = $this->map(['  water   cycle '], []);
        $this->assertSame(1.0, scorer::score($response, $reference, 0, 0));
    }

    /**
     * Extra elements in the response do not reduce the recall-based score.
     *
     * @return void
     */
    public function test_extra_response_elements_do_not_penalise(): void {
        $reference = $this->map(['A'], []);
        $response = $this->map(['A', 'B', 'C'], [['A', 'x', 'B']]);
        $this->assertSame(1.0, scorer::score($response, $reference, 0, 0));
    }

    /**
     * Structural mode awards half per satisfied minimum.
     *
     * @return void
     */
    public function test_structural_mode_halves(): void {
        $response = $this->map(['A', 'B'], [['A', 'r', 'B']]);
        // Both minimums met -> full.
        $this->assertSame(1.0, scorer::score($response, '', 2, 1));
        // Node minimum met, relation minimum not -> half.
        $this->assertSame(0.5, scorer::score($response, '', 2, 5));
        // Neither met -> zero.
        $this->assertSame(0.0, scorer::score($response, '', 5, 5));
        // Zero minimums -> full for any complete map.
        $this->assertSame(1.0, scorer::score($response, '', 0, 0));
    }

    /**
     * Structural mode is used when the reference argument is null or empty.
     *
     * @return void
     */
    public function test_null_reference_falls_back_to_structural(): void {
        $response = $this->map(['A', 'B'], []);
        $this->assertSame(1.0, scorer::score($response, null, 2, 0));
        $this->assertSame(0.5, scorer::score($response, '', 2, 1));
    }

    /**
     * Normalisation de-duplicates and resolves relation endpoints to labels.
     *
     * @return void
     */
    public function test_normalise_resolves_ids_and_dedupes(): void {
        $json = json_encode([
            'nodes' => [
                ['id' => 'n1', 'label' => 'Alpha'],
                ['id' => 'n2', 'label' => 'Beta'],
                ['id' => 'n3', 'label' => 'Alpha'],
            ],
            'relations' => [
                ['source' => 'n1', 'label' => 'links', 'target' => 'n2'],
                ['source' => 'n1', 'label' => 'links', 'target' => 'n2'],
            ],
        ]);
        $normalised = scorer::normalise_map($json);
        $this->assertSame(['alpha', 'beta'], $normalised['nodes']);
        $this->assertCount(1, $normalised['relations']);
        $this->assertStringContainsString('alpha', $normalised['relations'][0]);
        $this->assertStringContainsString('beta', $normalised['relations'][0]);
    }
}
