<?php

namespace Tests\Unit;

use App\Support\ContentStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContentStorageTest extends TestCase
{
    public function test_new_uploads_go_to_the_private_disk_only(): void
    {
        Storage::fake('protected');
        Storage::fake('public');

        $path = ContentStorage::store(UploadedFile::fake()->create('a.pdf', 10, 'application/pdf'), 'materials/1/2');

        Storage::disk('protected')->assertExists($path);
        Storage::disk('public')->assertMissing($path);
        $this->assertSame('protected', ContentStorage::diskFor($path));
    }

    public function test_legacy_public_files_are_still_found_until_moved(): void
    {
        Storage::fake('protected');
        Storage::fake('public');
        Storage::disk('public')->put('lessons/9/old.mp4', 'x');

        $this->assertSame('public', ContentStorage::diskFor('lessons/9/old.mp4'));
        $this->assertNotNull(ContentStorage::absolutePath('lessons/9/old.mp4'));
        $this->assertNull(ContentStorage::absolutePath('lessons/9/missing.mp4'));
    }

    public function test_delete_removes_the_file_from_either_disk(): void
    {
        Storage::fake('protected');
        Storage::fake('public');
        Storage::disk('protected')->put('a.pdf', 'x');
        Storage::disk('public')->put('b.pdf', 'x');

        ContentStorage::delete('a.pdf');
        ContentStorage::delete('b.pdf');
        ContentStorage::delete(null);

        Storage::disk('protected')->assertMissing('a.pdf');
        Storage::disk('public')->assertMissing('b.pdf');
    }
}
