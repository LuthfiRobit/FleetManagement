<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $lokasi = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.lat_tujuan',
                'tb_penugasan_driver.long_tujuan',
                'tb_penugasan_driver.tmp_tujuan as tujuan',
                'tb_driver.nama_driver',
                'tb_petugas.nama_lengkap as petugas'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->where('status_penugasan', 'p')
            ->get();
        // ->map(function ($ll) {
        //     return [
        //         [
        //             'lat' => $ll->lat_tujuan,
        //             'lng' => $ll->long_tujuan,
        //         ],
        //         $ll->nama_driver
        //     ];
        // })
        // ;
        // return $lokasi;
        return view('dashboard.main', compact('lokasi'));
    }
}
