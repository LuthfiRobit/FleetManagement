<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengecekanKendaraanController extends Controller
{
    public function index(Request $request)
    {
        $data['pengecekan'] = DB::table('tb_pengecekan_kendaraan')
            ->select(
                'tb_pengecekan_kendaraan.id_pengecekan',
                'tb_pengecekan_kendaraan.tgl_pengecekan',
                'tb_pengecekan_kendaraan.jam_pengecekan',
                'tb_pengecekan_kendaraan.km_kendaraan',
                'tb_pengecekan_kendaraan.status_kendaraan',
                'tb_pengecekan_kendaraan.status_pengecekan',
                'tb_penugasan_driver.id_do',
                'tb_kendaraan.nama_kendaraan',
            )
            ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pengecekan_kendaraan.id_do')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_pengecekan')
            ->get();
        // return $data;
        return view('dashboard.main.checking.index', $data);
    }

    public function detail(Request $request)
    {
    }
}
