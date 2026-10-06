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

import {test, expect, Page} from '@playwright/test';
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

    // S2: a student can continue an attempt and still see the editor.
    test('S2 - a student reaches the attempt page', async ({page}) => {
        await login(page, env.baseURL, env.student);
        // startattempt.php must not be requested directly: it requires a sesskey
        // and answers a bare GET with "A required parameter (sesskey) was
        // missing". Go through the quiz page and use its button, exactly as a
        // student would.
        await page.goto(`${env.baseURL}${env.quizPath}&lang=en`);
        await page.getByRole('button', {name: /Attempt quiz( now)?|Re-attempt|Continue your attempt/i})
            .first().click();
        await expect(page.locator('.qtype_vimipad_editor').first()).toBeVisible({timeout: 30_000});
    });
});

/**
 * Start or continue the attempt and wait until the answer editor takes input.
 *
 * @param page The page.
 */
async function openAttempt(page: Page): Promise<void> {
    await login(page, env.baseURL, env.student);
    await page.goto(`${env.baseURL}${env.quizPath}&lang=en`);
    await page.getByRole('button', {name: /Attempt quiz( now)?|Re-attempt|Continue your attempt/i}).first().click();
    await expect(page.getByRole('group', {name: /Add concept/i})).toBeVisible({timeout: 30_000});
}

/**
 * Add a concept through the editor's add form.
 *
 * @param page The page.
 * @param label The concept label.
 */
async function addConcept(page: Page, label: string): Promise<void> {
    const group = page.getByRole('group', {name: /Add concept/i});
    await group.getByLabel(/Concept label/i).fill(label);
    await group.getByRole('button', {name: /^Add$/}).click();
}

test.describe('qtype_vimipad - drawing an answer', () => {
    // Guards the regression where the value transport minted no ids: the
    // second concept never appeared and the answer held an empty map.
    test('S3 - two concepts both appear and are in the answer', async ({page}) => {
        await openAttempt(page);
        const stamp = Date.now().toString(36);
        const first = `Ice ${stamp}`;
        const second = `Steam ${stamp}`;
        await addConcept(page, first);
        await addConcept(page, second);

        const node = (label: string) => page.locator('.vimipad-canvas-node', {hasText: label}).first();
        await expect(node(first)).toBeVisible();
        await expect(node(second)).toBeVisible();

        // The field name contains a colon (q1:1_answer), so look the input up by
        // attribute rather than with an id selector.
        const editorId = await page.locator('.qtype_vimipad_editor').first().getAttribute('id');
        const valueId = editorId!.replace(/_editor$/, '_value');
        const answer = JSON.parse(await page.locator(`[id="${valueId}"]`).inputValue());
        const labels = answer.nodes.map((n: {label: string}) => n.label);
        expect(labels).toEqual(expect.arrayContaining([first, second]));
        for (const n of answer.nodes) {
            expect(n.stableid).toMatch(/^node_[0-9a-f]{12}$/);
        }
    });

    // Guards the regression where every drag was refused before it began.
    test('S4 - a concept in the answer can be dragged', async ({page}) => {
        await openAttempt(page);
        const label = `Water ${Date.now().toString(36)}`;
        await addConcept(page, label);
        const target = page.locator('.vimipad-canvas-node', {hasText: label}).first();
        await expect(target).toBeVisible();

        const before = (await target.boundingBox())!;
        await page.mouse.move(before.x + before.width / 2, before.y + before.height / 2);
        await page.mouse.down();
        await page.mouse.move(before.x + before.width / 2 + 160, before.y + before.height / 2 + 60, {steps: 12});
        await page.mouse.up();

        const after = (await target.boundingBox())!;
        expect(after.x - before.x).toBeGreaterThan(80);
    });
});

