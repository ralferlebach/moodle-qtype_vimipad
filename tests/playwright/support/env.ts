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

/** Environment for the qtype_vimipad Playwright user stories. */

export interface TestUser { username: string; password: string; fullname: string; }

export interface QtypeEnv {
    baseURL: string;
    /** The quiz view path, e.g. /mod/quiz/view.php?id=42. */
    quizPath: string;
    /** The quiz course module id, for startattempt. */
    quizCmid: string;
    /** The course id, for the question bank. */
    courseId: string;
    teacher: TestUser;
    student: TestUser;
}

/**
 * Read the environment, throwing a clear error if the seed step has not run.
 *
 * @returns The resolved environment.
 */
export function readEnv(): QtypeEnv {
    const need = (name: string): string => {
        const value = process.env[name];
        if (!value) {
            throw new Error(`Missing ${name}. Run tests/playwright/seed.php first (see README.md).`);
        }
        return value;
    };
    return {
        baseURL: process.env.VIMIQTYPE_BASE_URL ?? 'http://localhost:8000',
        quizPath: need('VIMIQTYPE_QUIZ_PATH'),
        quizCmid: need('VIMIQTYPE_QUIZ_CMID'),
        courseId: need('VIMIQTYPE_COURSE_ID'),
        teacher: {
            username: need('VIMIQTYPE_TEACHER'),
            password: need('VIMIQTYPE_TEACHER_PASS'),
            fullname: process.env.VIMIQTYPE_TEACHER_NAME ?? 'Tay Teacher',
        },
        student: {
            username: need('VIMIQTYPE_STUDENT'),
            password: need('VIMIQTYPE_STUDENT_PASS'),
            fullname: process.env.VIMIQTYPE_STUDENT_NAME ?? 'Sam Student',
        },
    };
}

/**
 * Log a user in through the standard Moodle login form.
 *
 * @param page The Playwright page.
 * @param baseURL The site base URL.
 * @param user The user to log in as.
 */
export async function login(page: import('@playwright/test').Page, baseURL: string, user: TestUser): Promise<void> {
    const {expect} = await import('@playwright/test');
    for (let attempt = 1; attempt <= 2; attempt++) {
        await page.goto(`${baseURL}/login/index.php`);
        await page.locator('#username').fill(user.username);
        await page.locator('#password').fill(user.password);
        await page.locator('#loginbtn').click();
        try {
            await expect(page).not.toHaveURL(/\/login\//, {timeout: 20_000});
            return;
        } catch (error) {
            if (attempt === 2) { throw error; }
        }
    }
}
