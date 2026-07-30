<?php

use App\Services\ArabicTextService;

if (!function_exists('ar')) {
    /**
     * Shape an Arabic string so dompdf renders joined letters correctly.
     * Usage in Blade: {{ ar('شهادة إنجاز') }}
     */
    function ar(?string $text): string
    {
        return ArabicTextService::shape($text);
    }
}

if (!function_exists('ar_level_label')) {
    /**
     * Arabic label for a class level code (P1, I2, T3 ...), shaped and
     * ready to echo directly in a Blade template.
     */
    function ar_level_label(?string $code, ?string $englishName = null): string
    {
        return ArabicTextService::shape(ArabicTextService::levelLabel($code, $englishName));
    }
}

if (!function_exists('ar_section_label')) {
    /**
     * Arabic label for a section name (Primary / Idaad / Thanawi), shaped
     * and ready to echo directly in a Blade template.
     */
    function ar_section_label(?string $sectionName): ?string
    {
        $label = ArabicTextService::sectionLabel($sectionName);

        return $label ? ArabicTextService::shape($label) : null;
    }
}
