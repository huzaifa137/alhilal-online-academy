<?php

namespace App\Console\Commands;

use App\Models\Academic\LessonResource;
use App\Models\Academic\SubjectMaterial;
use App\Support\ContentStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Moves lesson files and study-material PDFs that were uploaded before the
 * private disk existed from storage/app/public (reachable by URL) to
 * storage/app/protected (only reachable through the access-checked route).
 *
 *   php artisan content:secure-files --dry-run
 *   php artisan content:secure-files
 *
 * Safe to re-run. A file is only removed from the public disk after the copy
 * on the private disk has been verified (same size).
 */
class SecureContentFiles extends Command
{
    protected $signature = 'content:secure-files {--dry-run : Only report what would be moved}';

    protected $description = 'Move existing lesson/PDF files from the public disk to the private (access-checked) disk';

    public function handle(): int
    {
        $public = Storage::disk(ContentStorage::LEGACY_DISK);
        $private = Storage::disk(ContentStorage::DISK);
        $dry = (bool) $this->option('dry-run');

        $paths = LessonResource::whereNotNull('file_path')->pluck('file_path')
            ->merge(SubjectMaterial::whereNotNull('file_path')->pluck('file_path'))
            ->unique()
            ->values();

        $moved = $already = $missing = $failed = 0;

        foreach ($paths as $path) {
            if (!$public->exists($path)) {
                $private->exists($path) ? $already++ : $missing++;
                if (!$private->exists($path)) {
                    $this->warn("Missing on both disks: {$path}");
                }
                continue;
            }

            if ($dry) {
                $this->line("Would move: {$path}");
                $moved++;
                continue;
            }

            try {
                $stream = $public->readStream($path);
                $private->writeStream($path, $stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }

                if ($private->exists($path) && $private->size($path) === $public->size($path)) {
                    $public->delete($path);
                    $moved++;
                } else {
                    $private->delete($path);
                    $failed++;
                    $this->error("Copy could not be verified, left in place: {$path}");
                }
            } catch (\Throwable $e) {
                $failed++;
                $this->error("Failed {$path}: " . $e->getMessage());
            }
        }

        $this->table(['Result', 'Files'], [
            [$dry ? 'Would be moved' : 'Moved', $moved],
            ['Already private', $already],
            ['Missing (no file on either disk)', $missing],
            ['Failed', $failed],
        ]);

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
