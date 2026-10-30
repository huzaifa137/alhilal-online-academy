<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Where lesson files and study-material PDFs live.
 *
 * New uploads go to the private "protected" disk (storage/app/protected, not
 * reachable by URL). Files uploaded before that change may still sit on the
 * old public disk; they keep working through the access-checked download route
 * until `php artisan content:secure-files` moves them.
 *
 * The path saved in the database is the same relative path on either disk.
 */
class ContentStorage
{
    public const DISK = 'protected';
    public const LEGACY_DISK = 'public';

    public static function store(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, self::DISK);
    }

    /** Disk name that currently holds $path, or null when the file is missing. */
    public static function diskFor(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        foreach ([self::DISK, self::LEGACY_DISK] as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                return $disk;
            }
        }

        return null;
    }

    /** Absolute filesystem path of $path, or null when the file is missing. */
    public static function absolutePath(?string $path): ?string
    {
        $disk = self::diskFor($path);

        return $disk ? Storage::disk($disk)->path($path) : null;
    }

    /** Delete from whichever disk(s) hold it. */
    public static function delete(?string $path): void
    {
        if (!$path) {
            return;
        }

        foreach ([self::DISK, self::LEGACY_DISK] as $disk) {
            Storage::disk($disk)->delete($path);
        }
    }
}
