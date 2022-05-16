<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\PenugasanDriver;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckingController extends Controller
{
    public function serviceorder(Request $request)
    {
        $data['serviceOrder'] = DB::table('tb_order_kendaraan')
            ->select(
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.no_so',
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
                'tb_penugasan_driver.status_penugasan'
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_service_order', 'tb_order_kendaraan.id_service_order')
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
                'tb_order_kendaraan.no_so',
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
                'tb_detail_so.id_detail_so',
                'tb_detail_so.nama_penumpang',
                'tb_detail_so.jabatan as nama_jabatan',
                'tb_detail_so.no_tlp'
            )
            ->orderByDesc('id_detail_so')
            ->where('id_service_order', $id)
            ->get();

        $order = DB::table('tb_petugas')
            ->select(
                'tb_petugas.id_petugas',
                'tb_petugas.nama_lengkap',
                'tb_petugas.no_tlp',
                'tb_departemen.nama_departemen',
                'tb_jabatan.nama_jabatan'
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_petugas.id_departemen')
            ->leftJoin('tb_jabatan', 'tb_jabatan.id_jabatan', '=', 'tb_petugas.id_jabatan')
            ->where('id_petugas', $service->id_petugas)
            ->first();

        $driver = DB::select(
            'SELECT tb_driver.nama_driver,tb_driver.id_driver FROM tb_driver
            WHERE NOT EXISTS (SELECT id_driver FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_driver = tb_driver.id_driver AND tb_penugasan_driver.tgl_penugasan = ' . '"' . $service->tgl_penjemputan . '")'
        );

        $kendaraan =  DB::select(
            'SELECT tb_kendaraan.nama_kendaraan,tb_kendaraan.no_polisi,tb_kendaraan.id_kendaraan FROM tb_kendaraan
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

    public function serviceAccept(Request $request, $id)
    {
        $findSo = ServiceOrder::where([['id_service_order', $id], ['status_so', null]])->first();
        if ($findSo) {

            $service = DB::table('tb_order_kendaraan')
                ->select(
                    'tb_order_kendaraan.id_service_order as id_so',
                    'tb_order_kendaraan.no_so',
                    'tb_order_kendaraan.tgl_penjemputan as tgl_jpt',
                    'tb_order_kendaraan.jam_penjemputan as jam_jmp',
                    'tb_order_kendaraan.tempat_penjemputan as tmp_jemput',
                    'tb_order_kendaraan.tujuan as tmp_tujuan',
                    'tb_petugas.id_petugas',
                    'tb_petugas.nama_lengkap as petugas',
                    'tb_departemen.nama_departemen as departemen',
                    'tb_jabatan.nama_jabatan as jabatan'
                )
                ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_order_kendaraan.id_petugas')
                ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_petugas.id_departemen')
                ->leftJoin('tb_jabatan', 'tb_jabatan.id_jabatan', '=', 'tb_petugas.id_jabatan')
                ->where('id_service_order', $id)
                ->first();

            $kendaraan =  DB::select(
                "SELECT tb_kendaraan.nama_kendaraan,
                tb_kendaraan.kode_asset,
                tb_kendaraan.no_polisi,
                tb_kendaraan.id_kendaraan,
                tb_kendaraan.id_jenis_sim,
                -- tb_jenis_sim.nama_sim as sim,
                tb_jenis_alokasi.nama_alokasi as alokasi
                FROM tb_kendaraan
                -- JOIN tb_jenis_sim on tb_jenis_sim.id_jenis_sim = tb_kendaraan.id_jenis_sim
                LEFT JOIN tb_alokasi_kendaraan on tb_alokasi_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan
                LEFT JOIN tb_jenis_alokasi on tb_jenis_alokasi.id_jenis_alokasi = tb_alokasi_kendaraan.id_jenis_alokasi
                WHERE tb_kendaraan.status = 'y' AND NOT EXISTS (SELECT id_kendaraan FROM tb_pengecekan_kendaraan WHERE tb_pengecekan_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan
                AND tb_pengecekan_kendaraan.status_kendaraan = 't' AND tb_pengecekan_kendaraan.tgl_pengecekan = '$service->tgl_jpt' UNION SELECT id_kendaraan FROM tb_penugasan_driver
                WHERE tb_penugasan_driver.id_kendaraan = tb_kendaraan.id_kendaraan
                AND tb_penugasan_driver.tgl_penugasan = '$service->tgl_jpt' AND tb_penugasan_driver.status_penugasan = 'p')
                ORDER BY tb_kendaraan.id_kendaraan DESC"
            );
            $driver = DB::select(
                "SELECT tb_driver.id_driver, tb_driver.no_badge, tb_driver.nama_driver FROM tb_driver
                -- LEFT JOIN tb_detail_sim on tb_detail_sim.id_driver = tb_driver.id_driver
                WHERE tb_driver.status_driver = 'y'
                AND NOT EXISTS (SELECT id_driver FROM tb_status_driver WHERE tb_status_driver.id_driver = tb_driver.id_driver
                AND tb_status_driver.status = 'n' UNION SELECT id_driver FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_driver = tb_driver.id_driver
                AND tb_penugasan_driver.tgl_penugasan = ' $service->tgl_jpt' AND tb_penugasan_driver.status_penugasan = 'p'  )"
            );
            $data = [
                'so' => $service,
                'kendaraan' => $kendaraan,
                'driver' => $driver
            ];
            // return $data;
            return view('dashboard.main.serviceorder.accept', $data);
        } else {
            return abort(404);
        }
    }

    public function selectDriver(Request $request)
    {

        // $id =  $request->get('id_so');
        // $id_sim = $request->get('id_sim');
        // $service = DB::table('tb_order_kendaraan')
        //     ->select(
        //         'tb_order_kendaraan.id_service_order as id_so',
        //         'tb_order_kendaraan.tgl_penjemputan as tgl_jpt',
        //         'tb_order_kendaraan.jam_penjemputan as jam_jmp',
        //     )
        //     ->where('id_service_order', $id)
        //     ->first();

        // $driver = DB::select(
        //     "SELECT tb_driver.id_driver, tb_driver.nama_driver FROM tb_driver
        //     LEFT JOIN tb_detail_sim on tb_detail_sim.id_driver = tb_driver.id_driver
        //     WHERE tb_driver.status_driver = 'y' AND tb_detail_sim.id_jenis_sim = '$id_sim'
        //     AND NOT EXISTS (SELECT id_driver FROM tb_status_driver WHERE tb_status_driver.id_driver = tb_driver.id_driver
        //     AND tb_status_driver.status = 'n' UNION SELECT id_driver FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_driver = tb_driver.id_driver
        //     AND tb_penugasan_driver.tgl_penugasan = ' $service->tgl_jpt' )"
        // );
        // return response()->json($driver);
        $tgl_jpt = $request->get('tgl_penjemputan');
        $kendaraan =  DB::select(
            "SELECT tb_kendaraan.nama_kendaraan,
            tb_kendaraan.kode_asset,
            tb_kendaraan.no_polisi,
            tb_kendaraan.id_kendaraan,
            tb_kendaraan.id_jenis_sim,
            -- tb_jenis_sim.nama_sim as sim,
            tb_jenis_alokasi.nama_alokasi as alokasi
            FROM tb_kendaraan
            -- JOIN tb_jenis_sim on tb_jenis_sim.id_jenis_sim = tb_kendaraan.id_jenis_sim
            LEFT JOIN tb_alokasi_kendaraan on tb_alokasi_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan
            LEFT JOIN tb_jenis_alokasi on tb_jenis_alokasi.id_jenis_alokasi = tb_alokasi_kendaraan.id_jenis_alokasi
            WHERE tb_kendaraan.status = 'y' AND NOT EXISTS (SELECT id_kendaraan FROM tb_pengecekan_kendaraan WHERE tb_pengecekan_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan
            AND tb_pengecekan_kendaraan.status_kendaraan = 't' AND tb_pengecekan_kendaraan.tgl_pengecekan = '$tgl_jpt' UNION SELECT id_kendaraan FROM tb_penugasan_driver
            WHERE tb_penugasan_driver.id_kendaraan = tb_kendaraan.id_kendaraan
            AND tb_penugasan_driver.tgl_penugasan = '$tgl_jpt' AND tb_penugasan_driver.status_penugasan = 'p')
            ORDER BY tb_kendaraan.id_kendaraan DESC"
        );
        $driver = DB::select(
            "SELECT tb_driver.id_driver, tb_driver.no_badge, tb_driver.nama_driver FROM tb_driver
            -- LEFT JOIN tb_detail_sim on tb_detail_sim.id_driver = tb_driver.id_driver
            WHERE tb_driver.status_driver = 'y'
            AND NOT EXISTS (SELECT id_driver FROM tb_status_driver WHERE tb_status_driver.id_driver = tb_driver.id_driver
            AND tb_status_driver.status = 'n' UNION SELECT id_driver FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_driver = tb_driver.id_driver
            AND tb_penugasan_driver.tgl_penugasan = ' $tgl_jpt' AND tb_penugasan_driver.status_penugasan = 'p'  )"
        );
        if ($driver == null) {
            return $data = [
                'Success' => false,
                'Message' => 'Tidak ada Driver'
            ];
        } else {
            return $data = [
                'Success' => true,
                'Message' => '',
                'Kendaraan' => $kendaraan,
                'Driver' => $driver
            ];
        }
    }

    public function acceptSo(Request $request, $id)
    {
        $find = ServiceOrder::where('id_service_order', $id)->first();
        if ($find == true) {
            $find->update(['status_so' => 't']);
            $data = [
                'id_service_order'  => $find->id_service_order,
                'id_driver'         => $request->id_driver,
                'id_kendaraan'      => $request->id_kendaraan,
                'id_petugas'        => $find->id_petugas,
                'tgl_penugasan'     => Carbon::parse($find->tgl_penjemputan)->format('Y-m-d'),
                'jam_berangkat'     => Carbon::parse($find->jam_penjemputan)->format('H:i:s'),
                'kembali'           => $request->kembali,
                'tgl_acc'           => date('Y-m-d')
            ];
            $penugasancreate = DB::table('tb_penugasan_driver')->insert($data);
            $findDriver = Driver::select('id_driver', 'player_id')->where('id_driver', $request->id_driver)->first();
            $msg =  [
                'title' => 'Penugasan Baru',
                'body' => 'Anda memiliki penugasan baru, segera cek aplikasi mobil penugasan!'
            ];
            $data = [
                'to' => $findDriver->player_id, // for single device id
                'notification' => $msg
            ];
            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . env('SERVER_API_KEY'),
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);

            curl_close($ch);
            if ($penugasancreate) {
                return redirect()->route('checking.serviceorder')->with('success', 'Penugasan Driver Berhasil Dibuat');
            } else {
                return redirect()->route('checking.serviceorder')->with('success', 'Penugasan Driver Gagal Dibuat');
            }
        } else {
            return redirect()->route('checking.serviceorder')->with('success', 'Dispath Order Driver Tidak Ditemukan');
        }
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

    public function cancelSo($id_so)
    {
        $cancelSo = ServiceOrder::where('id_service_order', $id_so)->first();
        if ($cancelSo == true) {
            $cancelSo->update(['status_so' => 'c']);
            $findDo = PenugasanDriver::where('id_service_order', $id_so)->first();
            $cancelDo = $findDo->update(['status_penugasan' => 'c']);
            return redirect()->route('checking.serviceorder')->with('success', 'Penugasan dengan SO_' . $cancelSo->no_so . ' berhasil dibatalkan');
        } else {
            return redirect()->route('checking.serviceorder')->with('success', 'Pembatalan gagal diproses');
        }
    }

    public function formSo(Request $request)
    {
        $data['last_so'] = DB::table('tb_order_kendaraan')
            ->select('id_service_order', 'no_so')
            ->orderByDesc('id_service_order')->first();
        if ($data['last_so'] == false) {
            $data['last_so'] = (object) array(
                'id_service_order' => 0,
                'no_so' => 0
            );
        }
        // dd($data);
        return view('dashboard.main.serviceorder.create2', $data);
    }

    public function createSo(Request $request)
    {
        // dd($request->all());
        $so = [
            'id_service_order'  => $request->id_service_order,
            'id_petugas'        => Auth::user()->id_petugas,
            'no_so'             => $request->no_so,
            'tgl_penjemputan'   => Carbon::parse($request->tgl_penjemputan)->format('Y-m-d'),
            'jam_penjemputan'   => Carbon::parse($request->jam_penjemputan)->format('H:i'),
            'jml_penumpang'     => $request->jml_penumpang,
            'tempat_penjemputan' => $request->tmp_penjemputan,
            'tujuan'            => $request->tmp_tujuan,
            'keterangan'        => $request->agenda,
            'status_so'         => 't'
        ];

        $saveSo = ServiceOrder::create($so);
        if ($saveSo) {
            $do = [
                'id_service_order'  => $request->id_service_order,
                'id_driver'         => $request->id_driver,
                'id_kendaraan'      => $request->id_kendaraan,
                'id_petugas'        => Auth::user()->id_petugas,
                'tgl_penugasan'     => Carbon::parse($request->tgl_penjemputan)->format('Y-m-d'),
                'jam_berangkat'     => Carbon::parse($request->jam_penjemputan)->format('H:i'),
                'kembali'           => $request->tmp_kembali,
                'tgl_acc'           => date('Y-m-d')
            ];
            $penugasancreate = PenugasanDriver::create($do);
            if ($penugasancreate) {
                $findDriver = Driver::select('id_driver', 'player_id')->where('id_driver', $request->id_driver)->first();
                $content = array(
                    "en" => 'Anda Mempunyai Penugasan Baru!'
                );

                $fields = array(
                    'app_id' => "768c8998-943b-4ffa-8829-07c1107a9216",
                    'include_player_ids' => array("$findDriver->player_id"),
                    'data' => array("foo" => "bar"),
                    'contents' => $content
                );

                $fields = json_encode($fields);
                // print("\nJSON sent:\n");
                // print($fields);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                $response = curl_exec($ch);
                curl_close($ch);

                $number = 0;
                foreach ($request->nama_penumpang as $key => $penumpang) {
                    if (isset($request->status[$key])) {
                        $status = 'n';
                    } else {
                        $status = 'y';
                    }
                    $serviceDetail = [
                        'id_service_order'  => $request->id_service_order,
                        'jabatan'           => $request->jbtn_penumpang[$key],
                        'nama_penumpang'    => $request->nama_penumpang[$key],
                        'no_tlp'            => $request->no_tlp[$key],
                        'status'            => $status
                    ];
                    $number++;
                    $saveDetailSo = ServiceOrderDetail::create($serviceDetail);
                }
            } else {
                $findSo = ServiceOrder::where('id_service_order',  $request->id_service_order)->first();
                if ($findSo) {
                    $findSo->delete();
                }
                return redirect()->route('checking.serviceorder')->with('success', 'Penugasan dengan gagal dibuat');
            }
            return redirect()->route('checking.serviceorder')->with('success', 'Penugasan dengan berhasil dibuat');
        } else {
            return redirect()->route('checking.serviceorder')->with('success', 'Penugasan dengan gagal dibuat');
        }
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
