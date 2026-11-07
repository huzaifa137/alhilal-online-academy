<?php

namespace App\Services;

/**
 * PDFs are now built with mPDF (see App\Services\ArabicPdf), which shapes and
 * reorders Arabic itself. Text must therefore reach the view UNTOUCHED:
 * pre-shaping it with ar-php (utf8Glyphs) makes mPDF shape it a second time and
 * the letters come out broken again.
 */
class ArabicTextService
{
    /**
     * Kept for backwards compatibility with the ar() helper; intentionally a
     * no-op now (mPDF does the shaping).
     */
    public static function shape(?string $text): string
    {
        return (string) $text;
    }

    /**
     * Arabic ordinal words for 1..12, used to build "السنة الأولى", etc.
     */
    private static function ordinalAr(int $n): string
    {
        $ordinals = [
            1 => 'الأولى', 2 => 'الثانية', 3 => 'الثالثة', 4 => 'الرابعة',
            5 => 'الخامسة', 6 => 'السادسة', 7 => 'السابعة', 8 => 'الثامنة',
            9 => 'التاسعة', 10 => 'العاشرة', 11 => 'الحادية عشرة', 12 => 'الثانية عشرة',
        ];

        return $ordinals[$n] ?? (string) $n;
    }

    /**
     * Best-effort Arabic translation of a level code (P1, I2, T3, ...)
     * used across Al-Hilal's Primary / Idaad / Thanawi sections. Falls
     * back to the English level name if the code isn't recognised.
     */
    public static function levelLabel(?string $code, ?string $englishName = null): string
    {
        if (!$code || !preg_match('/^([A-Za-z]+)\s*(\d+)$/', trim($code), $m)) {
            return $englishName ?? (string) $code;
        }

        $prefix = strtoupper($m[1]);
        $number = (int) $m[2];
        $ordinal = self::ordinalAr($number);

        return match ($prefix) {
            'P' => "السنة {$ordinal} - الابتدائية",
            'I' => "السنة {$ordinal} - الإعدادية",
            'T' => "السنة {$ordinal} - الثانوية",
            default => $englishName ?? (string) $code,
        };
    }

    /**
     * Best-effort Arabic translation of a section name (Primary / Idaad /
     * Thanawi). Falls back to the original name if unrecognised.
     */
    public static function sectionLabel(?string $sectionName): ?string
    {
        if (!$sectionName) {
            return null;
        }

        return match (true) {
            str_contains(strtolower($sectionName), 'primary') => 'المستوى الابتدائي',
            str_contains(strtolower($sectionName), 'idaad')   => 'المستوى الإعدادي',
            str_contains(strtolower($sectionName), 'thanawi') => 'المستوى الثانوي',
            default => $sectionName,
        };
    }
}
