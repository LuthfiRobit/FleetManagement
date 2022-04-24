<?php

namespace App\Exports;

use App\Models\PengecekanKendaraan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PengecekanCarExport implements FromView
{
    //     /**
    //      * @return \Illuminate\Support\Collection
    //      */
    //     public function collection()
    //     {
    //         return PengecekanKendaraan::all();
    //     }
    protected $id;

    function __construct($id)
    {
        $this->id = $id;
    }
    public function view(): View
    {
        $id = $this->id;
        return view('dashboard.export.expengecekanCar', [
            'checkCar' =>  DB::table('tb_pengecekan_kendaraan')
                ->select(
                    'tb_pengecekan_kendaraan.id_pengecekan',
                    'tb_pengecekan_kendaraan.tgl_pengecekan',
                    'tb_pengecekan_kendaraan.jam_pengecekan',
                    'tb_pengecekan_kendaraan.km_kendaraan',
                    'tb_pengecekan_kendaraan.status_kendaraan',
                    'tb_pengecekan_kendaraan.status_pengecekan',
                    'tb_pengecekan_kendaraan.status_perbaikan',
                    'tb_kendaraan.kode_asset',
                    'tb_kendaraan.nama_kendaraan',
                    'tb_kendaraan.no_polisi',
                    'tb_kendaraan.warna',
                    'tb_kendaraan.jenis_penggerak',
                    'tb_merk_kendaraan.nama_merk as merk',
                    'tb_jenis_kendaraan.nama_jenis as jenis',
                    'tb_bahan_bakar.nama_bahan_bakar as bahan_bakar',
                    'tb_driver.nama_driver'
                )
                ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_pengecekan_kendaraan.id_driver')
                ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
                ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
                ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
                ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
                ->where('id_pengecekan', $id)
                ->first(),
            'detail' => DB::table('tb_detail_pengecekan')
                ->select(
                    'tb_detail_pengecekan.id_detail_pengecekan',
                    'tb_detail_pengecekan.kondisi',
                    'tb_detail_pengecekan.keterangan',
                    'tb_detail_pengecekan.waktu_pengecekan as waktu',
                    'tb_kriteria_pengecekan.nama_kriteria as kriteria',
                    'tb_jenis_pengecekan.jenis_pengecekan as jenis',
                )
                ->join('tb_jenis_pengecekan', 'tb_jenis_pengecekan.id_jenis_pengecekan', '=', 'tb_detail_pengecekan.id_jenis_pengecekan')
                ->join('tb_kriteria_pengecekan', 'tb_kriteria_pengecekan.id_kriteria', '=', 'tb_jenis_pengecekan.id_kriteria')
                ->where('id_pengecekan', $id)
                ->get()
        ]);
    }
}
