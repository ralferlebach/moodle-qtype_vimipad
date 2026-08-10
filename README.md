# moodle-qtype_vimipad

ViMi Pad question type — lets learners build a visual knowledge map (concept map,
mind map, tree, semantic network and more) as their answer to a quiz question.
The submitted map is a frozen snapshot that is **graded automatically** against
an author-defined reference map, or against minimum structural requirements when
no reference is set.

This question type is a satellite of the ViMi Pad activity
([mod_vimipad](https://github.com/ralferlebach/moodle-mod_vimipad)). It reuses
the activity's public API (diagram profiles, stable id helpers, the embeddable
editor) and therefore declares a hard dependency on it.

## Status

**0.1.0 — alpha** (`MATURITY_ALPHA`). This is an early stub: the per-question
options, the automatic structural scorer and the manual-graded-response contract
are in place and covered by tests; the interactive editor embed (a ViMi Pad
`ServiceTransport` bound to the question attempt) replaces the plain-text
response area in a follow-up step.

## Requirements

This plugin requires Moodle 4.5+ and the ViMi Pad activity `mod_vimipad`
(version 2026080800 / 0.9.0 or newer) to be installed. It is developed and
tested against Moodle 4.5, 5.0 and 5.2 on PHP 8.1–8.3.

## Motivation for this plugin

A visual knowledge map is a valuable thing to assess, but the quiz is where most
formal assessment in Moodle happens. ViMi Pad already models a map as an
immutable snapshot and knows how to score one; a question attempt is exactly the
same idea — a frozen answer graded after the fact. This question type brings the
two together, so a map can be one question among many in an ordinary quiz, graded
automatically alongside the rest.

## Installation

Install the plugin into

    /question/type/vimipad

See <http://docs.moodle.org/en/Installing_plugins> for details on installing
Moodle plugins. Install `mod_vimipad` first; the dependency is enforced.

## Usage & Settings

When authoring a ViMi Pad question you choose the diagram **profile** (the list
comes straight from the ViMi Pad activity), optionally restrict the allowed node
shapes, and set the grading basis: either a **reference map** or the minimum
node and relation counts. No site-level configuration is required.

## Bug and problem reports

This plugin is in beta-adjacent development alongside mod_vimipad. Please report
issues via the GitHub issue tracker of the
[mod_vimipad repository](https://github.com/ralferlebach/moodle-mod_vimipad).

## Moodle release support

This plugin is maintained for the current Moodle LTS (4.5) and the newest
supported major release, matching the support window of mod_vimipad.

## Copyright

Copyright © 2026 Ralf Erlebach. Licensed under the
[GNU GPL v3 or later](https://www.gnu.org/copyleft/gpl.html).
