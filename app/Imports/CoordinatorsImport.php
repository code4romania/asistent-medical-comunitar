<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\User\Role;
use App\Models\County;
use App\Models\User;
use App\Services\Sanitize;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CoordinatorsImport implements ToModel, ShouldQueue, WithChunkReading, WithValidation, SkipsEmptyRows, WithHeadingRow
{
    use Importable;

    private array $counties;

    public function __construct()
    {
        $this->counties = County::all()
            ->pluck('name', 'id')
            ->toArray();
    }

    public function model(array $row): User
    {
        return new User([
            'role' => Role::COORDINATOR,
            'first_name' => $row['prenume'],
            'last_name' => $row['nume'],
            'email' => $row['e_mail'],
            'county_id' => $this->getCountyId($row['judet']),
        ]);
    }

    public function rules(): array
    {
        return [
            'prenume' => ['required', 'string'],
            'nume' => ['required', 'string'],
            'e_mail' => ['required', 'email', 'unique:users,email'],
            'judet' => ['required', 'string'],
        ];
    }

    public function prepareForValidation($row)
    {
        $row['prenume'] = Sanitize::title($row['prenume']);
        $row['nume'] = Sanitize::title($row['nume']);
        $row['e_mail'] = Sanitize::email($row['e_mail']);
        $row['judet'] = Sanitize::text($row['judet']);

        return $row;
    }

    public function isEmptyWhen(array $row): bool
    {
        return ! Sanitize::email($row['e_mail']);
    }

    public function chunkSize(): int
    {
        return 10;
    }

    private function getCountyId(string $rawCountyName): ?int
    {
        $countyId = collect($this->counties)
            ->search(fn (string $county, int $id) => Str::slug($county) === Str::slug($rawCountyName));

        return $countyId ?: null;
    }
}
