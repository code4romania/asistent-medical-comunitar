<?php

declare(strict_types=1);

namespace App\Models;

use App\Concerns\BelongsToCatagraphy;
use App\Concerns\HasDiagnostic;
use App\Contracts\HasVulnerabilityData;
use App\DataTransferObjects\VulnerabilityData;
use App\DataTransferObjects\VulnerabilityEntry;
use App\DataTransferObjects\VulnerabilityListItem;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disability extends Model implements HasVulnerabilityData
{
    use BelongsToCatagraphy;
    use HasDiagnostic;
    use HasFactory;

    protected $fillable = [
        'type',
        'degree',
        'receives_pension',
        'has_certificate',
        'start_year',
        'notes',
    ];

    protected $casts = [
        'type' => 'string',
        'degree' => 'string',
        'receives_pension' => 'boolean',
        'has_certificate' => 'boolean',
        'start_year' => 'int',
        'notes' => 'string',
    ];

    protected $with = [
        'diagnostic',
    ];

    public function getCertificateVulnerabilityAttribute(): string
    {
        return $this->has_certificate ? 'VDH_01' : 'VDH_02';
    }

    public function vulnerabilityData(): VulnerabilityData
    {
        $categories = VulnerabilityCategory::cachedList();
        $vulnerabilities = Vulnerability::cachedList();

        $type = $vulnerabilities->get($this->certificate_vulnerability);
        $vulnerability = $vulnerabilities->get($this->type);

        return new VulnerabilityData(
            name: "{$type->name}: {$vulnerability->name}",
            category: $type->name,
            entries: [
                new VulnerabilityEntry(
                    label: $categories->get('DIZ_TIP'),
                    value: $vulnerability->name,
                ),
                new VulnerabilityEntry(
                    label: $categories->get('DIZ_GR'),
                    value: $vulnerabilities->get($this->degree)?->name,
                ),
                new VulnerabilityEntry(
                    label: __('field.cat_diz_dx'),
                    value: $this->diagnostic?->name,
                ),
                new VulnerabilityEntry(
                    label: __('field.cat_diz_iph'),
                    value: $this->has_certificate
                        ? __('forms::components.select.boolean.true')
                        : __('forms::components.select.boolean.false'),
                ),
                new VulnerabilityEntry(
                    label: __('field.cat_diz_deb'),
                    value: $this->start_year,
                ),
            ]
        );
    }

    public function vulnerabilityListItem(): VulnerabilityListItem
    {
        $vulnerabilities = Vulnerability::cachedList();

        $type = $vulnerabilities->get($this->certificate_vulnerability);
        $vulnerability = $vulnerabilities->get($this->type);

        return new VulnerabilityListItem(
            label: "{$type->name}: {$vulnerability->name}",
            value: $this->id, // TODO: ????
            type: $this->getMorphClass(),
        );
    }
}
