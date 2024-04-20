<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Service\Service;
use App\Models\Vulnerability\Vulnerability;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function vulnerabilities(): BelongsToMany
    {
        return $this->belongsToMany(Vulnerability::class);
    }

    public function scopeForVulnerabilities(Builder $query, Collection | array | null $vulnerabilities): Builder
    {
        $vulnerabilities = collect($vulnerabilities)
            ->map(fn ($vulnerability) => match (true) {
                $vulnerability instanceof Vulnerability => $vulnerability->id,
                default => $vulnerability,
            });

        return $query->whereHas('vulnerabilities', function (Builder $query) use ($vulnerabilities) {
            return $query->whereIn('vulnerabilities.id', $vulnerabilities);
        });
    }
}
