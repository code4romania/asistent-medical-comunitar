<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media as Model;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Media extends Model
{
    public function getOriginalFileNameAttribute(): string
    {
        return $this->name . '.' . $this->extension;
    }

    public function streamDownload(Request $request): StreamedResponse
    {
        $downloadHeaders = [
            'Cache-Control' => 'must-revalidate, no-cache, no-store',
            'Content-Type' => $this->mime_type,
            'Content-Length' => $this->size,
            'Content-Disposition' => 'inline; filename="' . $this->original_file_name . '"',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];

        return response()->stream(function () {
            $stream = $this->stream();

            fpassthru($stream);

            if (\is_resource($stream)) {
                fclose($stream);
            }
        }, 200, $downloadHeaders);
    }
}
