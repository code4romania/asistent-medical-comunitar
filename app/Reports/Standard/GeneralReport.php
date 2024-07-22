<?php

declare(strict_types=1);

namespace App\Reports\Standard;

use App\Models\Beneficiary;
use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;

class GeneralReport extends StandardReport
{
    protected Report $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public static function make(Report $report)
    {
        $static = app(static::class, ['report' => $report]);
        $static->handle();

        return $static;
    }

    protected function populateIndicators(): array
    {
        return [
            'G01' => 'Femeie de vârstă fertilă (15-45 de ani)',
            'G02' => 'Femeie care utilizează metode contraceptive',
            'G03' => 'Vârstnic (peste 65 de ani)',
            'G04' => 'Persoană neînscrisă la medicul de familie',
            'G05' => 'Caz de violenţă în familie',
            'G06' => 'Persoană vârstnică fără familie',
            'G07' => 'Persoană vârstnică cu nevoi medicosociale',
            'G08' => 'Adult cu TBC',
            'G09' => 'Adult cu HIV/SIDA',
            'G10' => 'Adult cu dizabilităţi',
            'G11' => 'Administrare de medicamente pentru persoane vulnerabile',
            'G12' => 'Adult cu risc medicosocial',
            'G13' => 'Adult fără familie',
            'G14' => 'Adult cu boli cronice',
            'G15' => 'Vârstnic cu boli cronice',
            'G16' => 'Vârstnic cu TBC',
            'G17' => 'Vârstnic cu dizabilităţi',
            'G18' => 'Vârstnic cu tulburări mintale şi de comportament',
            'G19' => 'Vârstnic consumator de substanţe psihotrope',
            'G20' => 'Adult cu tulburări mintale şi de comportament',
            'G21' => 'Adult consumator de substanţe psihotrope',
            'G22' => 'Mamă minoră',
            'G23' => 'Lăuză',
            'G24' => 'Adult (fără probleme medicosociale)',
            'G25' => 'Anunţare pentru screening populaţional',
            'G26' => 'Caz tratament paliativ (fază terminală)',
            'G27' => 'Planificare familială',
            'G28' => 'Consiliere preconcepţională',
        ];
    }

    protected function populateQueries(): array
    {
        return [
            'G01' => fn () => Beneficiary::query()
                ->whereHasVulnerabilities(function (Builder $query) {
                    $query->whereJsonContains('properties', 'VGR_10');
                }),
            'G02' => fn () => Beneficiary::query()
                ->whereHasVulnerabilities(function (Builder $query) {
                    $query->whereJsonContains('properties', 'VGR_14');
                }),
            'G03' => fn () => Beneficiary::query()
                ->whereHasVulnerabilities(function (Builder $query) {
                    $query->whereJsonContains('properties', 'VCV_06');
                }),
            'G04' => fn () => Beneficiary::query()
                ->whereHasVulnerabilities(function (Builder $query) {
                    $query->whereJsonContains('properties', 'VSA_02');
                }),
            'G05' => fn () => Beneficiary::query()
                ->whereHasVulnerabilities(function (Builder $query) {
                    $query->whereJsonContains('properties', 'VFV_03');
                }),
        ];
    }
}
