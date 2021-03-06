<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\PenugasanDriver;
use App\Models\Perbaikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $countDriver = Driver::count();
        $countDriverY = Driver::where('status_driver', 'y')->count();
        $countDriverN = Driver::where('status_driver', 't')->count();
        $countKendaraan = Kendaraan::where('status', 'y')->count();
        $countPerbaikan = Perbaikan::where('status_perbaikan', 'p')->count();
        $counPenugasan = PenugasanDriver::where('status_penugasan', 'p')->count();
        $penugasan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_order_kendaraan.tujuan as tujuan',
                'tb_driver.nama_driver',
                'tb_driver.no_tlp',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_pemesan.nama_lengkap as nama_pemesan',
                'tb_dep_pemesan.nama_departemen as dep_pemesan'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_petugas as tb_pemesan', 'tb_pemesan.id_petugas', '=', 'tb_order_kendaraan.id_pemesan')
            ->leftJoin('tb_departemen as tb_dep_pemesan', 'tb_dep_pemesan.id_departemen', '=', 'tb_pemesan.id_departemen')
            ->where('tb_penugasan_driver.status_penugasan', 'p')
            ->orderByDesc('tb_penugasan_driver.id_do')
            ->limit(7)
            ->get();
        $status = DB::table('tb_status_driver')
            ->select(
                'tb_status_driver.status',
                'tb_driver.no_badge',
                'tb_driver.nama_driver'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_status_driver.id_driver')
            ->where('tb_status_driver.status', 'n')
            ->orderByDesc('tb_status_driver.id_status')
            ->limit(3)
            ->get();
        $perbaikan = DB::table('tb_perbaikan')
            ->select(
                'tb_perbaikan.status_perbaikan',
                'tb_kendaraan.kode_asset',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi'
            )
            ->leftJoin('tb_persetujuan_perbaikan', 'tb_persetujuan_perbaikan.id_persetujuan', '=', 'tb_perbaikan.id_persetujuan')
            ->leftJoin('tb_pengecekan_kendaraan', 'tb_pengecekan_kendaraan.id_pengecekan', '=', 'tb_persetujuan_perbaikan.id_pengecekan')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
            ->where('tb_perbaikan.status_perbaikan', 'p')
            ->orderByDesc('tb_perbaikan.id_perbaikan')
            ->limit(3)
            ->get();
        $data = [
            'driver' => $countDriver,
            'driverY' => $countDriverY,
            'driverN' => $countDriverN,
            'kendaraan' => $countKendaraan,
            'penugasan' => $penugasan,
            'countPenugasan' => $counPenugasan,
            'status' => $status,
            'perbaikan' => $perbaikan,
            'countPerbaikan' => $countPerbaikan
        ];
        // return $data;
        return view('dashboard.dashboard', $data);
    }

    public function monitoring()
    {
        $lokasi = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.lat_sekarang',
                'tb_penugasan_driver.long_sekarang',
                'tb_order_kendaraan.tujuan as tujuan',
                'tb_driver.nama_driver',
                'tb_petugas.nama_lengkap as petugas'
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
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
        return view('dashboard.monitoring', compact('lokasi'));
    }
}
