<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Kecelakaan;
use App\Models\KecelakaanFoto;
use App\Models\KriteriaPengecekan;
use App\Models\PengecekanKendaraan;
use App\Models\PenugasanBatal;
use App\Models\PenugasanDriver;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApiServiceOrderController extends Controller
{


    public function formSo(Request $request)
    {
        $tgl_jemput = $request->query('tgl_jemput');
        $kendaraan =  DB::select(
            "SELECT
            tb_kendaraan.id_kendaraan,
            tb_kendaraan.nama_kendaraan,
            tb_kendaraan.kode_asset,
            tb_kendaraan.no_polisi,
            -- tb_jenis_sim.nama_sim as sim,
            tb_jenis_alokasi.nama_alokasi as alokasi
            FROM tb_kendaraan
            -- JOIN tb_jenis_sim on tb_jenis_sim.id_jenis_sim = tb_kendaraan.id_jenis_sim
            LEFT JOIN tb_alokasi_kendaraan on tb_alokasi_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan
            LEFT JOIN tb_jenis_alokasi on tb_jenis_alokasi.id_jenis_alokasi = tb_alokasi_kendaraan.id_jenis_alokasi
            WHERE tb_kendaraan.status = 'y' AND NOT EXISTS (SELECT id_kendaraan FROM tb_pengecekan_kendaraan WHERE tb_pengecekan_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan
            AND tb_pengecekan_kendaraan.status_kendaraan = 't' AND tb_pengecekan_kendaraan.tgl_pengecekan = '$tgl_jemput' UNION SELECT id_kendaraan FROM tb_penugasan_driver
            WHERE tb_penugasan_driver.id_kendaraan = tb_kendaraan.id_kendaraan
            AND tb_penugasan_driver.tgl_penugasan = '$tgl_jemput' AND tb_penugasan_driver.status_penugasan = 'p')
            ORDER BY tb_kendaraan.id_kendaraan DESC"
        );
        $driver = DB::select(
            "SELECT tb_driver.id_driver, tb_driver.no_badge, tb_driver.nama_driver FROM tb_driver
            -- LEFT JOIN tb_detail_sim on tb_detail_sim.id_driver = tb_driver.id_driver
            WHERE tb_driver.status_driver = 'y'
            AND NOT EXISTS (SELECT id_driver FROM tb_status_driver
            WHERE tb_status_driver.id_driver = tb_driver.id_driver
            AND tb_status_driver.status = 'n'
            -- AND tb_status_driver.tgl_nonaktif = '$tgl_jemput'
            UNION SELECT id_driver FROM tb_penugasan_driver
            WHERE tb_penugasan_driver.id_driver = tb_driver.id_driver
            AND tb_penugasan_driver.tgl_penugasan = ' $tgl_jemput'
            AND tb_penugasan_driver.status_penugasan = 'p'  )"
        );

        return response()->json(
            [
                'status'        => 'sukses',
                'list_kendaraan' => $kendaraan,
                'list_driver'    => $driver
            ]
        );
    }

    public function createSo(Request $request)
    {
        DB::beginTransaction();
        try {
            $so = [
                'id_service_order'  => $request->id_service_order,
                'id_petugas'        => $request->id_petugas,
                'no_so'             => $request->no_so,
                'tgl_penjemputan'   => Carbon::parse($request->tgl_penjemputan)->format('Y-m-d'),
                'jam_penjemputan'   => Carbon::parse($request->jam_penjemputan)->format('H:i:s'),
                'jml_penumpang'     => $request->jml_penumpang,
                'tempat_penjemputan' => $request->tempat_penjemputan,
                'tujuan'            => $request->tujuan,
                'keterangan'        => $request->keterangan,
                'status_so'         => 't'
            ];
            // $saveSo = DB::table('tb_order_kendaraan')->insert($so);
            $saveSo = ServiceOrder::create($so);
            $do = [
                'id_service_order'  => $request->id_service_order,
                'id_driver'         => $request->id_driver,
                'id_kendaraan'      => $request->id_kendaraan,
                'id_petugas'        => $request->id_petugas,
                'tgl_penugasan'     => Carbon::parse($request->tgl_penjemputan)->format('Y-m-d'),
                'jam_berangkat'     => Carbon::parse($request->jam_penjemputan)->format('H:i:s'),
                'kembali'           => $request->kembali,
                'tgl_acc'           => date('Y-m-d')
            ];
            $penugasancreate = DB::table('tb_penugasan_driver')->insert($do);
            $findDriver = Driver::select('id_driver', 'player_id')->where('id_driver', $request->id_driver)->first();
            $SERVER_API_KEY = env('SERVER_API_KEY');

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
                'Authorization: key=' . $SERVER_API_KEY,
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
            // return $response;
            $namaPenumpang = $request->nama_penumpang;
            foreach ($namaPenumpang as $key => $value) {
                $serviceDetail = [
                    'id_service_order'  => $request->id_service_order,
                    'jabatan'        => $request->jabatan[$key],
                    'nama_penumpang'    => $request->nama_penumpang[$key],
                    'no_tlp'            => $request->no_tlp[$key],
                    'status'            => $request->status[$key]
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
                    // 'errors' => $exception
                ],
                400
            );
        }
    }

    public function getLastIdDo(Request $request)
    {
        $latestId = DB::table('tb_order_kendaraan')
            ->select('id_service_order', 'no_so')
            ->orderByDesc('id_service_order')
            ->first();

        if ($latestId != '') {
            return response()->json(
                $latestId
            );
        } else {
            return response()->json(
                [
                    'id_service_order' => 'kosong',
                    'no_so'            => 'kosong'
                ]
            );
        }
    }

    public function getJabatan(Request $request)
    {
        $listJabatan = DB::table('tb_jabatan')
            ->select('id_jabatan', 'nama_jabatan')
            ->where('status', 'y')
            ->get();
        if ($listJabatan->count() > 0) {
            return response()->json(
                [
                    'status' => 'sukses',
                    'list_jabatan' => $listJabatan
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'gagal',
                    'list_jabatan' => $listJabatan
                ]
            );
        }
    }

    public function getDo(Request $request)
    {
        $id = $request->query('id');
        $tab = $request->query('tab');
        $serviceOrder = DB::table('tb_order_kendaraan')
            ->select(
                'tb_order_kendaraan.id_service_order',
                'tb_penugasan_driver.id_do',
                'tb_order_kendaraan.no_so',
                'tb_order_kendaraan.tgl_penjemputan',
                'tb_order_kendaraan.jam_penjemputan',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_order_kendaraan.status_so',
                'tb_penugasan_driver.status_penugasan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                // 'tb_petugas.nama_lengkap',
                // 'tb_petugas.foto_petugas'
                'tb_driver.nama_driver',
                'tb_driver.foto_driver',
                'tb_driver.no_tlp',
            )
            ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_service_order', 'tb_order_kendaraan.id_service_order')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', 'tb_penugasan_driver.id_kendaraan')
            ->join('tb_driver', 'tb_driver.id_driver', 'tb_penugasan_driver.id_driver')
            // ->where('tb_order_kendaraan.id_petugas', $id)
            ->when($tab == '', function ($status) use ($tab, $id) {
                $status
                    ->where([['tb_order_kendaraan.id_petugas', $id], ['tb_order_kendaraan.status_so', 't'], ['tb_penugasan_driver.status_penugasan', null]]);
                // ->where('status_so', null);
            })
            ->when($tab == 'terima', function ($status) use ($tab, $id) {
                $status
                    ->where([['tb_order_kendaraan.id_petugas', $id], ['tb_order_kendaraan.status_so', 't'], ['tb_penugasan_driver.status_penugasan', 't']]);
                // ->where('status_so', 't');
            })
            ->when($tab == 'proses', function ($status) use ($tab, $id) {
                $status
                    ->where([['tb_order_kendaraan.id_petugas', $id], ['tb_order_kendaraan.status_so', 't'], ['tb_penugasan_driver.status_penugasan', 'p']]);
                // ->where('status_so', 'tl');
            })
            // ->when($tab == 'c', function ($status) use ($tab) {
            //     $status->where('status_so', 'c');
            // })
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'service_order' => $serviceOrder
            ]
        );
    }

    public function cancelDo(Request $request)
    {
        $id_petugas = $request->id_petugas;
        $id_so = $request->id_so;
        $cancelSo = ServiceOrder::where([['id_service_order', $id_so], ['id_petugas', $id_petugas]])->first();
        if ($cancelSo == true) {
            $cancelSo->update(['status_so' => 'c']);
            $findDo = PenugasanDriver::where('id_service_order', $id_so)->first();
            $cancelDo = $findDo->update(['status_penugasan' => 'c']);
            return response()->json(
                [
                    'status'        => 'sukses',
                    'status_so' => $cancelSo->status_so,
                    'status_penugasan' => $findDo->status_penugasan
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal'
                ]
            );
        }
    }

    public function getDoDetail(Request $request)
    {
        $id_so = $request->query('id_so');
        $detailAccepted = DB::table('tb_order_kendaraan')
            ->select(
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.no_so',
                'tb_order_kendaraan.tgl_penjemputan',
                'tb_order_kendaraan.jam_penjemputan',
                'tb_order_kendaraan.jml_penumpang',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_order_kendaraan.keterangan',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_driver.nama_driver',
                'tb_driver.foto_driver',
                'tb_driver.no_tlp',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
            )
            ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_service_order', '=', 'tb_order_kendaraan.id_service_order')
            ->join('tb_driver', 'tb_penugasan_driver.id_driver', '=', 'tb_driver.id_driver')
            ->join('tb_kendaraan', 'tb_penugasan_driver.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->join('tb_petugas', 'tb_order_kendaraan.id_petugas', '=', 'tb_petugas.id_petugas')
            ->where('tb_order_kendaraan.id_service_order', $id_so)
            ->first();
        if ($detailAccepted) {
            $penumpang = DB::table('tb_detail_so')
                ->select(
                    'nama_penumpang',
                    'jabatan',
                    'no_tlp'
                )
                ->join('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_detail_so.id_service_order')
                ->where('tb_detail_so.id_service_order', $detailAccepted->id_service_order)
                ->get();
            return response()->json(
                [
                    'status'    => 'sukses',
                    'detail'    => $detailAccepted,
                    'penumpang' => $penumpang
                ]
            );
        } else {
            return response()->json(
                [
                    'status'    => 'gagal'
                ]
            );
        }
    }

    public function listHistory(Request $request)
    {
        $id_petugas = $request->query('id_petugas');
        $status = $request->query('status'); //selesai //batal
        $tgl = $request->query('tanggal');
        $history = DB::table('tb_order_kendaraan')
            ->select(
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.no_so',
                'tb_order_kendaraan.tgl_penjemputan',
                'tb_order_kendaraan.jam_penjemputan',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_order_kendaraan.status_so',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_driver.nama_driver',
                'tb_driver.no_tlp as tlp_driver',
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.tgl_selesai',
                'tb_penugasan_driver.status_penugasan',
                'tb_detail_so.nama_penumpang',
                'tb_detail_so.no_tlp',
                'tb_detail_so.status',
                DB::raw('COUNT(tb_rating_driver.id_do) as rating')
            )
            // ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', 'tb_order_kendaraan.id_petugas')
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_service_order', 'tb_order_kendaraan.id_service_order')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_detail_so', 'tb_detail_so.id_service_order', '=', 'tb_order_kendaraan.id_service_order')
            ->leftJoin('tb_rating_driver', 'tb_rating_driver.id_do', '=', 'tb_penugasan_driver.id_do')
            ->groupByRaw(
                'tb_order_kendaraan.id_service_order,
                tb_order_kendaraan.no_so,
                tb_order_kendaraan.tgl_penjemputan,
                tb_order_kendaraan.jam_penjemputan,
                tb_order_kendaraan.tempat_penjemputan,
                tb_order_kendaraan.tujuan,
                tb_penugasan_driver.kembali,
                tb_order_kendaraan.status_so,
                tb_kendaraan.nama_kendaraan,
                tb_kendaraan.no_polisi,
                tb_driver.nama_driver,
                tb_driver.no_tlp,
                tb_penugasan_driver.id_do,
                tb_penugasan_driver.tgl_selesai,
                tb_penugasan_driver.status_penugasan,
                tb_detail_so.nama_penumpang,
                tb_detail_so.no_tlp,
                tb_detail_so.status'
            )
            ->orderBy(DB::raw('COUNT(tb_rating_driver.id_do)'))
            ->when($status == 'selesai', function ($find) use ($id_petugas, $tgl) {
                $find->when($tgl != '', function ($filter) use ($tgl) {
                    $filter->where('tb_order_kendaraan.tgl_penjemputan', $tgl);
                })
                    ->where([
                        ['tb_order_kendaraan.id_petugas', $id_petugas], ['tb_order_kendaraan.status_so', 't'],
                        ['tb_penugasan_driver.status_penugasan', 's'], ['tb_detail_so.status', 'y']
                    ]);
            })
            ->when($status == 'batal', function ($find) use ($id_petugas, $tgl) {
                $find->when($tgl != '', function ($filter) use ($tgl) {
                    $filter->where('tb_order_kendaraan.tgl_penjemputan', $tgl);
                })
                    ->where([
                        ['tb_order_kendaraan.id_petugas', $id_petugas], ['tb_order_kendaraan.status_so', 'c'],
                        ['tb_penugasan_driver.status_penugasan', 'c'], ['tb_detail_so.status', 'y']
                    ]);
            })
            ->get()
            ->map(function ($list) {
                return [
                    'id_service_order' => $list->id_service_order,
                    'no_so' => $list->no_so,
                    'tgl_penjemputan' => $list->tgl_penjemputan,
                    'jam_penjemputan' => $list->jam_penjemputan,
                    'tempat_penjemputan' => $list->tempat_penjemputan,
                    'tujuan' => $list->tujuan,
                    'kembali' => $list->kembali,
                    'status_so' => $list->status_so,
                    'nama_kendaraan' => $list->nama_kendaraan,
                    'no_polisi' => $list->no_polisi,
                    'nama_driver' => $list->nama_driver,
                    'url' => 'https://api.whatsapp.com/send?phone=' . $list->no_tlp . '&text=Halo%20*'
                        . $list->nama_penumpang . '*%0ASilahkan%20berikan%20rating%20untuk%20driver%20dalam%20perjalanan%20anda%0ADriver%20:%20*'
                        . $list->nama_driver . '*%0AKontak%20:%20*'
                        . $list->tlp_driver . '*%0Aklik%20link%20dibawah%20ini%0A([' . route(
                            'rating.insert',
                            $list->id_do . '?no_tlp=' . $list->no_tlp
                        ) . '%0ATerimakasih%0A*PT.Pomi*',
                    'rating' => $list->rating
                ];
            });
        // $history = DB::table('tb_order_kendaraan')
        //     ->select(
        //         'tb_order_kendaraan.id_service_order',
        //         'tb_order_kendaraan.no_so',
        //         'tb_order_kendaraan.tgl_penjemputan',
        //         'tb_order_kendaraan.jam_penjemputan',
        //         'tb_order_kendaraan.tempat_penjemputan',
        //         'tb_order_kendaraan.tujuan',
        //         'tb_penugasan_driver.kembali',
        //         'tb_order_kendaraan.status_so',
        //         'tb_kendaraan.nama_kendaraan',
        //         'tb_kendaraan.no_polisi',
        //         // 'tb_petugas.nama_lengkap',
        //         // 'tb_petugas.foto_petugas'
        //         'tb_driver.nama_driver'
        //     )
        //     // ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', 'tb_order_kendaraan.id_petugas')
        //     ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_service_order', 'tb_order_kendaraan.id_service_order')
        //     ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', 'tb_penugasan_driver.id_kendaraan')
        //     ->join('tb_driver', 'tb_driver.id_driver', 'tb_penugasan_driver.id_driver')
        //     ->when($status == 'selesai', function ($find) use ($id_petugas, $tgl) {
        //         $find->when($tgl != '', function ($filter) use ($tgl) {
        //             $filter->where('tb_order_kendaraan.tgl_penjemputan', $tgl);
        //         })
        //             ->where([['tb_order_kendaraan.id_petugas', $id_petugas], ['tb_order_kendaraan.status_so', 't'], ['tb_penugasan_driver.status_penugasan', 's']]);
        //     })
        //     ->when($status == 'batal', function ($find) use ($id_petugas, $tgl) {
        //         $find->when($tgl != '', function ($filter) use ($tgl) {
        //             $filter->where('tb_order_kendaraan.tgl_penjemputan', $tgl);
        //         })
        //             ->where([['tb_order_kendaraan.id_petugas', $id_petugas], ['tb_order_kendaraan.status_so', 'c'], ['tb_penugasan_driver.status_penugasan', 'c']]);
        //     })
        //     ->get();
        return response()->json(
            [
                'status' => 'sukses',
                'history' => $history
            ]
        );
    }

    public function listPembatalan(Request $request)
    {
        $batal = DB::table('tb_pembatalan_penugasan')
            ->select(
                'tb_pembatalan_penugasan.id_pembatalan',
                'tb_pembatalan_penugasan.id_do',
                'tb_pembatalan_penugasan.id_driver',
                'tb_pembatalan_penugasan.tanggal',
                'tb_pembatalan_penugasan.alasan_pembatalan as alasan',
                'tb_pembatalan_penugasan.status_pembatalan',
                'tb_driver.nama_driver',
                'tb_driver.no_tlp',
                'tb_driver.foto_driver',
                'tb_departemen.nama_departemen as departemen',
                'tb_order_kendaraan.no_so'
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pembatalan_penugasan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_pembatalan_penugasan.id_driver')
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_pembatalan_penugasan.status_pembatalan', null)
            ->orderByDesc('tb_pembatalan_penugasan.id_pembatalan')
            ->get();
        return response()->json(
            [
                'status' => 'sukses',
                'pembatalan' => $batal
            ]
        );
    }

    public function detailPembatalan(Request $request)
    {
        $id_batal = $request->query('id_batal');
        $batal = DB::table('tb_pembatalan_penugasan')
            ->select(
                'tb_pembatalan_penugasan.id_pembatalan',
                'tb_pembatalan_penugasan.id_do',
                'tb_pembatalan_penugasan.id_driver',
                'tb_pembatalan_penugasan.tanggal',
                'tb_pembatalan_penugasan.alasan_pembatalan as alasan',
                'tb_pembatalan_penugasan.status_pembatalan',
                'tb_pembatalan_penugasan.bukti',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_driver.nama_driver',
                'tb_driver.no_tlp',
                'tb_driver.foto_driver',
                'tb_departemen.nama_departemen as departemen',
                'tb_order_kendaraan.no_so'
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pembatalan_penugasan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_pembatalan_penugasan.id_driver')
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_pembatalan_penugasan.id_pembatalan', $id_batal)
            ->first();
        if ($batal) {
            $drivers = DB::select(
                "SELECT tb_driver.id_driver, tb_driver.no_badge, tb_driver.nama_driver FROM tb_driver
                -- LEFT JOIN tb_detail_sim on tb_detail_sim.id_driver = tb_driver.id_driver
                WHERE tb_driver.status_driver = 'y'
                AND NOT EXISTS (SELECT id_driver FROM tb_status_driver WHERE tb_status_driver.id_driver = tb_driver.id_driver
                AND tb_status_driver.status = 'n' UNION SELECT id_driver FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_driver = tb_driver.id_driver
                AND tb_penugasan_driver.tgl_penugasan = '$batal->tgl_penugasan' AND tb_penugasan_driver.status_penugasan = 'p'  )"
            );
            return response()->json(
                [
                    'status' => 'sukses',
                    'detail' => $batal,
                    'list_driver' => $drivers
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'gagal'
                ]
            );
        }
    }

    public function terimaPembatalan(Request $request)
    {
        $id_batal = $request->id_batal;
        $id_do = $request->id_do;
        $id_driver_baru = $request->id_driver_baru;

        $find = PenugasanBatal::where('id_pembatalan', $id_batal)->first();
        if ($find) {
            $find->update(['status_pembatalan' => 't']);
            $find_do = PenugasanDriver::where('id_do', $id_do)->first();
            $data = [
                'id_driver' => $id_driver_baru
            ];
            $find_do->update($data);
            return response()->json(
                [
                    'status' => 'sukses',
                    'id_batal' => $find->id_pembatalan,
                    'status_batal' => $find->status_pembatalan
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'gagal'
                ]
            );
        }
    }

    public function tolakPembatalan(Request $request)
    {
        $id_batal = $request->id_batal;
        $find = PenugasanBatal::where('id_pembatalan', $id_batal)->first();
        if ($find) {
            // return $find;
            $find->update(['status_pembatalan' => 'tl']);
            return response()->json(
                [
                    'status' => 'sukses',
                    'id_batal' => $find->id_pembatalan,
                    'status_batal' => $find->status_pembatalan
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'gagal'
                ]
            );
        }
    }

    public function listDriverActive(Request $request)
    {
        $tgl = $request->query('tgl_penugasan');
        $drivers = DB::select(
            "SELECT tb_driver.id_driver, tb_driver.no_badge, tb_driver.nama_driver FROM tb_driver
            -- LEFT JOIN tb_detail_sim on tb_detail_sim.id_driver = tb_driver.id_driver
            WHERE tb_driver.status_driver = 'y'
            AND NOT EXISTS (SELECT id_driver FROM tb_status_driver WHERE tb_status_driver.id_driver = tb_driver.id_driver
            AND tb_status_driver.status = 'n' UNION SELECT id_driver FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_driver = tb_driver.id_driver
            AND tb_penugasan_driver.tgl_penugasan = '$tgl' AND tb_penugasan_driver.status_penugasan = 'p'  )"
        );
        return response()->json(
            [
                'status' => 'sukses',
                'list_driver' => $drivers
            ]
        );
    }

    public function changeDriver(Request $request)
    {
        $id_do = $request->id_do;
        $id_driver = $request->id_driver;
        $find = PenugasanDriver::where('id_do', $id_do)->first();
        if ($find) {
            $data = [
                'id_driver' => $id_driver,
                'status_penugasan' => null
            ];
            $find->update($data);
            return response()->json(
                [
                    'status' => 'sukses',
                    'pesan' => 'driver berhasil diganti'
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'gagal'
                ]
            );
        }
    }

    //kecelakaan
    public function listTransport(Request $request)
    {
        $id = $request->query('id');
        $kendaraan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_petugas',
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
            ->where('tb_penugasan_driver.id_petugas', $id)
            ->where('tb_penugasan_driver.status_penugasan', '!=', 's')
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'cek_kendaraan' => $kendaraan
            ]
        );
    }

    public function accidentReport(Request $request)
    {
        $id_petugas = $request->query('id_petugas');
        $id_do = $request->query('id_do');
        $detail_report = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_petugas',
                'tb_petugas.nama_lengkap as nama_petugas',
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
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->orderByDesc('id_do')
            ->where([['tb_penugasan_driver.id_petugas', $id_petugas], ['tb_penugasan_driver.id_do', $id_do]])
            ->first();
        if ($detail_report != null) {
            return response()->json(
                [
                    'status'        => 'sukses',
                    'cek_kendaraan' => $detail_report
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'cek_kendaraan' => 'kosong'
                ]
            );
        }
    }

    public function accidentPictureStore(Request $request)
    {
        $foto_pendukung = $request->file('foto');
        if ($foto_pendukung != null) {
            $name = 'accident_' . uniqid() . '.' . $foto_pendukung->getClientOriginalExtension();
            $data = [
                'foto_pendukung' => $name,
                'keterangan' => $request->keterangan
            ];
            $simpan = KecelakaanFoto::create($data);
            if ($simpan) {
                $folder_accident = 'assets/img_accident';
                $foto_pendukung->move($folder_accident, $name);
                return response()->json(
                    [
                        'status'         => 'sukses',
                        'id_foto'       => $simpan->id_detail_foto
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'status'         => 'gagal'
                ]
            );
        }
    }

    public function accidentPictureUpdate(Request $request)
    {
        $id_foto = $request->id_foto;
        $find = KecelakaanFoto::where('id_detail_foto', $id_foto)->first();
        if (!is_null($find->foto_pendukung)) {
            File::delete('assets/img_accident/' . $find->foto_pendukung);
        }
        $foto_pendukung = $request->file('foto');
        $name = 'accident_' . uniqid() . '.' . $foto_pendukung->getClientOriginalExtension();

        $data = [
            'foto_pendukung' => $name
        ];
        $update = $find->update($data);
        if ($update) {
            $folder_accident = 'assets/img_accident';
            $foto_pendukung->move($folder_accident, $name);
            return response()->json(
                [
                    'status'         => 'sukses',
                    'id_foto'       => $find->id_detail_foto
                ]
            );
        } else {
            return response()->json(
                [
                    'status'         => 'gagal'
                ]
            );
        }
    }

    public function accidentPictureDelete(Request $request)
    {
        $id_foto = $request->id_foto;
        $find = KecelakaanFoto::where('id_detail_foto', $id_foto)->first();
        if ($find) {
            if (!is_null($find->foto_pendukung)) {
                File::delete('assets/img_accident/' . $find->foto_pendukung);
            }
            $find->delete();
            return response()->json(
                [
                    'status'         => 'sukses',
                    'pesan'       => 'data terhapus'
                ]
            );
        } else {
            return response()->json(
                [
                    'status'         => 'gagal',
                    'pesan'          => 'data tidak ada'
                ]
            );
        }
    }

    public function accidentCancel(Request $request)
    {
        $find = KecelakaanFoto::where('id_kecelakaan', null)->get();

        if ($find->count() > 0) {
            $find->each(function ($file, $key) {
                File::delete('assets/img_accident/' . $file->foto_pendukung);
                $file->delete();
            });
            return response()->json(
                [
                    'status'         => 'sukses',
                    'pesan'       => 'data terhapus'
                ]
            );
        } else {
            return response()->json(
                [
                    'status'         => 'gagal',
                    'pesan'       => 'data tidak ada'
                ]
            );
        }
    }

    public function accidentReportStoreOld(Request $request)
    {
        DB::beginTransaction();
        try {
            //code...
            $data = [
                'id_do' => $request->id_do,
                'tgl_kecelakaan' => Carbon::parse($request->tgl_kecelakaan)->format('Y-m-d'),
                'jam_kecelakaan' => Carbon::parse($request->jam_kecelakaan)->format('H:i:s'),
                'lokasi_kejadian' => $request->lokasi_kejadian,
                'kronologi' => $request->kronologi
            ];
            $saveAcd = Kecelakaan::create($data);
            $file = [$request->file('file')];
            foreach ($file as $key => $value) {
                foreach ($request->file as $key => $file) {
                    $name = 'accident_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move('assets/img_accident', $name);
                    $detailFoto = [
                        'id_kecelakaan' => $saveAcd->id_kecelakaan,
                        'foto_pendukung' => $name,
                        'keterangan' => $request->keterangan[$key]
                    ];
                    $saveDetailfoto = DB::table('tb_detail_foto_kecelakaan')->insert($detailFoto);
                }
            }
            DB::commit();
            return response()->json(
                [
                    'pesan'         => 'sukses',
                    'id_kecelakaan' => $saveAcd->id_kecelakaan
                ]
            );
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            return response()->json(
                [
                    'pesan' => 'gagal',
                    'errors' => $exception
                ]
            );
        }
    }

    public function accidentReportStoreNew(Request $request)
    {
        DB::beginTransaction();
        try {
            //code...
            $data = [
                'id_do' => $request->id_do,
                'tgl_kecelakaan' => Carbon::parse($request->tgl_kecelakaan)->format('Y-m-d'),
                'jam_kecelakaan' => Carbon::parse($request->jam_kecelakaan)->format('H:i:s'),
                'lokasi_kejadian' => $request->lokasi_kejadian,
                'kronologi' => $request->kronologi
            ];
            $saveAcd = Kecelakaan::create($data);
            if ($saveAcd) {
                $findfoto = KecelakaanFoto::where('id_kecelakaan', null)->get();
                if ($findfoto->count() > 0) {
                    $findfoto->each(function ($file, $key) use ($saveAcd) {
                        $file->update(array('id_kecelakaan' => $saveAcd->id_kecelakaan));
                    });
                } else {
                    return response()->json(
                        [
                            'status'         => 'gagal',
                            'pesan' => 'input minimal 1 foto'
                        ]
                    );
                }
            }
            //     $file = [$request->file('file')];
            //     foreach ($file as $key => $value) {
            //         foreach ($request->file as $key => $file) {
            //             $name = 'accident_' . uniqid() . '.' . $file->getClientOriginalExtension();
            //             $file->move('assets/img_accident', $name);
            //             $detailFoto = [
            //                 'id_kecelakaan' => $saveAcd->id_kecelakaan,
            //                 'foto_pendukung' => $name,
            //                 'keterangan' => $request->keterangan[$key]
            //             ];
            //             $saveDetailfoto = DB::table('tb_detail_foto_kecelakaan')->insert($detailFoto);
            //         }
            //     }
            DB::commit();
            return response()->json(
                [
                    'status'         => 'sukses',
                    'id_kecelakaan' => $saveAcd->id_kecelakaan
                ]
            );
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            return response()->json(
                [
                    'status' => 'gagal',
                    'errors' => $exception
                ]
            );
        }
    }

    public function checkinReport(Request $request)
    {
        $awal = DB::table('tb_kriteria_pengecekan')->where('status', 'y')->get();
        $hasil = array();
        foreach ($awal as  $awww) {
            $hasil_awal = array();
            $hasil_awal['id_kriteria'] = $awww->id_kriteria;
            $hasil_awal['nama_kriteria'] = $awww->nama_kriteria;
            $kedua = DB::table('tb_jenis_pengecekan')->where([['id_kriteria', $awww->id_kriteria], ['status', 'y']])->get();
            $hasil_awal['list_jenis'] = array();
            foreach ($kedua as $axx) {
                $hasil_dua = array();
                $hasil_dua['id_pengecekan'] = $axx->id_jenis_pengecekan;
                $hasil_dua['jenis_pengecekan'] = $axx->jenis_pengecekan;
                array_push($hasil_awal['list_jenis'], $hasil_dua);
            }
            array_push($hasil, $hasil_awal);
        }

        return response()->json(
            [
                'status'            => 'sukses',
                'pengecekan'        => $hasil
            ]
        );
    }

    public function checkingReportStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'id_pengecekan'     => $request->id_pengecekan,
                'id_do'             => $request->id_do,
                'id_kendaraan'      => $request->id_kendaraan,
                'tgl_pengecekan'    => $request->tgl_pengecekan,
                'jam_pengecekan'    => Carbon::parse($request->jam_pengecekan)->format('H:i:s'),
                'km_kendaraan'      => $request->km_kendaraan,
                'status_kendaraan'  => $request->status_kendaraan,
                'status_pengecekan' => 'k'
            ];
            if ($request->status_kendaraan == 't') {
                $updateDo = PenugasanDriver::where('id_do', $request->id_do)->update(['status_penugasan' => 's']);
            }
            $saveCo = PengecekanKendaraan::create($data);
            $kondisi = $request->kondisi;
            foreach ($kondisi as $key => $value) {
                $detailCo = [
                    'id_pengecekan'         => $request->id_pengecekan,
                    'id_jenis_pengecekan'   => $request->id_jenis_pengecekan[$key],
                    'kondisi'               => $request->kondisi[$key],
                    'waktu_pengecekan'      => $request->waktu_pengecekan,
                    'keterangan'            => $request->keterangan[$key]
                ];
                $saveDetailCo = DB::table('tb_detail_pengecekan')->insert($detailCo);
            }

            DB::commit();
            return response()->json(
                [
                    'pesan'         => 'sukses',
                    'id_pengecekan' => $request->id_pengecekan
                ]
            );
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            return response()->json(
                [
                    'pesan' => 'gagal',
                    'errors' => $exception
                ]
            );
        }
    }

    //driver

    public function latestDo(Request $request)
    {
        $id_dr = $request->query('id_dr');
        $latestDo = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_petugas.no_tlp',
                'tb_driver.nama_driver',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan',
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_do')
            ->where([['tb_penugasan_driver.id_driver', $id_dr], ['status_penugasan', null]])
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'latest_do'     => $latestDo
            ]
        );
    }

    public function latestDetailDo(Request $request)
    {
        $id_do = $request->query('id_do');
        $latestDetail = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_petugas.no_tlp',
                'tb_driver.nama_driver',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan',
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->join('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->where('id_do', $id_do)
            ->first();

        return response()->json(
            [
                'status'        => 'sukses',
                'latest_detail'     => $latestDetail
            ]
        );
    }

    public function acceptDo(Request $request)
    {
        $id_dr = $request->id_dr;
        $id_do = $request->id_do;
        $acceptDo = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_dr]])->first();
        if ($acceptDo == true) {
            $acceptDo->update(['status_penugasan' => 't']);
            return response()->json(
                [
                    'status'        => 'sukses',
                    'status_penugasan' => $acceptDo->status_penugasan
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal'
                ]
            );
        }
    }

    public function listDo(Request $request)
    {
        $id_dr = $request->query('id_dr');
        $tab = $request->query('tab');
        $listDo = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_petugas.no_tlp',
                'tb_driver.nama_driver',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan',
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->join('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->orderByDesc('id_do')
            ->when($tab == 't', function ($status) use ($tab) {
                $status->where('status_penugasan', 't');
            })
            ->when($tab == 'p', function ($status) use ($tab) {
                $status->where('status_penugasan', 'p');
            })
            ->when($tab == 's', function ($status) use ($tab) {
                $status->where('status_penugasan', 's');
            })
            ->when($tab == 'c', function ($status) use ($tab) {
                $status->where('status_penugasan', 'c');
            })
            ->where([['tb_penugasan_driver.id_driver', $id_dr], ['status_penugasan', '!=', null]])
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'list_do'     => $listDo
            ]
        );
    }

    public function processDo(Request $request)
    {
        $id_dr = $request->id_dr;
        $id_do = $request->id_do;
        $acceptDo = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_dr]])->first();
        if ($acceptDo == true) {
            $acceptDo->update(['status_penugasan' => 'p']);
            return response()->json(
                [
                    'status'        => 'sukses',
                    'status_penugasan' => $acceptDo->status_penugasan
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal'
                ]
            );
        }
    }

    public function doneDo(Request $request)
    {
        $id_dr = $request->id_dr;
        $id_do = $request->id_do;
        $acceptDo = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_dr]])->first();
        if ($acceptDo == true) {
            $acceptDo->update(['status_penugasan' => 's']);
            return response()->json(
                [
                    'status'        => 'sukses',
                    'status_penugasan' => $acceptDo->status_penugasan
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal'
                ]
            );
        }
    }

    public function listCheckTransport(Request $request)
    {
        $id_dr = $request->query('id_dr');
        $list_check = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.status_penugasan',
                'tb_penugasan_driver.status_pengecekan',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tujuan',
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->orderByDesc('id_do')
            ->where([['tb_penugasan_driver.id_driver', $id_dr], ['tb_penugasan_driver.status_penugasan', 't']])
            ->get();
        $list_kendaraan = array();
        foreach ($list_check as $list) {
            $list_all = array();
            $list_all['id_do'] = $list->id_do;
            $list_all['tgl_penugasan'] = $list->tgl_penugasan;
            $list_all['status_penugasan'] = $list->status_penugasan;
            $list_all['status_pengecekan'] = $list->status_pengecekan;
            $list_all['nama_petugas'] = $list->nama_petugas;
            $list_all['tujuan'] = $list->tujuan;
            $list_all['id_service_order'] = $list->id_service_order;
            $list_all['id_kendaraan'] = $list->id_kendaraan;
            $list_all['nama_kendaraan'] = $list->nama_kendaraan;
            $list_all['no_polisi'] = $list->no_polisi;
            $kendaraan_lama = DB::table('tb_pengecekan_kendaraan')
                ->select(
                    'tb_pengecekan_kendaraan.id_do',
                    'tb_pengecekan_kendaraan.id_kendaraan',
                    'tb_kendaraan.nama_kendaraan',
                    'tb_kendaraan.no_polisi',
                    'tb_penugasan_driver.id_do'
                )
                ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
                ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pengecekan_kendaraan.id_do')
                ->where('tb_pengecekan_kendaraan.id_do', $list->id_do)
                ->orderByDesc('tb_pengecekan_kendaraan.id_pengecekan')
                ->get();
            $list_all['kendaraan_lama'] = array();
            foreach ($kendaraan_lama as $old) {
                $list_old = array();
                $list_old['nama_kendaraan'] = $old->nama_kendaraan;
                $list_old['no_polisi'] = $old->no_polisi;
                array_push($list_all['kendaraan_lama'], $list_old);
            }
            array_push($list_kendaraan, $list_all);
        }

        return response()->json(
            [
                'status'        => 'sukses',
                'list_kendaraan' => $list_kendaraan
            ]
        );
    }

    public function checkTransportDo(Request $request)
    {
        $id_dr = $request->query('id_dr');
        $kendaraan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.status_penugasan',
                'tb_penugasan_driver.status_pengecekan',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tujuan',
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->orderByDesc('id_do')
            ->where([['tb_penugasan_driver.id_driver', $id_dr], ['tb_penugasan_driver.status_penugasan', 't']])
            ->first();

        // $pengecekan = KriteriaPengecekan::select('id_kriteria', 'nama_kriteria')
        //     ->with(['jenis_pengecekan' => function ($jenis) {
        //         $jenis->select('id_jenis_pengecekan', 'id_kriteria', 'jenis_pengecekan')
        //             ->where('status', 'y');
        //     }])
        //     ->where('status', 'y')
        //     ->get();

        $awal = DB::table('tb_kriteria_pengecekan')->where('status', 'y')->get();
        $hasil = array();
        foreach ($awal as  $awww) {
            $hasil_awal = array();
            $hasil_awal['id_kriteria'] = $awww->id_kriteria;
            $hasil_awal['nama_kriteria'] = $awww->nama_kriteria;
            $kedua = DB::table('tb_jenis_pengecekan')->where([['id_kriteria', $awww->id_kriteria], ['status', 'y']])->get();
            $hasil_awal['list_jenis'] = array();
            foreach ($kedua as $axx) {
                $hasil_dua = array();
                $hasil_dua['id_pengecekan'] = $axx->id_jenis_pengecekan;
                $hasil_dua['jenis_pengecekan'] = $axx->jenis_pengecekan;
                array_push($hasil_awal['list_jenis'], $hasil_dua);
            }
            array_push($hasil, $hasil_awal);
        }

        return response()->json(
            [
                'status'            => 'sukses',
                'data_kendaraan'    => $kendaraan,
                'pengecekan'        => $hasil
            ]
        );
    }

    public function latestIdCo(Request $request)
    {

        $lastCo = DB::table('tb_pengecekan_kendaraan')
            ->select('id_pengecekan')
            ->orderByDesc('id_pengecekan')
            ->first();
        if ($lastCo != '') {
            return response()->json(
                $lastCo
            );
        } else {
            return response()->json(
                [
                    'id_pengecekan' => 'kosong'
                ]
            );
        }
    }

    public function storeCheckingDo(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'id_pengecekan'     => $request->id_pengecekan,
                'id_do'             => $request->id_do,
                'id_kendaraan'      => $request->id_kendaraan,
                'tgl_pengecekan'    => $request->tgl_pengecekan,
                'jam_pengecekan'    => Carbon::parse($request->jam_pengecekan)->format('H:i:s'),
                'km_kendaraan'      => $request->km_kendaraan,
                'status_kendaraan'  => $request->status_kendaraan,
                'status_pengecekan' => 'c'
            ];
            if ($request->status_kendaraan == 'r') {
                $updateDo = PenugasanDriver::where('id_do', $request->id_do)->update(['status_penugasan' => 'p']);
            }
            $saveCo = PengecekanKendaraan::create($data);
            $kondisi = $request->kondisi;
            foreach ($kondisi as $key => $value) {
                $detailCo = [
                    'id_pengecekan'         => $request->id_pengecekan,
                    'id_jenis_pengecekan'   => $request->id_jenis_pengecekan[$key],
                    'kondisi'               => $request->kondisi[$key],
                    'waktu_pengecekan'      => $request->waktu_pengecekan,
                    'keterangan'            => $request->keterangan[$key]
                ];
                $saveDetailCo = DB::table('tb_detail_pengecekan')->insert($detailCo);
            }

            DB::commit();
            return response()->json(
                [
                    'pesan'         => 'sukses',
                    'id_pengecekan' => $request->id_pengecekan
                ]
            );
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            return response()->json(
                [
                    'pesan' => 'gagal',
                    'errors' => $exception
                ]
            );
        }
    }
}
