<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages\EditIntervention;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages\ViewIntervention;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\RelationManagers\InterventionsRelationManager;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Tables\InterventionsTable;
use App\Models\Beneficiary;
use App\Models\Catagraphy;
use App\Models\Intervention;
use Carbon\Carbon;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class InterventionResource extends Resource
{
    protected static ?string $model = Intervention::class;

    protected static ?string $parentResource = BeneficiaryResource::class;

    public static function getModelLabel(): string
    {
        return __('intervention.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('intervention.label.plural');
    }

    public static function getRecordTitle(?Model $record): string
    {
        return \sprintf('%s: %s', $record->type, $record->name);
    }

    public static function table(Table $table): Table
    {
        return InterventionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InterventionsRelationManager::class,
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return BeneficiaryResource::getRecordSubNavigation($page);
    }

    public static function getPages(): array
    {
        return [
            'view' => ViewIntervention::route('/{record}'),
            'edit' => EditIntervention::route('/{record}/edit'),
        ];
    }

    public static function getValidVulnerabilities(Beneficiary|Catagraphy|Intervention $record): ?Collection
    {
        /** @var Beneficiary */
        $beneficiary = $record instanceof Beneficiary ? $record : $record->beneficiary;

        return Cache::driver('array')
            ->remember(
                "valid-vulnerabilities-beneficiary-{$beneficiary->id}",
                MINUTE_IN_SECONDS,
                fn () => Catagraphy::whereBeneficiary($beneficiary)
                    ->first()
                    ?->all_valid_vulnerabilities
                    ->pluck('label')
            );
    }

    public static function hasValidVulnerabilities(Beneficiary|Catagraphy|Intervention $record): bool
    {
        /** @var Beneficiary */
        $beneficiary = $record instanceof Beneficiary ? $record : $record->beneficiary;

        return static::getValidVulnerabilities($beneficiary)
            ?->isNotEmpty() ?? false;
    }

    public static function minReportingDate(): Carbon
    {
        if (today()->day > 5) {
            return today()->startOfMonth();
        }

        return today()->subMonth()->startOfMonth();
    }
}
