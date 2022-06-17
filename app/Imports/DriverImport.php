<?php

namespace App\Imports;

use App\Models\Driver;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DriverImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use Importable;

    public function rules(): array
    {
        return [
            'no_badge' => [
                'required',
                'string',
                'unique:tb_driver'
            ],
        ];
    }

    public function model(array $row)
    {
        return new Driver([
            'no_badge'  => $row['no_badge'],
            'nama_driver' => $row['nama_driver'],
            'alamat'    => $row['alamat'],
            'umur' => $row['umur'],
            'no_tlp' => $row['no_tlp'],
            'user' => $row['no_badge'],
            'password' => Hash::make($row['no_tlp']),
            'status_driver' => $row['status_driver'],
        ]);
    }
}
