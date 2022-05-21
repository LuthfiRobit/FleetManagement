<?php

namespace App\Exports;

use App\Models\Kecelakaan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class KecelakaanExportOne implements FromView
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Kecelakaan::all();
    // }

    protected $id;
    function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $id = $this->id;
        return view('dashboard.export.exKecelakaanOne', [
            'acd' =>  DB::table('tb_kecelakaan')
                ->select(
                    'tb_kecelakaan.id_kecelakaan',
                    'tb_kecelakaan.id_do',
                    'tb_order_kendaraan.no_so',
                    'tb_order_kendaraan.tujuan',
                    'tb_kecelakaan.tgl_kecelakaan as tgl',
                    'tb_kecelakaan.jam_kecelakaan as jam',
                    'tb_kecelakaan.lokasi_kejadian as lokasi',
                    'tb_kecelakaan.kronologi',
                    'tb_kendaraan.kode_asset',
                    'tb_kendaraan.nama_kendaraan as kendaraan',
                    'tb_kendaraan.no_polisi',
                    'tb_kendaraan.warna',
                    'tb_kendaraan.jenis_penggerak',
                    'tb_merk_kendaraan.nama_merk as merk',
                    'tb_jenis_kendaraan.nama_jenis as jenis',
                    'tb_bahan_bakar.nama_bahan_bakar as bahan_bakar',
                    'tb_driver.nama_driver',
                    'tb_petugas.nama_lengkap as atasan',
                    'tb_detail_so.nama_penumpang as saksi'
                )
                ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_kecelakaan.id_do')
                ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
                ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
                ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
                ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
                ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
                ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
                ->leftJoin('tb_saksi_kecelakaan', 'tb_saksi_kecelakaan.id_kecelakaan', '=', 'tb_kecelakaan.id_kecelakaan')
                ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_saksi_kecelakaan.id_atasan')
                ->leftJoin('tb_detail_so', 'tb_detail_so.id_detail_so', '=', 'tb_saksi_kecelakaan.id_saksi')
                ->where('tb_kecelakaan.id_kecelakaan', $id)
                ->first()
        ]);
    }
}
