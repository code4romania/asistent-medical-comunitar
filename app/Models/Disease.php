<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToCatagraphy;
use App\Concerns\HasDiagnostic;
use App\Contracts\HasVulnerabilityData;
use App\DataTransferObjects\VulnerabilityData;
use App\DataTransferObjects\VulnerabilityEntry;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model implements HasVulnerabilityData
{
    use BelongsToCatagraphy;
    use HasDiagnostic;
    use HasFactory;

    protected $fillable = [
        'type',
        'category',
        'rare_disease',
        'start_year',
        'notes',
    ];

    protected $casts = [
        'type' => 'string',
        'category' => 'string',
        'rare_disease' => 'string',
        'start_year' => 'int',
        'notes' => 'string',
    ];

    protected $with = [
        'diagnostic',
    ];

    public function vulnerabilityData(): VulnerabilityData
    {
        $categories = VulnerabilityCategory::cachedList();
        $vulnerabilities = Vulnerability::cachedList();

        $category = $vulnerabilities->get($this->category);
        $vulnerability = $vulnerabilities->get($this->type);

        $entries = [
            new VulnerabilityEntry(
                label: $categories->get('SS_B'),
                value: $category?->name,
            ),
        ];

        if ($this->rare_disease) {
            $entries[] = new VulnerabilityEntry(
                label: $categories->get('SS_SL'),
                value: $vulnerabilities->get($this->rare_disease)?->name,
            );
        }

        $entries[] = new VulnerabilityEntry(
            label: __('field.cat_diz_dx'),
            value: $this->diagnostic?->name,
        );

        $entries[] = new VulnerabilityEntry(
            label: __('field.cat_diz_deb'),
            value: $this->start_year,
        );

        return new VulnerabilityData(
            name: "{$vulnerability->name}: {$category?->name}",
            category: $vulnerability->name,
            entries: $entries,
        );
    }
}
