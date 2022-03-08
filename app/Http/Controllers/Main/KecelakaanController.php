<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KecelakaanController extends Controller
{
    public function index(Request $request)
    {
        $data['kecelakaan'] = DB::table('tb_kecelakaan')
            ->select(
                'tb_kecelakaan.id_kecelakaan',
                'tb_kecelakaan.id_do',
                'tb_order_kendaraan.no_so',
                'tb_kendaraan.nama_kendaraan as kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kecelakaan.tgl_kecelakaan as tgl',
                'tb_kecelakaan.jam_kecelakaan as jam',
                'tb_kecelakaan.lokasi_kejadian as lokasi',
            )
            ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_kecelakaan.id_do')
            ->join('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_kecelakaan')
            ->get();

        // return $data;
        return view('dashboard.main.accident.index', $data);
    }

    public function detail(Request $request, $id)
    {
        $data['kecelakaan'] = DB::table('tb_kecelakaan')
            ->select(
                'tb_kecelakaan.id_kecelakaan',
                'tb_kecelakaan.id_do',
                'tb_order_kendaraan.no_so',
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
                'tb_driver.nama_driver'
            )
            ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_kecelakaan.id_do')
            ->join('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
            ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
            ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->where('id_kecelakaan', $id)
            ->first();

        $data['assignment'] = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.kembali',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan'
            )
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->rightJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->where('id_do', $data['kecelakaan']->id_do)
            ->first();
        $data['kerusakan'] = DB::table('tb_detail_foto_kecelakaan as tb_foto')
            ->select(
                'tb_foto.foto_pendukung',
                'tb_foto.keterangan'
            )
            ->where('id_kecelakaan',  $data['kecelakaan']->id_kecelakaan)
            ->get();

        // return $data;

        return view('dashboard.main.accident.detail', $data);
    }
}
