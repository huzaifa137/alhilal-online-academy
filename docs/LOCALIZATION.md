# Multi-language support (English · العربية · Kiswahili)

* Switcher: `resources/views/partials/language-switcher.blade.php` (header of every layout; pages without one get a floating switcher automatically).
* Route: `GET /language/{en|ar|sw}` -> `LanguageController@switch` (stores choice in session **and** a 1-year cookie, then redirects back).
* `SetLocale` middleware applies the saved language on every request; `TranslateResponse` translates the rendered HTML from `resources/lang/{ar,sw}.json` and sets `<html lang dir>` (RTL for Arabic).
* Languages are configured in `config/languages.php`.

## Add / fix a translation
Edit `resources/lang/ar.json` or `sw.json` (`"English text": "Translation"`). Matching ignores extra whitespace.
`{1}` matches any text, `{#1}` matches a number, e.g. `"{#1} lessons": "{1} دروس"`.
Anything not in the dictionary simply stays in English. Controller messages can also use `__('...')`.

## Not translated (by design)
Terms & Conditions, Privacy Policy (legal text needs a professional translator), e-mails, PDF certificates/report cards (they have their own `ar` files), and user-entered data (course/lesson names).
