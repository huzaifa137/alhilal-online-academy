<?php

namespace App\Support;

/**
 * Single source of truth for the "teaching language" of learning content.
 *
 * Every lesson, study material and quiz carries a `language` code (one of the
 * keys of config('languages.supported')). A student only gets the content that
 * matches the language they currently have selected in the language switcher,
 * so switching language starts a separate learning track with its own
 * progress, quizzes, certificate eligibility and report card.
 *
 * Teachers and admins are never restricted: they manage content in all
 * languages. The restriction is only applied through the explicit
 * `forViewerLanguage()` scopes and the guards used by student-facing code.
 */
class ContentLanguage
{
    /** All valid language codes, e.g. ['en', 'ar', 'sw', 'lg']. */
    public static function codes(): array
    {
        return array_keys(config('languages.supported', []));
    }

    public static function default(): string
    {
        return (string) config('languages.default', 'en');
    }

    public static function isValid(?string $code): bool
    {
        return is_string($code) && in_array($code, self::codes(), true);
    }

    /** Laravel validation rule string, e.g. "in:en,ar,sw,lg". */
    public static function rule(): string
    {
        return 'in:' . implode(',', self::codes());
    }

    /** Is the "one language = one learning track" restriction switched on? */
    public static function isLocked(): bool
    {
        return (bool) config('languages.content_lock', true);
    }

    /** The language the current visitor is browsing the site in. */
    public static function current(): string
    {
        $locale = app()->getLocale();

        return self::isValid($locale) ? $locale : self::default();
    }

    /**
     * The language to filter content by for the current visitor, or null when
     * the restriction is switched off (null = "do not filter").
     */
    public static function viewerLanguage(): ?string
    {
        return self::isLocked() ? self::current() : null;
    }

    /**
     * Should the content restriction be enforced for whoever is making this
     * request? True only for a logged-in student (never for teachers/admins).
     */
    public static function enforcedForCurrentUser(): bool
    {
        if (!self::isLocked()) {
            return false;
        }

        return session()->has('LoggedStudent')
            && !session()->has('LoggedTeacher')
            && !session()->has('LoggedAdmin');
    }

    /** Language filter for the current request: viewer language for students, null otherwise. */
    public static function filterForCurrentUser(): ?string
    {
        return self::enforcedForCurrentUser() ? self::current() : null;
    }

    /**
     * May the current user open content taught in $contentLanguage?
     * Always true for teachers/admins and when the restriction is off.
     */
    public static function allows(?string $contentLanguage): bool
    {
        if (!self::enforcedForCurrentUser()) {
            return true;
        }

        return ($contentLanguage ?: self::default()) === self::current();
    }

    /** English name of a language, e.g. "Luganda". */
    public static function name(?string $code): string
    {
        $code = $code ?: self::default();

        return (string) config("languages.supported.$code.name", strtoupper($code));
    }

    /** Native name of a language, e.g. "Oluganda". */
    public static function native(?string $code): string
    {
        $code = $code ?: self::default();

        return (string) config("languages.supported.$code.native", self::name($code));
    }

    /** Short badge text, e.g. "LG". */
    public static function short(?string $code): string
    {
        $code = $code ?: self::default();

        return (string) config("languages.supported.$code.short", strtoupper($code));
    }

    /**
     * Message shown to a student who tries to open content that is taught in
     * another language than the one they have selected.
     */
    public static function mismatchMessage(?string $contentLanguage): string
    {
        return __('This content is taught in :language. Switch the site language to :language to open it.', [
            'language' => self::native($contentLanguage),
        ]);
    }
}
