<?php

namespace App\Exports;

use App\Models\PengecekanKendaraan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PengecekanDateExport implements FromView
{
    // /**
    //  * @return \Illuminate\Support\Collection
    //  */
    // public function collection()
    // {
    //     return PengecekanKendaraan::all();
    // }
    protected $id_kendaraan, $tgl_pengecekan;

    function __construct($id_kendaraan, $tgl_pengecekan)
    {
        $this->id_kendaraan = $id_kendaraan;
        $this->tgl_pengecekan = $tgl_pengecekan;
    }
    public function view(): View
    {
        $id_kendaraan = $this->id_kendaraan;
        $tgl_pengecekan = $this->tgl_pengecekan;
        $kendaraan =  DB::table('tb_pengecekan_kendaraan')
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
            ->when($id_kendaraan != '', function ($q) use ($id_kendaraan) {
                $q->where('tb_pengecekan_kendaraan.id_kendaraan', $id_kendaraan);
            })
            ->where('tb_pengecekan_kendaraan.tgl_pengecekan', $tgl_pengecekan)
            ->get();
        $detail = array();
        foreach ($kendaraan as $kd) {
            $detail_awal = array();
            $detail_awal['id_pengecekan'] = $kd->id_pengecekan;
            $detail_awal['tgl_pengecekan'] = $kd->tgl_pengecekan;
            $detail_awal['jam_pengecekan'] = $kd->jam_pengecekan;
            $detail_awal['km_kendaraan'] = $kd->km_kendaraan;
            $detail_awal['status_kendaraan'] = $kd->status_kendaraan;
            $detail_awal['status_pengecekan'] = $kd->status_pengecekan;
            $detail_awal['kode_asset'] = $kd->kode_asset;
            $detail_awal['nama_kendaraan'] = $kd->nama_kendaraan;
            $detail_awal['no_polisi'] = $kd->no_polisi;
            $detail_awal['jenis_penggerak'] = $kd->jenis_penggerak;
            $detail_awal['merk'] = $kd->merk;
            $detail_awal['jenis'] = $kd->jenis;
            $detail_awal['bahan_bakar'] = $kd->bahan_bakar;
            $detail_awal['nama_driver'] = $kd->nama_driver;
            $detail_pengecekan =  DB::table('tb_detail_pengecekan')
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
                ->where('tb_detail_pengecekan.id_pengecekan', $kd->id_pengecekan)
                ->get();
            $detail_awal['list_detail'] = array();
            foreach ($detail_pengecekan as $dp) {
                $detail_akhir = array();
                $detail_akhir['id_detail_pengecekan'] = $dp->id_detail_pengecekan;
                $detail_akhir['kondisi'] = $dp->kondisi;
                $detail_akhir['keterangan'] = $dp->keterangan;
                $detail_akhir['waktu'] = $dp->waktu;
                $detail_akhir['kriteria'] = $dp->kriteria;
                $detail_akhir['jenis'] = $dp->jenis;
                array_push($detail_awal['list_detail'], $detail_akhir);
            }
            array_push($detail, $detail_awal);
        }
        // dd($detail);
        if ($id_kendaraan != '') {
            return view('dashboard.export.expengecekanDateCar', [
                'checkCar' => $detail
            ]);
        } else {
            return view('dashboard.export.expengecekanDate', [
                'checkCar' => $detail
            ]);
        }
    }
}
