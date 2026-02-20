<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\CatagraphyResource;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns\GetRecordFromParentRecord;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns\HasBreadcrumbs;
use App\Models\Activity;
use App\Models\Catagraphy;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityEntry;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EditCatagraphy extends EditRecord
{
    use HasBreadcrumbs;
    use GetRecordFromParentRecord;
    use UsesParentRecordSubNavigation;

    protected static string $resource = CatagraphyResource::class;

    public function getTitle(): string
    {
        return __('catagraphy.form.edit');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        abort_unless($this->getParentRecord()->isRegular(), 404);
    }

    /**
     * @param  Catagraphy           $record
     * @param  array<string, mixed> $data
     * @return Catagraphy
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $data['nurse_id'] = auth()->id();
        $data['beneficiary_id'] = $this->getParentRecord()->id;

        // Handle pregnancy data
        if (! Vulnerability::isPregnancy($data['cat_rep'])) {
            $data['cat_preg'] = null;
        }

        $record->fill($data)->save();

        if ($record->beneficiary->isRegistered()) {
            $record->beneficiary->markAsCatagraphed();
        }

        $this->form->saveRelationships();

        // Clear disabilities relationship if has_disabilities is false
        // using each->delete() to trigger the model events
        if (! $record->has_disabilities) {
            $record->disabilities->each->delete();
        }

        // Clear diseases relationship if has_health_issues is false
        // using each->delete() to trigger the model events
        if (! $record->has_health_issues) {
            $record->diseases->each->delete();
        }

        // Fix issues with inconsistent calling of $this->record
        // and $this->getRecord() in the parent class.
        $this->record = $record;

        return $record;
    }

    protected function afterSave()
    {
        $catagraphy = $this->getRecord();

        /** @var Collection */
        $properties = $catagraphy->all_vulnerabilities_items
            ->map->toArray()
            ->flatten()
            ->filter()
            ->sort()
            ->values();

        // deprecated
        activity('vulnerabilities')
            ->causedBy(auth()->user())
            ->performedOn($catagraphy->beneficiary)
            ->withProperties($properties)
            ->event('updated')
            ->tap(fn (Activity $activity) => $activity->beneficiary()->associate($catagraphy->beneficiary_id))
            ->log('updated');

        VulnerabilityEntry::create([
            'beneficiary_id' => $catagraphy->beneficiary_id,
            'map' => $properties->countBy(),
        ]);
    }
}
