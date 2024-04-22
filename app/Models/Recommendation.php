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

    public static function forVulnerabilities(Collection | array | null $vulnerabilities): Collection
    {
        $vulnerabilities = collect($vulnerabilities)
            ->map(fn ($vulnerability) => match (true) {
                $vulnerability instanceof Vulnerability => $vulnerability->id,
                default => $vulnerability,
            });

        return static::query()
            ->with(['services', 'vulnerabilities.category'])
            ->whereHas('vulnerabilities', function (Builder $query) use ($vulnerabilities) {
                $query->whereIn('vulnerabilities.id', $vulnerabilities);
            })
            ->get()
            ->reject(
                fn (Recommendation $recommendation) => $recommendation
                    ->vulnerabilities
                    ->pluck('id')
                    ->diff($vulnerabilities)
                    ->isNotEmpty()
            );
    }
}
