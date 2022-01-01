<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenugasanDriverController extends Controller
{
    public function index(Request $request)
    {
        $data['assignment'] = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan as status_do',
                'tb_driver.nama_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_kendaraan.nama_kendaraan'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_do')
            ->get();
        // return $data;
        return view('dashboard.main.assignment.index', $data);
    }

    public function detail(Request $request, $id)
    {
        $data['detail'] = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_service_order',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.status_penugasan as status_do',
                'tb_driver.nama_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->rightJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->where('id_do', $id)
            ->orderByDesc('id_do')
            ->first();
        $data['penumpang'] = DB::table('tb_detail_so')->where('id_service_order', $data['detail']->id_service_order)->get();

        // return $data;
        return view('dashboard.main.assignment.detail', $data);
    }
}
