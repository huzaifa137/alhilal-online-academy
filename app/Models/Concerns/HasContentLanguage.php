<?php

namespace App\Models\Concerns;

use App\Support\ContentLanguage;

/**
 * Adds teaching-language helpers to lessons, study materials and quizzes
 * (any model whose table has a `language` column).
 */
trait HasContentLanguage
{
    /**
     * Only rows taught in $language. Passing null does not filter, so callers
     * can hand over ContentLanguage::viewerLanguage() directly.
     */
    public function scopeInLanguage($query, ?string $language)
    {
        if ($language === null || $language === '') {
            return $query;
        }

        return $query->where($this->getTable() . '.language', $language);
    }

    /**
     * Only rows the current visitor's selected language allows them to see.
     * (No-op when CONTENT_LANGUAGE_LOCK is off.)
     */
    public function scopeForViewerLanguage($query)
    {
        return $query->inLanguage(ContentLanguage::viewerLanguage());
    }

    /** Is this row taught in the language the current visitor selected? */
    public function isInViewerLanguage(): bool
    {
        $viewer = ContentLanguage::viewerLanguage();

        return $viewer === null || ($this->language ?: ContentLanguage::default()) === $viewer;
    }

    public function getLanguageNameAttribute(): string
    {
        return ContentLanguage::name($this->language);
    }

    public function getLanguageNativeAttribute(): string
    {
        return ContentLanguage::native($this->language);
    }
}
