<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\DriverStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverStatusController extends Controller
{
    public function index(Request $request)
    {
        $data['status'] = DB::table('tb_status_driver')
            ->select(
                'tb_status_driver.id_status',
                'tb_status_driver.status',
                'tb_status_driver.tgl_nonaktif',
                'tb_status_driver.tgl_aktif',
                'tb_status_driver.jml_nonaktif',
                'tb_driver.id_driver',
                'tb_driver.nama_driver'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_status_driver.id_driver')
            ->orderByDesc('tb_status_driver.id_driver')
            ->get();
        // return $driver;
        return view('dashboard.main.statusdriver.index', $data);
    }

    public function detail(Request $request, $id)
    {
        $data['status'] = DB::table('tb_status_driver')
            ->select(
                'tb_status_driver.id_status',
                'tb_status_driver.status',
                'tb_status_driver.tgl_nonaktif',
                'tb_status_driver.tgl_aktif',
                'tb_status_driver.jml_nonaktif',
                'tb_status_driver.foto_bukti',
                'tb_status_driver.keterangan',
                'tb_driver.id_driver',
                'tb_driver.nama_driver',
                'tb_driver.no_tlp',
                'tb_departemen.nama_departemen as departemen'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_status_driver.id_driver')
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_status_driver.id_status', $id)
            ->first();
        $data['history'] = DriverStatus::where('id_driver', $id)->sum('jml_nonaktif');
        // return $data;
        return view('dashboard.main.statusdriver.detail', $data);
    }
}
