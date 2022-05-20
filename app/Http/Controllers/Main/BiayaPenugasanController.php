<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\PenugasanBiayaDetailAcc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            // ->when(Auth::user()->id_petugas == 5, function ($sc) {
            //     // $sc->having(DB::raw('COUNT(tb_detail_acc_biaya.id_detail_acc)'), '=', 0);
            //     $sc->where('tb_detail_acc_biaya.id_petugas', '=', null);
            // })
            // ->when(Auth::user()->id_petugas == 4, function ($mc) {
            //     $mc->where('tb_detail_acc_biaya.id_petugas', '!=', null);
            // })
            ->orderBy(DB::raw('GROUP_CONCAT(DISTINCT tb_detail_acc_biaya.id_petugas,"")'))
            ->get()
            ->map(function ($data) {
                return [
                    'id_biaya' => $data->id_biaya_penugasan,
                    'nama_driver' => $data->nama_driver,
                    'no_so' => $data->no_so,
                    'tgl_pengajuan' => $data->tgl_pengajuan,
                    'total' => $data->total_biaya,
                    'jml_acc' => $data->x,
                    'acc_oleh' => $data->acc_oleh
                ];
            });
        // return $data;
        // dd($data);
        return view('dashboard.main.biayapenugasan.index', $data);
    }

    public function detail($id)
    {
        $data['biaya'] = DB::table('tb_biaya_penugasan')
            ->select(
                'tb_biaya_penugasan.id_biaya_penugasan',
                'tb_order_kendaraan.no_so',
                'tb_driver.nama_driver',
                'tb_biaya_penugasan.tgl_pengajuan',
                'tb_biaya_penugasan.total_biaya',
                DB::raw('GROUP_CONCAT(DISTINCT tb_detail_acc_biaya.id_petugas,"") as acc_oleh')
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', 'tb_biaya_penugasan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_detail_biaya', 'tb_detail_biaya.id_biaya_penugasan', '=', 'tb_biaya_penugasan.id_biaya_penugasan')
            ->leftJoin('tb_detail_acc_biaya', 'tb_detail_acc_biaya.id_detail_biaya', '=', 'tb_detail_biaya.id_detail_biaya')
            ->groupByRaw('
                tb_order_kendaraan.no_so,
                tb_driver.nama_driver,
                tb_biaya_penugasan.id_biaya_penugasan,
                tb_biaya_penugasan.tgl_pengajuan,
                tb_biaya_penugasan.total_biaya
            ')
            ->where('tb_biaya_penugasan.id_biaya_penugasan', $id)
            ->first();
        $data['detail_biaya'] = DB::table('tb_detail_biaya')
            ->select(DB::raw('
                tb_detail_biaya.id_detail_biaya, tb_jenis_pengeluaran.nama_jenis,
                tb_detail_biaya.nominal, tb_detail_biaya.bukti, tb_detail_biaya.keterangan,

                (SELECT tb_detail_acc_biaya.tgl_pengecekan FROM tb_detail_acc_biaya
                WHERE tb_detail_acc_biaya.id_detail_biaya = tb_detail_biaya.id_detail_biaya
                AND tb_biaya_penugasan.id_biaya_penugasan = tb_detail_biaya.id_biaya_penugasan
                AND tb_detail_acc_biaya.id_petugas = 5) as tgl_cek_sc,

                (SELECT tb_detail_acc_biaya.status_acc FROM tb_detail_acc_biaya
                WHERE tb_detail_acc_biaya.id_detail_biaya = tb_detail_biaya.id_detail_biaya
                AND tb_biaya_penugasan.id_biaya_penugasan = tb_detail_biaya.id_biaya_penugasan
                AND tb_detail_acc_biaya.id_petugas = 5) as acc_sc,

                (SELECT tb_detail_acc_biaya.tgl_pengecekan FROM tb_detail_acc_biaya
                WHERE tb_detail_acc_biaya.id_detail_biaya = tb_detail_biaya.id_detail_biaya
                AND tb_biaya_penugasan.id_biaya_penugasan = tb_detail_biaya.id_biaya_penugasan
                AND tb_detail_acc_biaya.id_petugas = 4) as tgl_cek_mc,

                (SELECT tb_detail_acc_biaya.status_acc FROM tb_detail_acc_biaya
                WHERE tb_detail_acc_biaya.id_detail_biaya = tb_detail_biaya.id_detail_biaya
                AND tb_biaya_penugasan.id_biaya_penugasan = tb_detail_biaya.id_biaya_penugasan
                AND tb_detail_acc_biaya.id_petugas = 4) as acc_mc
            '))
            ->leftJoin('tb_biaya_penugasan', 'tb_biaya_penugasan.id_biaya_penugasan', 'tb_detail_biaya.id_biaya_penugasan')
            ->leftJoin('tb_jenis_pengeluaran', 'tb_jenis_pengeluaran.id_jenis_pengeluaran', 'tb_detail_biaya.id_jenis_pengeluaran')
            ->where('tb_biaya_penugasan.id_biaya_penugasan', $id)
            ->get();

        $data['total_sc'] = $data['detail_biaya']->where('acc_sc', 't')->sum('nominal');
        $data['total_mc'] = $data['detail_biaya']->where('acc_mc', 't')->sum('nominal');
        // return $data;
        return view('dashboard.main.biayapenugasan.detail', $data);
    }

    public function insert(Request $request)
    {
        if ($request->acc_sc != null) {

            foreach ($request->acc_sc as $key => $value) {
                $x['id_detail_biaya'] = $key;
                $x['status_acc'] = $value;
                $x['tgl_pengecekan'] = date('Y-m-d');
                $x['id_petugas'] = Auth::user()->id_petugas;
                PenugasanBiayaDetailAcc::updateOrCreate([
                    'id_detail_biaya' => $key,
                    'id_petugas' => Auth::user()->id_petugas,
                ], $x);
            }
            return redirect()->route('biaya.main');
        }

        if ($request->acc_mc != null) {

            foreach ($request->acc_mc as $key => $value) {
                $x['id_detail_biaya'] = $key;
                $x['status_acc'] = $value;
                $x['tgl_pengecekan'] = date('Y-m-d');
                $x['id_petugas'] = Auth::user()->id_petugas;
                PenugasanBiayaDetailAcc::updateOrCreate([
                    'id_detail_biaya' => $key,
                    'id_petugas' => Auth::user()->id_petugas,
                ], $x);
            }
            return redirect()->route('biaya.main');
        }
    }
}
