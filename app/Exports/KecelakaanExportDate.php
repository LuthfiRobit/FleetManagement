<?php

namespace App\Exports;

use App\Models\Kecelakaan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class KecelakaanExportDate implements FromView
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Kecelakaan::all();
    // }
    protected $tgl_kecelakaan;
    function __construct($tgl_kecelakaan)
    {
        $this->tgl_kecelakaan = $tgl_kecelakaan;
    }

    public function view(): View
    {
        $tgl_kecelakaan = $this->tgl_kecelakaan;
        return view('dashboard.export.exKecelakaanDate', [
            'acdn' =>  DB::table('tb_kecelakaan')
                ->select(
                    'tb_kecelakaan.id_kecelakaan',
                    'tb_kecelakaan.id_do',
                    'tb_order_kendaraan.no_so',
                    'tb_order_kendaraan.tujuan',
                    'tb_kecelakaan.tgl_kecelakaan as tgl',
                    'tb_kecelakaan.jam_kecelakaan as jam',
                    'tb_kecelakaan.lokasi_kejadian as lokasi',
                    'tb_kendaraan.nama_kendaraan as kendaraan',
                    'tb_kendaraan.no_polisi',
                    'tb_kendaraan.warna',
                    'tb_driver.nama_driver',
                    'tb_petugas.nama_lengkap as atasan',
                    'tb_detail_so.nama_penumpang as saksi'
                )
                ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_kecelakaan.id_do')
                ->join('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
                ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
                ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
                ->leftJoin('tb_saksi_kecelakaan', 'tb_saksi_kecelakaan.id_kecelakaan', '=', 'tb_kecelakaan.id_kecelakaan')
                ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_saksi_kecelakaan.id_atasan')
                ->leftJoin('tb_detail_so', 'tb_detail_so.id_detail_so', '=', 'tb_saksi_kecelakaan.id_saksi')
                ->where('tgl_kecelakaan', $tgl_kecelakaan)
                ->get()
        ]);
    }
}
