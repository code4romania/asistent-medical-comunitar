<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\CommunityActivity;
use App\Models\Document;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MediaController extends Controller
{
    public function __invoke(Request $request, Media $media): StreamedResponse
    {
        if (\is_null($media->model)) {
            abort(404);
        }

        $authorized = match ($media->model_type) {
            'community_activity' => $this->authorizeMediaAccessForCommunityActivity($media->model),
            'document' => $this->authorizeMediaAccessForDocument($media->model),
            'user' => $this->authorizeMediaAccessForUser($media->model),
            default => false,
        };

        abort_unless($authorized, 404);

        abort_unless(Storage::disk($media->disk)->exists($media->getPathRelativeToRoot()), 404);

        return $media->streamDownload($request);
    }

    private function authorizeMediaAccessForCommunityActivity(CommunityActivity $model): bool
    {
        if (auth()->user()->isAdmin()) {
            return true;
        }

        if (auth()->user()->isCoordinator()) {
            return auth()->user()->county_id === $model->county_id;
        }

        if (auth()->user()->isNurse()) {
            return auth()->user()->activity_county_id === $model->county_id;
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
