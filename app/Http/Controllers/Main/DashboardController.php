<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Kendaraan;
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
        $penugasan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_order_kendaraan.tujuan as tujuan',
                'tb_driver.nama_driver'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->where('tb_penugasan_driver.status_penugasan', 'p')
            ->orderByDesc('tb_penugasan_driver.id_do')
            ->limit(5)
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
        // $history = DB::table('tb_driver')
        //     ->selectRaw(
        //         "tb_driver.no_badge,
        //     tb_driver.nama_driver,
        //     COUNT(tb_penugasan_driver.id_do) as penugasan,
        //     COUNT(tb_pembatalan_penugasan.id_driver) as pembatalan,
        //     SUM(tb_status_driver.jml_nonaktif) as status,
        //     CEIL((SELECT AVG(tb_rating_driver.nilai) as x FROM tb_rating_driver WHERE tb_rating_driver.id_do = tb_penugasan_driver.id_do)) as rating
        //     GROUP BY penugasan
        //     "
        //     )
        //     ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_driver', '=', 'tb_driver.id_driver')
        //     ->leftJoin('tb_pembatalan_penugasan', 'tb_pembatalan_penugasan.id_driver', '=', 'tb_driver.id_driver')
        //     ->leftJoin('tb_status_driver', 'tb_status_driver.id_driver', '=', 'tb_driver.id_driver')
        //     ->leftJoin('tb_kecelakaan', 'tb_kecelakaan.id_do', '=', 'tb_penugasan_driver.id_do')
        //     // ->groupBy('id_driver')
        //     ->orderByDesc('penugasan')
        //     ->limit(5)
        //     ->get();
        $history = DB::select(
            "SELECT tb_driver.id_driver, tb_driver.no_badge,
            tb_driver.nama_driver,
            COUNT(tb_penugasan_driver.id_do) as penugasan,
            COUNT(tb_pembatalan_penugasan.id_driver) as pembatalan,
            COUNT(tb_kecelakaan.id_do) as kecelakaan,
            SUM(tb_status_driver.jml_nonaktif) as nonaktif,
            CEIL((SELECT AVG(tb_rating_driver.nilai) as x FROM tb_rating_driver WHERE tb_rating_driver.id_do = tb_penugasan_driver.id_do)) as rating
            FROM tb_driver
            LEFT JOIN tb_penugasan_driver on tb_penugasan_driver.id_driver = tb_driver.id_driver
            LEFT JOIN tb_pembatalan_penugasan on tb_pembatalan_penugasan.id_driver = tb_driver.id_driver
            LEFT JOIN tb_status_driver on tb_status_driver.id_driver = tb_driver.id_driver
            LEFT JOIN tb_kecelakaan on tb_kecelakaan.id_do = tb_penugasan_driver.id_do
            GROUP BY tb_driver.id_driver, tb_driver.no_badge, tb_driver.nama_driver, .tb_penugasan_driver.id_do
            ORDER BY rating DESC
            LIMIT 5
            "
        );
        $data = [
            'driver' => $countDriver,
            'driverY' => $countDriverY,
            'driverN' => $countDriverN,
            'kendaraan' => $countKendaraan,
            'penugasan' => $penugasan,
            'status' => $status,
            'perbaikan' => $perbaikan,
            'countPerbaikan' => $countPerbaikan,
            'history' => $history
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
