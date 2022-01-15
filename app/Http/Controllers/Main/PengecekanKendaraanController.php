<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\PenugasanDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengecekanKendaraanController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');
        $data['pengecekan'] = DB::table('tb_pengecekan_kendaraan')
            ->select(
                'tb_pengecekan_kendaraan.id_pengecekan',
                'tb_pengecekan_kendaraan.id_do',
                'tb_pengecekan_kendaraan.id_kendaraan',
                'tb_pengecekan_kendaraan.tgl_pengecekan',
                'tb_pengecekan_kendaraan.jam_pengecekan',
                'tb_pengecekan_kendaraan.km_kendaraan',
                'tb_pengecekan_kendaraan.status_kendaraan',
                'tb_pengecekan_kendaraan.status_pengecekan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_driver.nama_driver'
            )
            ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pengecekan_kendaraan.id_do')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->orderByDesc('id_pengecekan')
            ->get();

        $data['kendaraan'] = DB::table('tb_kendaraan')
            ->select(
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
            )
            // ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->leftJoin('tb_pengecekan_kendaraan', 'tb_pengecekan_kendaraan.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            // ->whereNull('tb_penugasan_driver.id_kendaraan')
            ->whereNull('tb_pengecekan_kendaraan.id_kendaraan')
            ->orderByDesc('id_kendaraan')
            ->get();
        // return $data;
        return view('dashboard.main.checking.index', $data);
    }

    public function updateVehicle(Request $request, $id)
    {
        $find = PenugasanDriver::where('id_do', $id)->first();
        $rules = [
            'id_kendaraan' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('success', 'Failed Change Vehicle');
        } else {
            $data = [
                'id_kendaraan' => $request->id_kendaraan,
                'status_pengecekan' => 'g'
            ];
            $updateVehicle = $find->update($data);
            if ($updateVehicle) {
                return redirect()->back()->with('success', 'Successed Change Vehicle');
            } else {
                return redirect()->back()->with('success', 'Failed Change Vehicle');
            }
        }
    }

    public function detail(Request $request, $id)
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
                'tb_kendaraan.kode_asset',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.warna',
                'tb_kendaraan.jenis_penggerak',
                'tb_merk_kendaraan.nama_merk as merk',
                'tb_jenis_kendaraan.nama_jenis as jenis',
                'tb_bahan_bakar.nama_bahan_bakar as bahan_bakar',
                'tb_driver.nama_driver'
            )
            ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pengecekan_kendaraan.id_do')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
            ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
            ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->where('id_pengecekan', $id)
            ->orderByDesc('id_pengecekan')
            ->first();
        // return $data;
        $data['detail'] = DB::table('tb_detail_pengecekan')
            ->select(
                'tb_detail_pengecekan.id_detail_pengecekan',
                'tb_detail_pengecekan.kondisi',
                'tb_detail_pengecekan.keterangan',
                'tb_kriteria_pengecekan.nama_kriteria as kriteria',
                'tb_jenis_pengecekan.jenis_pengecekan as jenis',
            )
            ->join('tb_jenis_pengecekan', 'tb_jenis_pengecekan.id_jenis_pengecekan', '=', 'tb_detail_pengecekan.id_jenis_pengecekan')
            ->join('tb_kriteria_pengecekan', 'tb_kriteria_pengecekan.id_kriteria', '=', 'tb_jenis_pengecekan.id_kriteria')
            ->where('id_pengecekan', $id)
            ->get();
        $data['dealer'] = DB::table('tb_dealer')
            ->select('id_dealer', 'nama_dealer', 'status_dealer')->where('status', 'y')->orderByDesc('id_dealer')->get();
        // return $data;
        return view('dashboard.main.checking.detail', $data);
    }
}
