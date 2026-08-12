# qtype_vimipad — load tests (JMeter / k6)

Unlike `mod_vimipad` and the gallery, this question type exposes **no web
service**: a learner meets it through ordinary quiz pages. The load runs are
therefore session-based — they log in and request the quiz view and the attempt
page, which is where the embedded editor, the question's reference map and the
response validation are actually paid for.

## Quick start

```
make load-seed        # quiz with 5 ViMi Pad questions, 300-node reference map, 25 students
make jmeter           # or: make load-k6
```

`make load-seed` writes `BASE_URL`, `CMID`, `USERNAMES` and `PASSWORD` to
`tests/load/.load-env`, read automatically by both runners.

Moodle's login form carries a one-time `logintoken`, so each virtual user first
fetches the login page and extracts it (k6 with a regular expression, JMeter with
a Regex Extractor) before posting credentials; the session cookie is then kept
per thread. The seed creates one account per virtual user so attempts are not
serialised on a single learner's records.

## Sizing the fixture

```
make load-seed SEEDARGS="10 1000 50"     # questions, reference nodes, students
```

The reference map size is the lever worth pulling: it is loaded per attempt and
handed to the scorer on submit, so a large reference is the realistic worst case.

## What is measured

| Metric | Meaning |
| --- | --- |
| `qtype_vimipad_page_bytes` | HTML shipped per page, tagged by page |
| `qtype_vimipad_login_errors` | zero tolerance: a failed login is a defect |
| `qtype_vimipad_http_errors` | zero tolerance: a non-200 is a defect |

Page weight matters as much as latency here: the attempt page carries the map the
learner is editing, so a regression usually shows up as bytes before it shows up
as milliseconds. The default budget is looser (5000 ms) than for a web-service
call, because a full Moodle page render is a different order of work.

## Not part of CI

These runs need a live, seeded site and create courses, users and quizzes.
`/tests/load` is `export-ignore` in `.gitattributes` and never ships in a release
package; the downloaded JMeter distribution, the k6 binary and `.jtl` results are
gitignored.
