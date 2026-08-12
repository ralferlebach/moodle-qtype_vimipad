// qtype_vimipad — load test (k6), session-based page requests.
//
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
//
// The learner path is: quiz view page -> start/continue an attempt. Both render
// the embedded editor and the attempt page also carries the question's stored
// response, so this is where the question type's page cost actually sits.
//
// Moodle's login form carries a one-time logintoken, so each virtual user first
// fetches the login page, extracts the token and posts credentials; k6 keeps the
// session cookie per VU from then on. Page weight is tracked as well as latency,
// because for these pages the amount of HTML shipped is the thing most likely to
// regress.

import http from 'k6/http';
import { check } from 'k6';
import { Rate, Trend } from 'k6/metrics';

const BASE = __ENV.BASE_URL || 'http://localhost:8000';
const CMID = __ENV.CMID || '1';
const USERNAMES = String(__ENV.USERNAMES || '').split(',').filter((u) => u !== '');
const PASSWORD = __ENV.PASSWORD || '';
const MAXMS = Number(__ENV.MAXMS || '5000');

const pagebytes = new Trend('qtype_vimipad_page_bytes');
const loginerrors = new Rate('qtype_vimipad_login_errors');
const httperrors = new Rate('qtype_vimipad_http_errors');

export const options = {
  vus: Number(__ENV.VUS || '25'),
  duration: __ENV.DURATION || '60s',
  thresholds: {
    'http_req_duration': [`p(95)<${MAXMS}`],
    // A failed login or a non-200 is a defect, not a slow response, so these
    // carry zero tolerance and stay out of the latency statistics.
    'qtype_vimipad_login_errors': ['rate==0'],
    'qtype_vimipad_http_errors': ['rate==0'],
  },
};

/**
 * Log one virtual user in and keep the session for the rest of the iteration.
 *
 * @param {string} username The account to use.
 * @returns {boolean} Whether the login succeeded.
 */
function login(username) {
  const page = http.get(`${BASE}/login/index.php`);
  const match = String(page.body || '').match(/name="logintoken"\s+value="([^"]+)"/);
  const token = match ? match[1] : '';
  const res = http.post(`${BASE}/login/index.php`, {
    username: username,
    password: PASSWORD,
    logintoken: token,
  });
  // Moodle re-renders the login form on failure, so the marker is its absence.
  const ok = res.status === 200 && String(res.body || '').indexOf('name="logintoken"') === -1;
  loginerrors.add(!ok);
  if (!ok) {
    console.error(`login failed for ${username} (HTTP ${res.status})`);
  }
  return ok;
}

/**
 * Request one page and record its latency, size and status.
 *
 * @param {string} name The metric label.
 * @param {string} url The absolute url.
 * @returns {object} The k6 response.
 */
function page(name, url) {
  const res = http.get(url);
  const ok = res.status === 200;
  httperrors.add(!ok, { page: name });
  pagebytes.add(res.body ? res.body.length : 0, { page: name });
  if (!ok) {
    console.error(`${name} returned HTTP ${res.status}`);
  }
  check(res, {
    [`${name} status 200`]: () => ok,
    [`${name} under budget`]: (r) => r.timings.duration < MAXMS,
  });
  return res;
}

export default function () {
  if (USERNAMES.length === 0 || PASSWORD === '') {
    console.error('No USERNAMES/PASSWORD given — run "make load-seed" first.');
    return;
  }
  const username = USERNAMES[(__VU - 1) % USERNAMES.length];
  if (!login(username)) {
    return;
  }
  // The quiz landing page, then the attempt itself.
  page('quiz_view', `${BASE}/mod/quiz/view.php?id=${CMID}`);
  const attempt = page('quiz_attempt', `${BASE}/mod/quiz/startattempt.php?cmid=${CMID}`);
  // startattempt redirects into attempt.php; follow whatever it landed on so a
  // second request measures a warm attempt page rather than a fresh start.
  if (attempt.url && attempt.url.indexOf('attempt.php') !== -1) {
    page('quiz_attempt_reload', attempt.url);
  }
}
