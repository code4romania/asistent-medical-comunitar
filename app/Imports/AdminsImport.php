<?php

declare(strict_types=1);

namespace App\Imports;

use App\Enums\User\Role;
use App\Models\User;
use App\Services\Sanitize;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AdminsImport implements ToModel, ShouldQueue, WithChunkReading, WithValidation, SkipsEmptyRows, WithHeadingRow
{
    use Importable;

    public function model(array $row): User
    {
        return new User([
            'role' => Role::ADMIN,
            'first_name' => $row['prenume'],
            'last_name' => $row['nume'],
            'email' => $row['e_mail'],
        ]);
    }

    public function rules(): array
    {
        return [
            'prenume' => ['required', 'string'],
            'nume' => ['required', 'string'],
            'e_mail' => ['required', 'email', 'unique:users,email'],
        ];
    }

    public function prepareForValidation($row)
    {
        $row['prenume'] = Sanitize::title($row['prenume']);
        $row['nume'] = Sanitize::title($row['nume']);
        $row['e_mail'] = Sanitize::email($row['e_mail']);

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
}
