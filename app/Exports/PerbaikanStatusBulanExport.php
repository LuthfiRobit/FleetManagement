<?php

namespace App\Exports;

use App\Models\Perbaikan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PerbaikanStatusBulanExport implements FromView
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Perbaikan::all();
    // }
    protected $tanggal;
    function __construct($tanggal, $bulan, $tahun, $status)
    {
        $this->tanggal = $tanggal;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->status = $status;
    }

    public function view(): View
    {
        $tanggal = $this->tanggal;
        $bulan = $this->bulan;
        $tahun = $this->tahun;
        $status = $this->status;

        return view('dashboard.export.exPerbaikanStatusBulan', [
            'tanggal' => $tanggal,
            'status' => $status,
            'perbaikan' =>  DB::table('tb_perbaikan')
                ->select(
                    'tb_perbaikan.id_perbaikan',
                    'tb_perbaikan.tgl_perbaikan',
                    'tb_perbaikan.tgl_selesai',
                    'tb_perbaikan.tgl_selesai_pengerjaan',
                    'tb_perbaikan.status_perbaikan',
                    'tb_perbaikan.status_penyelesaian',
                    'tb_perbaikan.total_biaya_perbaikan as biaya',
                    'tb_dealer.nama_dealer',
                    'tb_persetujuan_perbaikan.no_wo',
                    'tb_kendaraan.nama_kendaraan',
                    'tb_kendaraan.no_polisi'
                )
                ->leftJoin('tb_dealer', 'tb_dealer.id_dealer', '=', 'tb_perbaikan.id_dealer')
                ->leftJoin('tb_persetujuan_perbaikan', 'tb_persetujuan_perbaikan.id_persetujuan', '=', 'tb_perbaikan.id_persetujuan')
                ->leftJoin('tb_pengecekan_kendaraan', 'tb_pengecekan_kendaraan.id_pengecekan', '=', 'tb_persetujuan_perbaikan.id_pengecekan')
                ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
                // ->when($status == 's', function ($s) use ($bulan, $tahun) {
                //     $s
                //         ->whereMonth('tb_perbaikan.tgl_perbaikan', $bulan)
                //         ->whereYear('tb_perbaikan.tgl_perbaikan', $tahun)
                //         ->where('tb_perbaikan.status_perbaikan', 's');
                // })
                ->whereMonth('tb_perbaikan.tgl_perbaikan', $bulan)
                ->whereYear('tb_perbaikan.tgl_perbaikan', $tahun)
                ->where('tb_perbaikan.status_perbaikan', $status)
                // ->orderByDesc('tb_perbaikan.id_perbaikan')
                ->get()
        ]);
    }
}
