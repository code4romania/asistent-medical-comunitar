<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CommunityActivity;
use App\Models\Document;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    public function __invoke(Request $request, Media $media): StreamedResponse
    {
        abort_unless($media->model, Response::HTTP_NOT_FOUND);

        $authorized = match ($media->model_type) {
            'community_activity' => $this->authorizeMediaAccessForCommunityActivity($media->model),
            'document' => $this->authorizeMediaAccessForDocument($media->model),
            'user' => $this->authorizeMediaAccessForUser($media->model),
            default => false,
        };

        abort_unless($authorized, Response::HTTP_FORBIDDEN);

        abort_unless(Storage::disk($media->disk)->exists($media->getPathRelativeToRoot()), Response::HTTP_NOT_FOUND);

        return $media->streamDownload($request);
    }

    private function authorizeMediaAccessForCommunityActivity(CommunityActivity $model): bool
    {
        if (auth()->user()->isAdmin()) {
            return true;
        }

        if (auth()->user()->isCoordinator()) {
            return auth()->user()->county_id === $model->nurse->activity_county_id;
        }

        if (auth()->user()->isNurse()) {
            return auth()->user()->id === $model->nurse_id;
        }

        return false;
    }

    private function authorizeMediaAccessForDocument(Document $model): bool
    {
        if (! auth()->user()->isNurse()) {
            return false;
        }

        return auth()->user()->beneficiaries()
            ->where('id', $model->beneficiary_id)
            ->exists();
    }

    private function authorizeMediaAccessForUser(User $model): bool
    {
        if (auth()->user()->isAdmin()) {
            return true;
        }

        if (auth()->user()->isCoordinator()) {
            return auth()->user()->county_id === $model->activity_county_id;
        }

        if (auth()->user()->isNurse()) {
            return auth()->user()->id === $model->id;
        }

        return false;
    }
}
