<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Cloner\Data;

class BiayaPenugasanController extends Controller
{
    public function index(Request $request)
    {
        $data['biaya_penugasan'] = DB::table('tb_biaya_penugasan')
            ->selectRaw('
                tb_order_kendaraan.no_so,
                tb_driver.nama_driver,
                tb_biaya_penugasan.id_biaya_penugasan,
                tb_biaya_penugasan.tgl_pengajuan,
                tb_biaya_penugasan.total_biaya,
                COUNT(tb_detail_acc_biaya.id_detail_acc) as x,
                GROUP_CONCAT(DISTINCT tb_detail_acc_biaya.id_petugas,"") as acc_oleh
            ')
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_biaya_penugasan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_detail_biaya', 'tb_detail_biaya.id_biaya_penugasan', '=', 'tb_biaya_penugasan.id_biaya_penugasan')
            ->leftJoin('tb_detail_acc_biaya', 'tb_detail_acc_biaya.id_detail_biaya', '=', 'tb_detail_biaya.id_detail_biaya')
            ->groupByRaw('
                tb_order_kendaraan.no_so,
                tb_driver.nama_driver,
                tb_biaya_penugasan.id_biaya_penugasan,
                tb_biaya_penugasan.tgl_pengajuan,
                tb_biaya_penugasan.total_biaya
            ')
            ->get()
            ->map(function ($data) {
                return [
                    'id_biaya' => $data->id_biaya_penugasan,
                    'nama_driver' => $data->nama_driver,
                    'no_so' => $data->no_so,
                    'pengajuan' => $data->tgl_pengajuan,
                    'jml_acc' => $data->x,
                    'acc_oleh' => $data->acc_oleh
                ];
            });
        // return $data;
        return view('dashboard.main.biayapenugasan.index', $data);
    }
}
