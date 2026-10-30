# Multi-language support (English · العربية · Kiswahili · Oluganda)

* Switcher: `resources/views/partials/language-switcher.blade.php` (header of every layout; pages without one get a floating switcher automatically).
* Route: `GET /language/{en|ar|sw|lg}` -> `LanguageController@switch` (stores choice in session **and** a 1-year cookie, then redirects back).
* `SetLocale` middleware applies the saved language on every request; `TranslateResponse` translates the rendered HTML from `resources/lang/{ar,sw,lg}.json` and sets `<html lang dir>` (RTL for Arabic).
* Languages are configured in `config/languages.php`.

## Add / fix a translation
Edit `resources/lang/ar.json`, `sw.json` or `lg.json` (`"English text": "Translation"`). Matching ignores extra whitespace.
`{1}` matches any text, `{#1}` matches a number, e.g. `"{#1} lessons": "{1} دروس"`.
Anything not in the dictionary simply stays in English. Controller messages can also use `__('...')`.

## Adding another language
1. Add an entry (`name`, `native`, `short`, `dir`) to `config/languages.php`.
2. Create `resources/lang/<code>.json` (copy `sw.json`, translate the values) and, optionally, `resources/lang/<code>/{auth,pagination,passwords,validation}.php`.
3. That's all: the switcher, the lesson/material/quiz "teaching language" dropdowns and the content lock pick it up from the config. `tests/Unit/LugandaDictionaryTest.php` shows a handy completeness check you can copy.

## Teaching language of content (one language = one learning track)
Every lesson, study material (PDF) and quiz has a `language` column (`en`, `ar`, `sw`, `lg`). The teacher chooses it when uploading.
A **student** only sees, opens, pays for, takes quizzes of, and earns progress/certificates/report-card marks from content whose language matches the language currently selected in the switcher.
Switching language therefore starts a fresh track (own progress, dashboard numbers, certificate eligibility and rank). Teachers and admins always see everything (each item shows a small language badge).

* Switch off without touching data: `CONTENT_LANGUAGE_LOCK=false` in `.env`.
* A quiz attached to a lesson always inherits the lesson's language.
* A lesson's language can't be changed in the UI once students have started it (their progress would jump tracks). Admins can still re-label existing content: `php artisan content:set-language sw --class=3 --subject=7 --dry-run` (drop `--dry-run` to apply; also `--lessons=`, `--materials=`, `--exams=`, `--all`).
* Existing content is migrated as **English** (or `DEFAULT_LOCALE`); re-label anything that was really taught in another language with the command above.
* Code: `App\Support\ContentLanguage`, trait `App\Models\Concerns\HasContentLanguage` (`inLanguage()`, `forViewerLanguage()` scopes).

## Protected files (lessons and PDFs)
Lesson files and study-material PDFs are **not** reachable by a public URL any more. New uploads go to the private `protected` disk (`storage/app/protected`) and every view/download goes through `GET /content/lesson-resources/{id}` or `GET /content/materials/{id}` (`ContentFileController` + `ContentAccess`). Per request it checks: role (admin / the teacher who owns or is assigned to the class+subject / student), published status, the student's selected language, active enrolment, class fee paid, and the lesson / PDF price paid. Video and audio keep seeking (HTTP Range). Add `?download=1` to force a download.

Files uploaded before this change still sit in `storage/app/public` and keep working through the same route, but remain reachable by their old `/storage/...` URL until you run, once after deploying:

```
php artisan content:secure-files --dry-run
php artisan content:secure-files
```
(safe to re-run; a file is only removed from the public disk after the private copy is verified). Back up `storage/app` first. If you deploy behind nginx with a size limit, keep `client_max_body_size` as before.

## Not translated (by design)
Terms & Conditions, Privacy Policy (legal text needs a professional translator), e-mails, PDF certificates/report cards (they have their own `ar` files), and user-entered data (course/lesson names).
