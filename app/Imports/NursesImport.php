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
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Validators\Failure;

class NursesImport implements ToModel, PersistRelations, ShouldQueue, WithValidation, SkipsEmptyRows, SkipsOnFailure, WithChunkReading, WithEvents
{
    use Importable;
    use SkipsFailures;
    use RegistersEventListeners;

    protected ?County $county = null;

    public function chunkSize(): int
    {
        return 100;
    }

    public function isEmptyWhen(array $row): bool
    {
        return ! Sanitize::email($row[4]);
    }

    public function rules(): array
    {
        return [
            'prenume' => ['string'],
            'nume' => ['string'],
            'email' => ['email', 'unique:users,email'],
            'judet' => ['string'],
            'denumire_uat' => ['string'],
        ];
    }

    public function prepareForValidation($row, $index): array
    {
        return [
            'judet' => Sanitize::text($row[0]),
            'denumire_uat' => Sanitize::text($row[1]),
            'nume' => Sanitize::title($row[2]),
            'prenume' => Sanitize::title($row[3]),
            'email' => Sanitize::email($row[4]),
        ];
    }

    public function model(array $row): ?User
    {
        $user = new User([
            'role' => Role::NURSE,
            'first_name' => $row['prenume'],
            'last_name' => $row['nume'],
            'email' => $row['email'],
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

    public static function afterSheet(AfterSheet $event)
    {
        $event->getConcernable()->failures()->each(function (Failure $failure) {
            collect($failure->errors())
                ->each(fn ($message) => logger()->error(
                    __('Validation error on row :row: :message', [
                        'row' => $failure->row(),
                        'message' => $message,
                    ])
                ));
        });
    }
}
