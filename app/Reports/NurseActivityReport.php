<?php

declare(strict_types=1);

namespace App\Reports;

use App\Enums\Beneficiary\Status as BeneficiaryStatus;
use App\Enums\Beneficiary\Type as BeneficiaryType;
use App\Enums\Report\Type;
use App\Models\Beneficiary;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class NurseActivityReport extends ReportData
{
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function getName(): string
    {
        return Type::NURSE_ACTIVITY->label();
    }

    public function getData(): Collection
    {
        if ($this->report->data !== null) {
            return $this->report->data;
        }

        $data = $this->report
            ->indicators
            ->flatMap(
                fn (array $indicators, string $group) => array_map(function ($indicator) use ($group) {
                    return [
                        __(sprintf('report.indicator.%s.value.%s', $group, $indicator)) => [
                            $this->query("$group.$indicator"),
                        ],
                    ];
                }, $indicators)
            )
            ->collapse();

        $this->report->update([
            'title' => $this->getTitle(),
            'data' => $data,
        ]);

        return $data;
    }

    public function query(string $forIndicator)
    {
        return match ($forIndicator) {
            'beneficiaries.total' => $this->beneficiaryQuery()
                ->count(),

            'beneficiaries.registered' => $this->beneficiaryQuery()
                ->where('status', BeneficiaryStatus::REGISTERED)
                ->count(),

            'beneficiaries.catagraphed' => $this->beneficiaryQuery()
                ->where('status', BeneficiaryStatus::CATAGRAPHED)
                ->count(),

            'beneficiaries.active' => $this->beneficiaryQuery()
                ->where('status', BeneficiaryStatus::ACTIVE)
                ->count(),

            'beneficiaries.inactive' => $this->beneficiaryQuery()
                ->where('status', BeneficiaryStatus::INACTIVE)
                ->count(),

            'beneficiaries.removed' => $this->beneficiaryQuery()
                ->where('status', BeneficiaryStatus::REMOVED)
                ->count(),

            'beneficiaries.ocasional' => $this->beneficiaryQuery()
                ->where('type', BeneficiaryType::OCASIONAL)
                ->count(),

            default => null,
        };
    }

    protected function beneficiaryQuery(): Builder
    {
        return Beneficiary::query()
            ->when($this->report->date_from, function (Builder $query, Carbon $date) {
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($this->report->date_until, function (Builder $query, Carbon $date) {
                $query->whereDate('created_at', '<=', $date);
            });
    }
}
