<?php

namespace App\Http\Controllers;

use App\Models\Academic\LessonResource;
use App\Models\Academic\SubjectMaterial;
use App\Services\ContentAccess;
use App\Support\ContentStorage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * The only way to fetch a lesson file or a study-material PDF.
 *
 * Files live on a private disk, so there is no public /storage/... URL to
 * share. Access is decided per request by ContentAccess (enrolment, class and
 * lesson/PDF payment, language). Streams with HTTP Range support, so video and
 * audio seeking keeps working.
 */
class ContentFileController extends Controller
{
    public function __construct(private ContentAccess $access)
    {
    }

    public function lessonResource(Request $request, LessonResource $resource)
    {
        if (!$resource->file_path) {
            // External link resource: nothing stored here, send them on.
            abort_unless($resource->external_url, 404);
            $resource->loadMissing('lesson');
            $this->authorizeOrFail($this->access->forLesson($resource->lesson));

            return redirect()->away($resource->external_url);
        }

        $resource->loadMissing('lesson');
        $this->authorizeOrFail($this->access->forLesson($resource->lesson));

        return $this->stream($request, $resource->file_path, $resource->title);
    }

    public function material(Request $request, SubjectMaterial $material)
    {
        $this->authorizeOrFail($this->access->forMaterial($material));

        return $this->stream($request, $material->file_path, $material->title);
    }

    private function authorizeOrFail(?string $denyReason): void
    {
        if ($denyReason !== null) {
            abort(403, $denyReason);
        }
    }

    private function stream(Request $request, ?string $storedPath, ?string $title): BinaryFileResponse
    {
        $absolute = ContentStorage::absolutePath($storedPath);
        abort_unless($absolute, 404, 'File not found.');

        $extension = pathinfo($storedPath, PATHINFO_EXTENSION);
        $name = trim(preg_replace('/[^\pL\pN\s._-]+/u', '', (string) $title)) ?: 'download';
        if ($extension && !str_ends_with(strtolower($name), '.' . strtolower($extension))) {
            $name .= '.' . $extension;
        }

        $response = response()->file($absolute, [
            // Never let a proxy/browser cache hand a protected file to someone else.
            'Cache-Control' => 'private, no-store, max-age=0',
            'X-Content-Type-Options' => 'nosniff',
        ]);

        $response->setContentDisposition(
            $request->boolean('download') ? 'attachment' : 'inline',
            $name,
            // ASCII fallback for the header
            preg_replace('/[^\x20-\x7E]+/', '_', $name)
        );

        return $response;
    }
}
