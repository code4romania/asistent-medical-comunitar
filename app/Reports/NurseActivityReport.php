<?php

declare(strict_types=1);

namespace App\Reports;

use App\Enums\Report\Type;
use App\Models\Beneficiary;
use Tpetry\QueryExpressions\Function\Aggregate\CountFilter;
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Operator\Comparison\Equal;
use Tpetry\QueryExpressions\Value\Value;

class NurseActivityReport extends ReportFactory
{
    public function getName(): string
    {
        return Type::NURSE_ACTIVITY->label();
    }

    protected function queryBeneficiaries(array $values): array
    {
        $select = collect($values)
            ->map(function (string $value) {
                return new Alias(
                    new Coalesce([
                        new CountFilter(new Equal('status', new Value($value))),
                        new Value(0),
                    ]),
                    $value
                );
            })
            ->all();

        return $this->runQueryFor(Beneficiary::class, $select);
    }
}
