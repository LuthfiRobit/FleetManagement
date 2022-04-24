<?php

namespace App\Exports;

use App\Models\Perbaikan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PerbaikanOneIdExport implements FromView
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Perbaikan::all();
    // }
    protected $id;
    function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $id = $this->id;

        return view('dashboard.export.exPerbaikanOneId', [
            'perbaikan' =>  DB::table('tb_perbaikan')
                ->select(
                    'tb_perbaikan.id_perbaikan',
                    'tb_perbaikan.tgl_perbaikan',
                    'tb_perbaikan.tgl_selesai',
                    'tb_perbaikan.tgl_selesai_pengerjaan',
                    'tb_perbaikan.status_perbaikan',
                    'tb_perbaikan.status_penyelesaian',
                    'tb_perbaikan.total_biaya_perbaikan as total',
                    'tb_dealer.nama_dealer',
                    'tb_dealer.status_dealer',
                    'tb_dealer.alamat',
                    'tb_persetujuan_perbaikan.no_wo',
                    'tb_kendaraan.nama_kendaraan',
                    'tb_kendaraan.no_polisi',
                    'tb_pengecekan_kendaraan.km_kendaraan'
                )
                ->leftJoin('tb_dealer', 'tb_dealer.id_dealer', '=', 'tb_perbaikan.id_dealer')
                ->leftJoin('tb_persetujuan_perbaikan', 'tb_persetujuan_perbaikan.id_persetujuan', '=', 'tb_perbaikan.id_persetujuan')
                ->leftJoin('tb_pengecekan_kendaraan', 'tb_pengecekan_kendaraan.id_pengecekan', '=', 'tb_persetujuan_perbaikan.id_pengecekan')
                ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
                ->where('tb_perbaikan.id_perbaikan', $id)
                ->first(),
            'komponen' => DB::table('tb_detail_pergantian as tb_ganti')
                ->select(
                    'tb_ganti.id_detail_pergantian as id_ganti',
                    'tb_ganti.nama_komponen',
                    'tb_ganti.jml_komponen',
                    'tb_ganti.harga_satuan'
                )
                ->orderByDesc('id_ganti')
                ->where('id_perbaikan', $id)
                ->get()
        ]);
    }
}
