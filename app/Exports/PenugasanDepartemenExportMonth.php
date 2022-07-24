<?php

namespace App\Exports;

use App\Models\Departemen;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PenugasanDepartemenExportMonth implements FromView
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Departemen::all();
    // }
    protected $bulan;
    function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $bulan = $this->bulan;
        $month = Carbon::parse($bulan)->format('m');
        $year = Carbon::parse($bulan)->format('Y');
        return view('dashboard.export.exPenugasanDepartemenAll', [
            'history' =>  DB::table('tb_departemen as tb_departemen_u')
                ->select(
                    'tb_departemen_u.id_departemen',
                    'tb_departemen_u.nama_departemen',
                    DB::raw('COUNT(tb_order_kendaraan.id_pemesan) as jumlah_total'),
                    DB::raw("
                    (SELECT COUNT(tb_order_kendaraan.id_pemesan) 
                    FROM tb_order_kendaraan
                    LEFT JOIN tb_petugas as tb_pemesan_s on tb_pemesan_s.id_petugas = tb_order_kendaraan.id_pemesan
                    LEFT JOIN tb_departemen on tb_departemen.id_departemen = tb_pemesan_s.id_departemen
                    WHERE tb_departemen.id_departemen = tb_departemen_u.id_departemen
                    AND tb_order_kendaraan.status_tujuan = 'l' AND tb_order_kendaraan.status_so != 'c'
                    AND YEAR(tb_order_kendaraan.tgl_penjemputan) = $year 
                    AND MONTH(tb_order_kendaraan.tgl_penjemputan) = $month) as jumlah_lokal,
                    (SELECT COUNT(tb_order_kendaraan.id_pemesan) 
                    FROM tb_order_kendaraan
                    LEFT JOIN tb_petugas as tb_pemesan_s on tb_pemesan_s.id_petugas = tb_order_kendaraan.id_pemesan
                    LEFT JOIN tb_departemen on tb_departemen.id_departemen = tb_pemesan_s.id_departemen
                    WHERE tb_departemen.id_departemen = tb_departemen_u.id_departemen
                    AND tb_order_kendaraan.status_tujuan = 'o' AND tb_order_kendaraan.status_so != 'c'
                    AND YEAR(tb_order_kendaraan.tgl_penjemputan) = $year 
                    AND MONTH(tb_order_kendaraan.tgl_penjemputan) = $month) as jumlah_out
                ")
                )
                ->leftJoin('tb_petugas as tb_pemesan', 'tb_pemesan.id_departemen', '=', 'tb_departemen_u.id_departemen')
                ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_pemesan', '=', 'tb_pemesan.id_petugas')
                ->groupBy('tb_departemen_u.id_departemen', 'tb_departemen_u.nama_departemen')
                ->where('tb_order_kendaraan.status_so', '!=', 'c')
                // ->orWhereNull('tb_order_kendaraan.status_so')
                ->whereMonth('tb_order_kendaraan.tgl_penjemputan', $month)
                ->whereYear('tb_order_kendaraan.tgl_penjemputan', $year)
                ->orderByDesc(DB::raw('jumlah_total'))
                ->get()
        ]);
    }
}
