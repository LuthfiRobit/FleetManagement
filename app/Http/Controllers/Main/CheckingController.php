<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckingController extends Controller
{
    public function serviceorder(Request $request)
    {
        $data['serviceOrder'] = DB::table('tb_order_kendaraan')
            ->select(
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tgl_penjemputan',
                'tb_order_kendaraan.jam_penjemputan',
                'tb_order_kendaraan.jml_penumpang',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_order_kendaraan.keterangan',
                'tb_order_kendaraan.status_so',
                'tb_order_kendaraan.keterangan_penolakan',
                'tb_petugas.id_petugas',
                'tb_petugas.nama_lengkap',
            )
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_order_kendaraan.id_petugas')
            ->orderByDesc('id_service_order')
            ->get();
        // return $data;
        return view('dashboard.main.serviceorder.index', $data);
    }

    public function detailSo(Request $request, $id)
    {
        $service = DB::table('tb_order_kendaraan')
            ->select(
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tgl_penjemputan',
                'tb_order_kendaraan.jam_penjemputan',
                'tb_order_kendaraan.jml_penumpang',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_order_kendaraan.keterangan',
                'tb_order_kendaraan.status_so',
                'tb_order_kendaraan.keterangan_penolakan',
                'tb_petugas.id_petugas',
                'tb_petugas.nama_lengkap'
            )
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_order_kendaraan.id_petugas')
            ->orderByDesc('id_service_order')
            ->where('id_service_order', $id)
            ->first();

        $detail_so = DB::table('tb_detail_so')
            ->select(
                'id_detail_so',
                'nama_penumpang',
                'no_tlp'
            )
            ->orderByDesc('id_detail_so')
            ->where('id_service_order', $id)
            ->get();

        $order = DB::table('tb_petugas')
            ->select(
                'tb_petugas.id_petugas',
                'tb_petugas.nama_lengkap',
                'tb_departemen.nama_departemen',
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_petugas.id_departemen')
            ->where('id_petugas', $service->id_petugas)
            ->first();

        $driver = DB::select(
            'SELECT tb_driver.nama_driver,tb_driver.id_driver FROM tb_driver
            WHERE NOT EXISTS (SELECT id_driver FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_driver = tb_driver.id_driver AND tb_penugasan_driver.tgl_penugasan = ' . '"' . $service->tgl_penjemputan . '")'
        );

        $kendaraan =  DB::select(
            'SELECT tb_kendaraan.nama_kendaraan,tb_kendaraan.id_kendaraan FROM tb_kendaraan
            WHERE NOT EXISTS (SELECT id_kendaraan FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_kendaraan = tb_kendaraan.id_kendaraan AND tb_penugasan_driver.tgl_penugasan = ' . '"' . $service->tgl_penjemputan . '")'
        );
        $data = [
            'serviceorder' => $service,
            'order' => $order,
            'detailso' => $detail_so,
            'jumlahdetail' => $detail_so->count(),
            'driver' => $driver,
            'kendaraan' => $kendaraan
        ];
        return view('dashboard.main.serviceorder.detail', $data);
    }

    public function acceptSo(Request $request, $id)
    {
        // $find = DB::table('tb_order_kendaraan')->where('id_service_order', $id);
        $find = ServiceOrder::where('id_service_order', $id)->first();
        if ($find == true) {
            $find->update(['status_so' => 't']);
            $data = [
                'id_service_order'  => $find->id_service_order,
                'id_driver'         => $request->id_driver,
                'id_kendaraan'      => $request->id_kendaraan,
                'id_petugas'        => $find->id_petugas,
                'tgl_penugasan'     => $find->tgl_penjemputan,
                'jam_berangkat'     => Carbon::parse($find->jam_penjemputan)->format('H:i:s'),
                'kembali'           => $request->kembali,
                'tgl_acc'           => date('Y-m-d'),
                'status_penugasan'  => 't'
            ];
            $penugasancreate = DB::table('tb_penugasan_driver')->insert($data);
            if ($penugasancreate) {
                return redirect()->route('checking.serviceorder')->with('success', 'Service Order is Accepted');
            } else {
                return 'gagal simpan';
            }
        } else {
            return 'gagal';
        }

        // return redirect()->route('checking.serviceorder')->with('success', 'Service Order is Accepted');
    }

    public function rejectSo(Request $request, $id)
    {
        $data = [
            'status_so' => 'tl',
            'keterangan_penolakan' => $request->keterangan_penolakan
        ];

        $find = DB::table('tb_order_kendaraan')->where('id_service_order', $id)->update($data);

        return redirect()->route('checking.serviceorder')->with('success', 'Service Order is Rejected');
    }

    // public function createSo(Request $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $so = [
    //             'id_service_order'  => $request->id_service_order,
    //             'id_petugas'        => $request->id_petugas,
    //             'tgl_penjemputan'   => $request->tgl_penjemputan,
    //             'jam_penjemputan'   => $request->jam_penjemputan,
    //             'jml_penumpang'     => $request->jml_penumpang,
    //             'tempat_penjemputan' => $request->tempat_penjemputan,
    //             'tujuan'            => $request->tujuan,
    //             'keterangan'        => $request->keterangan
    //         ];
    //         // $saveSo = DB::table('tb_order_kendaraan')->insert($so);
    //         $saveSo = ServiceOrder::create($so);
    //         $namaPenumpang = $request->nama_penumpang;
    //         foreach ($namaPenumpang as $key => $value) {
    //             $serviceDetail = [
    //                 'id_service_order'  => $request->id_service_order,
    //                 'nama_penumpang'    => $request->nama_penumpang[$key],
    //                 'no_tlp'            => $request->no_tlp[$key]
    //             ];
    //             $saveDetailSo = DB::table('tb_detail_so')->insert($serviceDetail);
    //         }

    //         DB::commit();
    //         return response()->json(
    //             [
    //                 'pesan'             => 'sukses',
    //                 'id_service_order'  => $request->id_service_order
    //             ],
    //             200
    //         );
    //     } catch (\Exception $exception) {
    //         //throw $th;
    //         DB::rollBack();
    //         return response()->json(
    //             [
    //                 'pesan' => 'gagal',
    //                 'errors' => $exception
    //             ],
    //             400
    //         );
    //     }
    // }
}
