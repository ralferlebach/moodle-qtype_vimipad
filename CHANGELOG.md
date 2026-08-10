# Changelog — qtype_vimipad

All notable changes to this plugin are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/) and the project uses plain
incremental release numbers.

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
