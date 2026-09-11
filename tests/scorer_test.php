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
 * Unit tests for the ViMi Pad question grading logic.
 *
 * Reference grading is delegated to the mod_vimipad public scoring facade, so
 * the reference-mode tests exercise the real activity scorer end to end.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_vimipad\local\scorer
 */
final class scorer_test extends \advanced_testcase {
    /**
     * Build a serialised snapshot map from concept labels and relation triples.
     *
     * @param array $concepts Concept labels.
     * @param array $relations Triples: each [sourcelabel, relationlabel, targetlabel].
     * @return string JSON snapshot.
     */
    private function map(array $concepts, array $relations = []): string {
        $ids = [];
        $nodes = [];
        foreach ($concepts as $i => $label) {
            $id = 'n' . $i;
            $ids[$label] = $id;
            $nodes[] = ['stableid' => $id, 'label' => $label];
        }
        $rels = [];
        foreach ($relations as $rel) {
            [$source, $label, $target] = $rel;
            $rels[] = [
                'sourceid' => $ids[$source] ?? $source,
                'targetid' => $ids[$target] ?? $target,
                'label' => $label,
            ];
        }
        return json_encode(['profile' => 'conceptmap', 'nodes' => $nodes, 'relations' => $rels]);
    }

    /**
     * Reference grading delegates to the facade: an identical map scores full.
     *
     * @return void
     */
    public function test_reference_full_match(): void {
        $this->resetAfterTest();
        $map = $this->map(['Water', 'Ice'], [['Water', 'freezes to', 'Ice']]);
        $this->assertEqualsWithDelta(1.0, scorer::score($map, $map, 0, 0), 0.0001);
    }

    /**
     * A weaker response scores below a perfect one, but above zero.
     *
     * @return void
     */
    public function test_reference_partial_match(): void {
        $this->resetAfterTest();
        $reference = $this->map(
            ['Water', 'Ice', 'Steam'],
            [['Water', 'freezes to', 'Ice'], ['Water', 'boils to', 'Steam']]
        );
        $weak = $this->map(['Water', 'Ice'], [['Water', 'freezes to', 'Ice']]);

        $partial = scorer::score($weak, $reference, 0, 0);
        $this->assertGreaterThan(0.0, $partial);
        $this->assertLessThan(1.0, $partial);
    }

    /**
     * An unusable response in reference mode scores zero, not an error.
     *
     * @return void
     */
    public function test_reference_invalid_response(): void {
        $this->resetAfterTest();
        $reference = $this->map(['Water', 'Ice']);
        $this->assertSame(0.0, scorer::score('not json', $reference, 0, 0));
    }

    /**
     * Structural mode awards half per satisfied minimum when no reference is set.
     *
     * @return void
     */
    public function test_structural_mode_halves(): void {
        $response = $this->map(['A', 'B'], [['A', 'r', 'B']]);
        $this->assertSame(1.0, scorer::score($response, '', 2, 1));
        $this->assertSame(0.5, scorer::score($response, '', 2, 5));
        $this->assertSame(0.0, scorer::score($response, '', 5, 5));
        $this->assertSame(1.0, scorer::score($response, '', 0, 0));
    }

    /**
     * A null or empty reference falls back to structural grading.
     *
     * @return void
     */
    public function test_null_reference_falls_back_to_structural(): void {
        $response = $this->map(['A', 'B'], []);
        $this->assertSame(1.0, scorer::score($response, null, 2, 0));
        $this->assertSame(0.5, scorer::score($response, '', 2, 1));
    }

    /**
     * counts() reports node and relation counts from the serialised map.
     *
     * @return void
     */
    public function test_counts(): void {
        $map = $this->map(['A', 'B', 'C'], [['A', 'r', 'B']]);
        $counts = scorer::counts($map);
        $this->assertSame(3, $counts['nodes']);
        $this->assertSame(1, $counts['relations']);

        $empty = scorer::counts('not json');
        $this->assertSame(0, $empty['nodes']);
        $this->assertSame(0, $empty['relations']);
    }
}
