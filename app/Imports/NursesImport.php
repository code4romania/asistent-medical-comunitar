<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\User\Role;
use App\Models\City;
use App\Models\County;
use App\Models\User;
use App\Services\Sanitize;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\PersistRelations;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\ImportFailed;

class NursesImport implements ToModel, PersistRelations, ShouldQueue, WithValidation, SkipsEmptyRows, SkipsOnError, SkipsOnFailure, WithChunkReading, WithHeadingRow, WithEvents
{
    use Importable;
    use SkipsErrors;
    use SkipsFailures;

    protected ?County $county = null;

    public function chunkSize(): int
    {
        return 100;
    }

    public function isEmptyWhen(array $row): bool
    {
        return ! Sanitize::email($row['e_mail']);
    }

    public function rules(): array
    {
        return [
            'prenume_amc' => ['required', 'string'],
            'nume_amc' => ['required', 'string'],
            'e_mail' => ['required', 'email'],
            'judet' => ['required', 'string'],
            'denumire_uat' => ['required', 'string'],
        ];
    }

    public function prepareForValidation($row, $index)
    {
        $row['prenume_amc'] = Sanitize::title($row['prenume_amc']);
        $row['nume_amc'] = Sanitize::title($row['nume_amc']);
        $row['e_mail'] = Sanitize::email($row['e_mail']);
        $row['judet'] = Sanitize::text($row['judet']);
        $row['denumire_uat'] = Sanitize::text($row['denumire_uat']);

        return $row;
    }

    public function model(array $row): ?User
    {
        $user = new User([
            'role' => Role::NURSE,
            'first_name' => $row['prenume_amc'],
            'last_name' => $row['nume_amc'],
            'email' => $row['e_mail'],
            'activity_county_id' => $this->getCounty($row['judet'])->id,
        ]);

        $user->setRelation('activityCities', $this->getCity($row['denumire_uat']));

        return $user;
    }

    private function getCounty(string $rawCountyName): County
    {
        if (Str::slug($this->county?->name || '') !== Str::slug($rawCountyName)) {
            $this->county = County::query()
                ->with([
                    'cities' => fn ($query) => $query
                        ->select([
                            'county_id',
                            'parent_id',
                            'cities.id',
                            'cities.name',
                        ]),
                ])
                ->whereRaw('UPPER(name) = ?', [
                    Str::of($rawCountyName)
                        ->upper()
                        ->ascii(),
                ])
                ->first();
        }

        return $this->county;
    }

    private function getCity(string $rawCityName): City
    {
        $city = $this->county->cities
            ->first(fn (City $city) => Str::slug($city->name) === Str::slug($rawCityName));

        if (! $city && Str::contains($rawCityName, ' ')) {
            $city = $this->county->cities
                ->reject(fn (City $city) => \is_null($city->parent))
                ->first(function (City $city) use ($rawCityName) {
                    $parts = Str::of($rawCityName)
                        ->trim()
                        ->explode(' ')
                        ->map(fn ($part) => Str::slug($part));

                    $cityName = Str::slug($city->name);
                    $parentCityName = Str::slug($city->parent->name);

                    return ($cityName === $parts[0] && $parentCityName === $parts[1])
                        || ($cityName === $parts[1] && $parentCityName === $parts[0]);
                });
        }

        return $city;
    }
}
