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
 * User-story browser tests for qtype_vimipad, grouped by role. Each test records
 * a video on every run - see playwright.config.ts. Stories are specified in
 * ViMi_User_Stories.md. Requires a seeded, running site (see seed.php).
 */

import {test, expect} from '@playwright/test';
import {readEnv, login} from './support/env';

const env = readEnv();

test.describe('qtype_vimipad - Teacher stories', () => {
    // T1: the seeded question shows in the course question bank.
    test('T1 - a ViMi Pad question appears in the question bank', async ({page}) => {
        await login(page, env.baseURL, env.teacher);
        await page.goto(`${env.baseURL}/question/edit.php?courseid=${env.courseId}&lang=en`);
        await expect(page.getByText('States of water').first()).toBeVisible({timeout: 20_000});
    });

    // T2: the quiz built from that question is visible to the teacher.
    test('T2 - the quiz with the ViMi Pad question is available', async ({page}) => {
        await login(page, env.baseURL, env.teacher);
        await page.goto(`${env.baseURL}${env.quizPath}&lang=en`);
        await expect(page).not.toHaveURL(/\/login\//);
        await expect(page.getByRole('heading', {name: /Water quiz/i}).first()).toBeVisible({timeout: 20_000});
    });
});

test.describe('qtype_vimipad - Student stories', () => {
    // S1: the embedded editor is offered when a student attempts the question.
    test('S1 - the editor is offered on the attempt', async ({page}) => {
        await login(page, env.baseURL, env.student);
        await page.goto(`${env.baseURL}${env.quizPath}&lang=en`);
        await page.getByRole('button', {name: /Attempt quiz( now)?|Re-attempt|Continue your attempt/i}).first().click();

        // The attempt page renders the question text and the embedded editor.
        await expect(page.getByText('Map how water changes state.').first()).toBeVisible({timeout: 20_000});
        await expect(page.locator('.qtype_vimipad_editor').first()).toBeVisible({timeout: 30_000});
    });

    // S2: a student can reach the quiz and start where they can draw an answer.
    test('S2 - a student reaches the attempt page', async ({page}) => {
        await login(page, env.baseURL, env.student);
        await page.goto(`${env.baseURL}/mod/quiz/startattempt.php?cmid=${env.quizCmid}&lang=en`);
        // startattempt redirects into attempt.php; the editor is present there.
        await expect(page.locator('.qtype_vimipad_editor').first()).toBeVisible({timeout: 30_000});
    });
});
