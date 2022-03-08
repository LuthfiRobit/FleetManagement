<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\PenugasanBatal;
use App\Models\PenugasanDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenugasanDriverController extends Controller
{
    public function index(Request $request)
    {
        $data['assignment'] = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_order_kendaraan.no_so',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan as status_do',
                'tb_driver.nama_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi'
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
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
                'tb_penugasan_driver.id_driver',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.status_penugasan as status_do',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_order_kendaraan.no_so',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_driver.nama_driver',
                'tb_petugas.no_tlp as p_tlp',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.warna',
                'tb_kendaraan.jenis_penggerak',
                'tb_merk_kendaraan.nama_merk as merk',
                'tb_jenis_kendaraan.nama_jenis as jenis',
                'tb_bahan_bakar.nama_bahan_bakar as bahan_bakar'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->rightJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
            ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
            ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
            ->where('id_do', $id)
            ->orderByDesc('id_do')
            ->first();

        $data['driver'] = DB::table('tb_driver')
            ->select(
                'tb_driver.nama_driver',
                'tb_driver.no_tlp as d_tlp',
                'tb_departemen.nama_departemen as departemen'
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_driver.id_driver', $data['detail']->id_driver)
            ->first();

        $data['penumpang'] = DB::table('tb_detail_so')
            ->select(
                'tb_detail_so.id_detail_so',
                'tb_detail_so.nama_penumpang',
                'tb_detail_so.no_tlp',
                'tb_detail_so.jabatan as nama_jabatan'
            )
            ->orderByDesc('id_detail_so')
            ->where('id_service_order', $data['detail']->id_service_order)->get();

        // return $data;
        return view('dashboard.main.assignment.detail', $data);
    }

    //for pembatalan
    public function indexbatal(Request $request)
    {
        $data['batal'] = DB::table('tb_pembatalan_penugasan')
            ->select(
                'tb_pembatalan_penugasan.id_pembatalan',
                'tb_pembatalan_penugasan.id_do',
                'tb_pembatalan_penugasan.id_driver',
                'tb_pembatalan_penugasan.alasan_pembatalan as alasan',
                'tb_pembatalan_penugasan.tanggal',
                'tb_pembatalan_penugasan.status_pembatalan',
                'tb_driver.nama_driver',
                'tb_order_kendaraan.no_so'
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pembatalan_penugasan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_pembatalan_penugasan.id_driver')
            ->orderByDesc('tb_pembatalan_penugasan.id_pembatalan')
            ->get();

        // return $data;
        return view('dashboard.main.assignmentbatal.index', $data);
    }

    public function detailbatal(Request $request, $id)
    {
        $data['batal'] = DB::table('tb_pembatalan_penugasan')
            ->select(
                'tb_pembatalan_penugasan.id_pembatalan',
                'tb_pembatalan_penugasan.id_do',
                'tb_pembatalan_penugasan.id_driver',
                'tb_pembatalan_penugasan.alasan_pembatalan as alasan',
                'tb_pembatalan_penugasan.tanggal',
                'tb_pembatalan_penugasan.status_pembatalan',
                'tb_pembatalan_penugasan.bukti',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.id_jenis_sim',
                'tb_jenis_sim.nama_sim',
                'tb_order_kendaraan.no_so'
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pembatalan_penugasan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_jenis_sim', 'tb_jenis_sim.id_jenis_sim', '=', 'tb_kendaraan.id_jenis_sim')
            ->where('tb_pembatalan_penugasan.id_pembatalan', $id)
            ->first();
        $id_driver = $data['batal']->id_driver;
        $id_sim = $data['batal']->id_jenis_sim;
        $tgl_tugas = $data['batal']->tgl_penugasan;

        $data['driver'] = DB::table('tb_driver')
            ->select(
                'tb_driver.nama_driver',
                'tb_driver.no_tlp',
                'tb_departemen.nama_departemen as departemen',
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_driver.id_driver', $data['batal']->id_driver)
            ->first();
        $data['history'] = PenugasanBatal::where('id_driver', $data['batal']->id_driver)->count();
        $data['terima'] = PenugasanBatal::where([['id_driver', $data['batal']->id_driver], ['status_pembatalan', 't']])->count();
        $data['tolak'] = PenugasanBatal::where([['id_driver', $data['batal']->id_driver], ['status_pembatalan', 'tl']])->count();

        $data['drivers'] = DB::select(
            "SELECT tb_driver.id_driver, tb_driver.nama_driver FROM tb_driver
            LEFT JOIN tb_detail_sim on tb_detail_sim.id_driver = tb_driver.id_driver
            WHERE tb_driver.status_driver = 'y' AND tb_detail_sim.id_jenis_sim = '$id_sim'
            -- AND NOT EXISTS (SELECT id_driver FROM tb_pembatalan_penugasan WHERE tb_pembatalan_penugasan.id_driver = '$id_driver' AND tb_pembatalan_penugasan.status_pembatalan = null)
            AND NOT EXISTS (SELECT id_driver FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_driver = tb_driver.id_driver AND tb_penugasan_driver.tgl_penugasan = ' $tgl_tugas')"
        );

        // return $data;
        return view('dashboard.main.assignmentbatal.detail', $data);
    }

    public function terimabatal(Request $request)
    {
        $id_pembatalan = $request->id_pembatalan;
        $id_do = $request->id_do;

        $find_pembatalan = PenugasanBatal::where('id_pembatalan', $id_pembatalan)->first();
        if ($find_pembatalan) {
            $find_pembatalan->update(['status_pembatalan' => 't']);
            $find_do = PenugasanDriver::where('id_do', $id_do)->first();
            $data = [
                'id_driver' => $request->id_driver_baru
            ];
            $find_do->update($data);
            return redirect()->back()->with('success', 'Terima Pembatalan Berhasil Diproses');
        } else {
            return redirect()->back()->with('success', 'Terima Pembatalan Gagal Diproses');
        }
    }

    public function tolakbatal(Request $request, $id)
    {
        // $id_do = $request->get('id_do');
        // $id_driver = $request->get('id_driver');
        $find = PenugasanBatal::where('id_pembatalan', $id)->first();
        if ($find) {
            // return $find;
            $find->update(['status_pembatalan' => 'tl']);
            return redirect()->back()->with('success', 'Tolak Pembatalan Berhasil Diproses');
        } else {
            // return $find;
            return redirect()->back()->with('success', 'Tolak Pembatalan Gagal Diproses');
        }
    }
}
