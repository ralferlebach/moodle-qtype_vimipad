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

/**
 * Privacy tests for the ViMi Pad question type.
 *
 * The plugin declares itself a null provider: the learner's map is stored by the
 * question engine, not by this plugin. Core reads get_reason() when it builds
 * the site's privacy registry, and a key that resolves to nothing renders a raw
 * [[placeholder]] on that page. The plugin had no privacy test at all.
 *
 * @package    qtype_vimipad
 * @copyright  2026 Ralf Erlebach
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \qtype_vimipad\privacy\provider
 */
final class privacy_provider_test extends \advanced_testcase {
    /**
     * The provider implements the null provider contract.
     *
     * @return void
     */
    public function test_is_a_null_provider(): void {
        $this->resetAfterTest();

        $this->assertTrue(
            is_subclass_of(
                \qtype_vimipad\privacy\provider::class,
                \core_privacy\local\metadata\null_provider::class
            ),
            'The question type stores no data of its own and must say so explicitly.'
        );
    }

    /**
     * The reason string exists, so the privacy registry renders properly.
     *
     * @return void
     */
    public function test_reason_string_exists(): void {
        $this->resetAfterTest();

        $reason = \qtype_vimipad\privacy\provider::get_reason();
        $this->assertTrue(
            get_string_manager()->string_exists($reason, 'qtype_vimipad'),
            "get_reason() points at '{$reason}', which qtype_vimipad does not define."
        );
        $this->assertNotEmpty(get_string($reason, 'qtype_vimipad'));
    }
}
