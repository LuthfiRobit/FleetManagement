<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KriteriaPengecekan;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiServiceOrderController extends Controller
{

    public function createSo(Request $request)
    {
        DB::beginTransaction();
        try {
            $so = [
                'id_service_order'  => $request->id_service_order,
                'id_petugas'        => $request->id_petugas,
                'tgl_penjemputan'   => $request->tgl_penjemputan,
                'jam_penjemputan'   => $request->jam_penjemputan,
                'jml_penumpang'     => $request->jml_penumpang,
                'tempat_penjemputan' => $request->tempat_penjemputan,
                'tujuan'            => $request->tujuan,
                'keterangan'        => $request->keterangan
            ];
            // $saveSo = DB::table('tb_order_kendaraan')->insert($so);
            $saveSo = ServiceOrder::create($so);
            $namaPenumpang = $request->nama_penumpang;
            foreach ($namaPenumpang as $key => $value) {
                $serviceDetail = [
                    'id_service_order'  => $request->id_service_order,
                    'nama_penumpang'    => $request->nama_penumpang[$key],
                    'no_tlp'            => $request->no_tlp[$key]
                ];
                $saveDetailSo = DB::table('tb_detail_so')->insert($serviceDetail);
            }

            DB::commit();
            return response()->json(
                [
                    'pesan'             => 'sukses',
                    'id_service_order'  => $request->id_service_order
                ],
                200
            );
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            return response()->json(
                [
                    'pesan' => 'gagal',
                    'errors' => $exception
                ],
                400
            );
        }
    }

    public function getDo(Request $request)
    {
        $id = 1;
        $penugasan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_driver',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan',
                'tb_driver.id_driver',
                'tb_driver.nama_driver',
                'tb_petugas.id_petugas',
                'tb_petugas.nama_lengkap',
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_do')
            ->where('tb_penugasan_driver.id_driver', $id)
            ->get();

        return response()->json(
            [
                $penugasan
            ]
        );
    }

    public function listTransport(Request $request)
    {
        $id = 1;
        $kendaraan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.status_penugasan',
                'tb_driver.id_driver',
                'tb_driver.nama_driver',
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tujuan',
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->orderByDesc('id_do')
            ->where('tb_penugasan_driver.id_driver', $id)
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'cek_kendaraan' => $kendaraan
            ]
        );
    }

    public function checkTransport(Request $request)
    {
        $id = 1;
        $kendaraan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.status_penugasan',
                'tb_driver.id_driver',
                'tb_driver.nama_driver',
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tujuan',
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->orderByDesc('id_do')
            ->where('tb_penugasan_driver.id_driver', $id)
            ->first();

        $pengecekan = KriteriaPengecekan::select('id_kriteria', 'nama_kriteria')
            ->with(['jenis_pengecekan' => function ($jenis) {
                $jenis->select('id_jenis_pengecekan', 'id_kriteria', 'jenis_pengecekan')
                    ->where('status', 'y');
            }])
            ->where('status', 'y')
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'data_kendaraan' => $kendaraan,
                'pengecekan'    => $pengecekan
            ]
        );
    }
}
