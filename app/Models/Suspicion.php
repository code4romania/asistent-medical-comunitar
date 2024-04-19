<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToCatagraphy;
use App\Contracts\HasVulnerabilityData;
use App\DataTransferObjects\VulnerabilityData;
use App\DataTransferObjects\VulnerabilityEntry;
use App\DataTransferObjects\VulnerabilityListItem;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspicion extends Model implements HasVulnerabilityData
{
    use BelongsToCatagraphy;
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'elements',
        'notes',
    ];

    protected $casts = [
        'name' => 'string',
        'category' => 'string',
        'elements' => 'collection',
        'notes' => 'string',
    ];

    public function vulnerabilityData(): VulnerabilityData
    {
        $categories = VulnerabilityCategory::cachedList();
        $vulnerabilities = Vulnerability::cachedList();

        $category = $vulnerabilities->get($this->category);

        return new VulnerabilityData(
            name: __('catagraphy.suspicion.label', [
                'category' => $category?->name,
                'name' => $this->name,
            ]),
            category: $category?->name,
            entries: [
                new VulnerabilityEntry(
                    label: __('field.suspicion_name'),
                    value: $this->name,
                ),
                new VulnerabilityEntry(
                    label: $categories->get('SUS_CS'),
                    value: $category?->name,
                ),
                new VulnerabilityEntry(
                    label: $categories->get('SUS_BR_ES'),
                    value: $this->elements
                        ?->map(fn (string $element) => $vulnerabilities->get($element)->name)
                        ->join(', '),
                ),
                new VulnerabilityEntry(
                    label: __('field.suspicion_notes'),
                    value: $this->notes,
                ),
            ]
        );
    }

    public function vulnerabilityListItem(): VulnerabilityListItem
    {
        $vulnerabilities = Vulnerability::cachedList();
        $category = $vulnerabilities->get($this->category);

        return new VulnerabilityListItem(
            label: __('catagraphy.suspicion.label', [
                'category' => $category?->name,
                'name' => $this->name,
            ]),
            value: $this->category,
            type: $this->getMorphClass(),
            valid: true
        );
    }
}
