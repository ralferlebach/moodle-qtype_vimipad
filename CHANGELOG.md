# Changelog — qtype_vimipad

All notable changes to this plugin are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/) and the project uses plain
incremental release numbers.

## 0.2.6 - 2026-08-13

### Fixed
- The backup/restore test looked for the restored question in the course context.
  From Moodle 5.0 a question category can live in a question bank module inside
  the course, so the category context is no longer the course context and the
  test found nothing. It now matches the whole context subtree.
- The attempt scenario asserted the question's bank name, which an attempt page
  does not show; it now asserts the question text.

## 0.2.5 - 2026-08-12

### Fixed
- Added the missing CamelCaseNamespace exclusion to phpmd.xml.
- validation() delegates the reference check to reference_error(); the helper it
  was already calling had not actually been added, which would have been a fatal
  error the linters do not catch.

### Changed
- The AMD target can refresh the browserslist database with
  BROWSERSLIST_UPDATE=1 (off by default).

## 0.2.4 - 2026-08-12

### Fixed
- Allowed shapes were a free-text field carrying a vocabulary the editor does not
  use. They are now a multiselect built from the parent plugin's real shape set,
  validated against the chosen profile, so the browser and the server can no
  longer disagree about what the question permits.
- An existing reference map is revalidated when the profile or the shape
  restriction changes. Previously only a newly uploaded file was checked, so a
  teacher could switch the profile and leave a reference behind that learners'
  answers would be scored against despite being a different diagram type.
- Reference uploads are bounded before the file is read: the picker carries a
  maxbytes limit and the size is checked ahead of get_content(), since a draft
  area can be manipulated independently of the form.
- Removed the unused stubhint string left over from the preview version.

## 0.2.3 - 2026-08-12

### Changed
- Added phpmd.xml, a curated PHPMD ruleset; the plugin reports zero findings
  against it. Boolean web-service parameters and the vimipadform accessor naming
  are excluded with their reasons, since both are prescribed by published APIs.

## 0.2.2 - 2026-08-12

### Fixed
- The load seed pointed one directory too high when including config.php, so it
  could never bootstrap Moodle from question/type/vimipad/tests/load.
- The load targets in the makefile carried doubled line-continuation backslashes,
  which made the shell fail with "unexpected end of file".
- `make load-seed` now fails when the seed script fails, instead of reporting
  success and writing an empty .load-env.

## 0.2.1 - 2026-08-12

### Added
- Load-test harness (tests/load): seed, JMeter plan and k6 script, plus a README.
  This plugin exposes no web service, so the runs are session-based: they log in
  (handling Moodle one-time logintoken) and request the pages a learner actually
  meets. Not distributed (export-ignore), downloads and results gitignored.

## 0.2.0 - 2026-08-12

First beta. Maturity raised from ALPHA to BETA.

### Tests
- Boundary coverage for what a response may be: oversized, malformed, wrong
  profile, disallowed shape, unrestricted shapes, and shape-list parsing.
- Backup and restore roundtrip proving the reference map, profile and shape
  restriction survive a course backup into a new course.
- A behat scenario covering a real quiz attempt showing the embedded editor.
- The test helper now provides edit form data for the reference template, so
  generator-created questions can exercise the scored and constrained path.

## 0.1.7 - 2026-08-12

### Fixed
- Attempt responses are validated against the public ViMi Pad map policy before
  they are accepted or graded. A forged quiz POST could previously store any
  string that merely parsed as JSON, including documents the editor could never
  produce and that the scorer then partly ignored.
- Allowed node shapes are now actually applied: they constrain the embedded
  editor and are enforced server-side. The setting was stored, backed up and
  restored but never used, so the UI promised a restriction that did not exist.
- Reference map uploads are validated the same way rather than only being checked
  for parseable JSON.
- Corrected docblocks that still described the question as manually graded with a
  plain-text response area.

## 0.1.6 - 2026-08-10

### Added
- Behat scenarios (tests/behat/edit.feature): a generated ViMi Pad question
  appears in the course question bank, and a teacher can create one through the
  question form. Fills the previously empty behat CI job.

## 0.1.5 - 2026-08-10

### Fixed
- The embedded editor now receives the profile form config (via the new
  mod_vimipad 0.9.4 embed), so nodes and relations can actually be created and
  the arrange action no longer pushes new nodes off the canvas.
- The learner journal and the graphic export are hidden in the embedded editor
  (mod_vimipad embedded mode). The map is auto-captured on every edit; there is
  no separate submit/snapshot step.
- Dependency raised to mod_vimipad 2026080804 (0.9.4).

## 0.1.4 - 2026-08-10

### Added
- Question-engine walkthrough tests (deferred feedback): structural full/partial,
  reference full/partial and the empty-response (gaveup) path, driving a whole
  attempt lifecycle through the engine. Test helper gains 'structural' and
  'reference' question variants.

## 0.1.3 - 2026-08-10

### Changed
- The attempt response area now embeds the interactive ViMi Pad editor
  (mod_vimipad/editor_lazy mountValue) instead of a plain-text field. The map is
  a hidden value mirrored on every edit; submitted attempts render read-only.
  Editor language strings are preloaded from mod_vimipad, not duplicated here.
- Dependency raised to mod_vimipad 2026080802 (0.9.2), which provides the
  value-backed editor embed.

## 0.1.2 - 2026-08-10

### Changed
- Reference grading is now delegated to the mod_vimipad public scoring facade
  (`\mod_vimipad\api\score`) instead of a scorer local to this plugin, so a
  question is graded by exactly the same engine as the ViMi Pad activity. The
  question-type-specific structural-minimum grading (used when no reference map
  is set) stays local.
- Dependency raised to mod_vimipad 2026080801 (0.9.1), which introduces the
  scoring facade.

## 0.1.1 - 2026-08-10

### Changed
- Question-type icon redrawn as a neutral monochrome glyph so it matches the
  other icons in the question-type chooser.
- The reference map (Musterloesung) is now provided by uploading a ViMi Pad JSON
  export instead of pasting into a free-text field. Invalid JSON is rejected in
  the editing form; an existing reference map is preserved when a question is
  edited without uploading a new file.

## 0.1.0 — 2026-08-10

First public stub of the ViMi Pad question type.

### Added
- Question type scaffold: `questiontype.php`, `question.php`, editing form,
  renderer, options table (`qtype_vimipad_options`) and backup/restore.
- Automatic grading: a self-contained, deterministic structural scorer
  (`\qtype_vimipad\local\scorer`) grading the learner's map against an
  author reference map (recall of nodes and relation triples) or, when none is
  set, against configurable minimum node/relation counts.
- Consumption of the mod_vimipad public API: the diagram-profile list in the
  editing form comes from `\mod_vimipad\profile\profiles`.
- Hard dependency on `mod_vimipad` (2026080800 / 0.9.0), English and German
  language packs at parity, and a null privacy provider.

### Known limitations (next steps)
- The response area is a plain-text field carrying the serialised map; the
  interactive editor embed (ViMi Pad `ServiceTransport` bound to the attempt)
  is not wired yet.
- Grading uses a scorer local to this plugin because mod_vimipad's real scorers
  (`vimipadassess`) are not yet exposed through its stable public API. Delegating
  to a public scoring facade is the intended long-term design.
