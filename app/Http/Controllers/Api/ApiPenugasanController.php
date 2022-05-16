<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\PenugasanBatal;
use App\Models\PenugasanDriver;
use App\Models\ServiceOrderDetail;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

// use Twilio\Rest\Client;

// use Twilio\Rest\Client;

class ApiPenugasanController extends Controller
{

    public function penugasanTerbaru(Request $request)
    {
        $id_dr = $request->query('id_driver');
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
                'tb_order_kendaraan.tempat_penjemputan as jemput',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan'
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_do')
            ->where([['tb_penugasan_driver.id_driver', $id_dr], ['status_penugasan', null]])
            ->get();

        return response()->json(
            [
                'status'      => 'sukses',
                'terbaru'     => $latestDo
            ]
        );
    }

    public function notifPenugasan(Request $request)
    {
        $id_driver = $request->query('id_driver');
        $notifPenugasan = PenugasanDriver::where([['id_driver', $id_driver], ['status_penugasan', null]])->get()->count();
        if ($notifPenugasan > 0) {
            return response()->json(
                [
                    'status'      => 'sukses',
                    'notif'       => 'ada ' . $notifPenugasan . ' penugasan baru'
                ]
            );
        } else {
            return response()->json(
                [
                    'status'      => 'gagal',
                    'notif'       => 'belum ada penugasan baru'
                ]
            );
        }
    }

    public function listSelesai(Request $request)
    {
        $id_driver = $request->query('id_driver');
        $tgl = $request->query('fil_tgl');
        $list_selesai = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_petugas.foto_petugas',
                'tb_petugas.no_tlp',
                'tb_driver.nama_driver',
                'tb_driver.foto_driver',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.tgl_selesai',
                'tb_penugasan_driver.jam_berangkat',
                'tb_order_kendaraan.tempat_penjemputan as jemput',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan'
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_do')
            ->where([['tb_penugasan_driver.id_driver', $id_driver], ['tb_penugasan_driver.status_penugasan', 's']])
            ->when($tgl != null, function ($filter) use ($tgl) {
                $filter->where('tb_penugasan_driver.tgl_selesai', $tgl);
            })
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'list_selesai'     => $list_selesai
            ]
        );
    }

    public function listBatal(Request $request)
    {
        $id_driver = $request->query('id_driver');
        $tgl = $request->query('fil_tgl');
        $list_batal = DB::table('tb_pembatalan_penugasan')
            ->select(
                'tb_pembatalan_penugasan.id_pembatalan',
                'tb_pembatalan_penugasan.id_do',
                'tb_pembatalan_penugasan.id_driver',
                'tb_pembatalan_penugasan.tanggal',
                'tb_pembatalan_penugasan.alasan_pembatalan as alasan',
                'tb_pembatalan_penugasan.status_pembatalan',
                'tb_pembatalan_penugasan.bukti',
                'tb_driver.nama_driver',
                'tb_driver.foto_driver',
                'tb_order_kendaraan.no_so',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_petugas.foto_petugas',
                'tb_petugas.no_tlp'
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pembatalan_penugasan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_pembatalan_penugasan.id_driver')
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_pembatalan_penugasan.id_driver', $id_driver)
            ->orderByDesc('tb_pembatalan_penugasan.id_pembatalan')
            ->when($tgl != null, function ($filter) use ($tgl) {
                $filter->where('tb_pembatalan_penugasan.tanggal', $tgl);
            })
            ->get();
        return response()->json(
            [
                'status'        => 'sukses',
                'list_batal'     => $list_batal
            ]
        );
    }

    public function detailPenugasan(Request $request)
    {
        $id_do = $request->query('id_do');
        $id_dr = $request->query('id_driver');
        $detail = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_service_order',
                'tb_penugasan_driver.id_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_petugas.foto_petugas',
                'tb_petugas.no_tlp',
                'tb_driver.nama_driver',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_order_kendaraan.tempat_penjemputan as jemput',
                'tb_order_kendaraan.tujuan',
                'tb_order_kendaraan.jml_penumpang',
                'tb_order_kendaraan.keterangan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.tgl_selesai',
                'tb_penugasan_driver.status_penugasan'
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->where([['tb_penugasan_driver.id_do', $id_do], ['tb_penugasan_driver.id_driver', $id_dr]])
            ->first();

        if ($detail) {
            $penumpang = DB::table('tb_detail_so')
                ->select(
                    'nama_penumpang',
                    'jabatan',
                    'no_tlp'
                )
                ->join('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_detail_so.id_service_order')
                ->where('tb_detail_so.id_service_order', $detail->id_service_order)
                ->get();
            return response()->json(
                [
                    'status'     => 'sukses',
                    'detail'     => $detail,
                    'penumpang' => $penumpang
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'detail'        => $detail
                ]
            );
        }
    }

    public function terimaPenugasan(Request $request)
    {
        $id_dr = $request->id_driver;
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

    public function listPenugasan(Request $request)
    {
        $id_dr = $request->query('id_driver');
        $tab = $request->query('tab');
        $listDo = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_petugas.foto_petugas',
                'tb_petugas.no_tlp',
                'tb_driver.nama_driver',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_penugasan_driver.tgl_penugasan',
                // 'tb_penugasan_driver.tgl_selesai',
                'tb_penugasan_driver.jam_berangkat',
                'tb_order_kendaraan.tempat_penjemputan as jemput',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan'
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            // ->orderByDesc('id_do')
            ->when($tab == 'n', function ($status) use ($tab) {
                $status->where('status_penugasan', null);
            })
            ->when($tab == 't', function ($status) use ($tab) {
                $status->where('status_penugasan', 't');
            })
            ->when($tab == 'p', function ($status) use ($tab) {
                $status->where('status_penugasan', 'p');
            })
            // ->when($tab == 's', function ($status) use ($tab) {
            //     $status->where('status_penugasan', 's');
            // })
            ->when($tab == 'c', function ($status) use ($tab) {
                $status->where('status_penugasan', 'c');
            })
            ->where('tb_penugasan_driver.id_driver', $id_dr)
            ->orderBy(DB::raw("CASE status_penugasan WHEN null THEN 1 WHEN 't' THEN 2 WHEN 'p' THEN 3 WHEN 'c' THEN 4 WHEN 's' THEN 5 END"))
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'list_penugasan'     => $listDo
            ]
        );
    }

    public function batalPenugasanValidasi(Request $request)
    {
        $id_do = $request->query('id_do');
        $id_driver = $request->query('id_driver');

        $pembatalan = DB::table('tb_pembatalan_penugasan')->where([['id_do', $id_do], ['id_driver', $id_driver]])->first();

        if ($pembatalan) {
            if ($pembatalan->status_pembatalan == null) {
                return response()->json(
                    [
                        'status'    => 'konfirmasi',
                        'pesan'     => 'pembatalan penugasan menunggu konfirmasi.'
                    ]
                );
            } else if ($pembatalan->status_pembatalan == 'tl') {
                return response()->json(
                    [
                        'status'    => 'tolak',
                        'pesan'     => 'pembatalan penugasan ditolak, selesaikan penugasan'
                    ]
                );
            } else if ($pembatalan->status_pembatalan == 't') {
                return response()->json(
                    [
                        'status'    => 'terima',
                        'pesan'     => 'pembatalan penugasan diterima'
                    ]
                );
            }
        } else {
            $findPenugasan = PenugasanDriver::where('id_do', $id_do)->first();
            if (Carbon::now()->format('Y-m-d') == $findPenugasan->tgl_penugasan || Carbon::now()->format('Y-m-d') > $findPenugasan->tgl_penugasan) {
                return response()->json(
                    [
                        'status'    => 'proses',
                        'pesan'     => 'pembatalan penugasan ditolak, penugasan harus diproses'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'status'    => 'ajukan',
                        'pesan'     => 'silahkan ajukan pembatalan'
                    ]
                );
            }
        }
    }

    public function batalPenugasan(Request $request)
    {
        $id_dr = $request->id_driver;
        $id_do = $request->id_do;
        $proses = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_dr]])->first();
        if ($proses == true) {
            // $proses->update(['status_penugasan' => 'c']);
            $bukti = $request->file('bukti');
            $name = 'batal_' . uniqid() . '.' . $bukti->getClientOriginalExtension();
            $dataPembatalan = [
                'id_do' => $id_do,
                'id_driver' => $id_dr,
                'alasan_pembatalan' => $request->alasan,
                'tanggal' => $request->tgl_batal,
                'bukti' => $name
            ];
            $simpanBatal = PenugasanBatal::create($dataPembatalan);
            if ($simpanBatal) {
                $folder_batal = 'assets/img_batal';
                $bukti->move($folder_batal, $name);
                return response()->json(
                    [
                        'status'        => 'sukses',
                        'id_pembatalan' => $simpanBatal->id_pembatalan,
                        'status_penugasan' => $proses->status_penugasan
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'status'        => 'gagal'
                ]
            );
        }
    }

    public function prosesPenugasanValidasi(Request $request)
    {
        $id_do = $request->query('id_do');
        $id_driver = $request->query('id_driver');
        $findProses = PenugasanDriver::where([['id_driver', $id_driver], ['status_penugasan', 'p']])->first();

        if ($findProses == true) {
            return response()->json(
                [
                    'status'    => 'gagal',
                    'pesan'     => 'anda masih memiliki satu penugasan proses'
                ]
            );
        } else {
            $findNow = PenugasanDriver::where('id_do', $id_do)->first();
            if ($findNow->tgl_penugasan == Carbon::now()->format('Y-m-d')) {
                return response()->json(
                    [
                        'status'    => 'sukses',
                        'pesan'     => 'silahkan melakukan proses'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'status'    => 'gagal',
                        'pesan'     => 'proses hanya bisa dilakukan pada tanggal penugasan'
                    ]
                );
            }
        }
    }

    public function prosesPenugasan(Request $request)
    {
        $id_dr = $request->id_driver;
        $id_do = $request->id_do;
        $proses = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_dr]])->first();
        if ($proses == true) {
            $data = [
                'km_awal' => $request->km_awal,
                'status_bbm_awal' => $request->bbm_awal,
                'waktu_start' => $request->waktu_start,
                'lat_sekarang' => $request->latitude,
                'long_sekarang' => $request->longitude,
                'status_penugasan' => 'p'
            ];
            $proses->update($data);
            return response()->json(
                [
                    'status'        => 'sukses',
                    'status_penugasan' => $proses->status_penugasan
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

    public function lokasiUpdate(Request $request)
    {
        $id_driver = $request->id_driver;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $findPenugasan = PenugasanDriver::where([['id_driver', $id_driver], ['status_penugasan', 'p']])->first();
        if ($findPenugasan) {
            $data = [
                'lat_sekarang' => $latitude,
                'long_sekarang' => $longitude
            ];
            $findPenugasan->update($data);
            return response()->json(
                [
                    'status'        => 'sukses',
                    'pesan' => 'lokasi berhasil diupdate'
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'pesan' =>  'lokasi gagal diupdate'
                ]
            );
        }
    }

    public function getToken(Request $request)
    {
        $client = new Client();
        // $request = $client->post('https://api.wappin.id/v1/token/get', [
        //     'auth' => [
        //         'username' => base64_encode(env('WAPPIN_CLIENT_ID')),
        //         'password' => base64_encode(env('WAPPIN_SECRET_KEY'))
        //     ]
        // ]);
        $request = Http::withBasicAuth(env('WAPPIN_CLIENT_ID'), env('WAPPIN_SECRET_KEY'))->post('https://api.wappin.id/v1/token/get');
        if ($request->getStatusCode() == 200) { // 200 OK
            $response_data = $request->getBody()->getContents();
        }

        return $response_data;
    }

    public function sendWa(Request $request)
    {
        $client = new Client();
        $request = $client->post('https://api.wappin.id/v1/message/do-send-hsm', [
            'headers' => ['Authorization' => 'Bearer ' . env('TOKEN_WAPPIN')],
            'body' => json_encode([
                'client_id' => '0146',
                'project_id' => '2825',
                'type' => 'costumer_notif',
                'recipient_number' => '6285204557072',
                'language_code' => 'id',
                'params' => [
                    '1' => 'Luthfi',
                    '2' => 'Indra',
                    '3' => '081222333444',
                    '4' => 'https://fleet.belanj.id'
                ]
            ])
        ]);
        if ($request->getStatusCode() == 200) { // 200 OK
            $response_data = $request->getBody()->getContents();
        }

        return $response_data;
    }

    public function selesaiPenugasan(Request $request)
    {
        // try {

        $id_do = $request->id_do;
        $id_driver = $request->id_driver;
        $proses = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_driver]])->first();
        $driver = Driver::select('nama_driver', 'no_tlp')->where('id_driver', $id_driver)->first();
        if ($proses == true) {
            $findPenumpang = ServiceOrderDetail::where([['id_service_order', $proses->id_service_order], ['status', 'y']])->first();
            if ($findPenumpang) {
                $data = [
                    'tgl_selesai' => $request->tgl_selesai,
                    'km_akhir' => $request->km_akhir,
                    'status_bbm_akhir' => $request->bbm_akhir,
                    'waktu_finish' => $request->waktu_finish,
                    'keterangan_bbm' => $request->keterangan_bbm,
                    'status_penugasan' => 's'
                ];
                $proses->update($data);
                // foreach ($findPenumpang as $penumpang) {
                // $url = route('rating.insert', 'id_do=' . $proses->id_do . '&no_tlp=' . $findPenumpang->no_tlp);
                // $client = new Client();
                // $request = $client->post('https://api.wappin.id/v1/message/do-send-hsm', [
                //     'headers' => ['Authorization' => 'Bearer ' . env('TOKEN_WAPPIN')],
                //     'body' => json_encode([
                //         'client_id' => '0146',
                //         'project_id' => '2825',
                //         'type' => 'costumer_notif',
                //         'recipient_number' => $findPenumpang->no_tlp,
                //         'language_code' => 'id',
                //         'params' => [
                //             '1' => $findPenumpang->nama_penumpang,
                //             '2' => $driver->nama_driver,
                //             '3' => $driver->no_tlp,
                //             '4' => $url
                //         ]
                //     ])
                // ]);
                // if ($request->getStatusCode() == 200) { // 200 OK
                //     $response_data = $request->getBody()->getContents();
                // }
                // }
                return response()->json(
                    [
                        'status'        => 'sukses',
                        'status_penugasan' => $proses->status_penugasan
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'status'        => 'gagal'
                ]
            );
        }
        // return response()->json(
        //     [
        //         'status' => 'gagal',
        //         'error' => $proses
        //     ]
        // );
        // } catch (\Exception $exception) {
        //     //throw $th;
        //     DB::rollBack();
        //     return response()->json(
        //         [
        //             'status' => 'gagal',
        //             'error' => $exception
        //         ]
        //     );
        // }
    }

    public function listPenugasanRating()
    {
        $listRating = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.no_so',
                'tb_driver.nama_driver',
                'tb_driver.no_tlp as tlp_driver',
                'tb_penugasan_driver.tgl_selesai',
                'tb_penugasan_driver.status_penugasan',
                'tb_detail_so.nama_penumpang',
                'tb_detail_so.no_tlp',
                'tb_detail_so.status',
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_detail_so', 'tb_detail_so.id_service_order', '=', 'tb_order_kendaraan.id_service_order')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_rating_driver', 'tb_rating_driver.id_do', '=', 'tb_penugasan_driver.id_do')
            ->where([['tb_penugasan_driver.status_penugasan', 's'], ['tb_detail_so.status', 'y']])
            ->groupByRaw('
                tb_penugasan_driver.id_do,
                tb_order_kendaraan.id_service_order,
                tb_order_kendaraan.no_so,
                tb_driver.nama_driver,
                tb_driver.no_tlp,
                tb_penugasan_driver.tgl_selesai,
                tb_penugasan_driver.status_penugasan,
                tb_detail_so.nama_penumpang,
                tb_detail_so.no_tlp,
                tb_detail_so.status
            ')
            ->having(DB::raw('count(tb_rating_driver.id_do)'), '=', 0)
            ->get()
            ->map(
                function ($rating) {
                    return [
                        'id_do' => $rating->id_do,
                        'no_so' => $rating->no_so,
                        'tgl_selesai' => Carbon::parse($rating->tgl_selesai)->format('d-m-Y'),
                        'nama_penumpang' => $rating->nama_penumpang,
                        'no_penumpang' => '+' . $rating->no_tlp,
                        'url_wa' => 'https://api.whatsapp.com/send?phone=6282336181538&text=Halo%20*'
                            . $rating->nama_penumpang . '*%0ASilahkan%20berikan%20rating%20untuk%20driver%20dalam%20perjalanan%20anda%0ADriver%20:%20*'
                            . $rating->nama_driver . '*%0AKontak%20:%20*'
                            . $rating->tlp_driver . '*%0Aklik%20link%20dibawah%20ini%0A([' . route(
                                'rating.insert',
                                $rating->id_do . '?no_tlp=' . $rating->no_tlp
                            ) . '])%0ATerimakasih%0A*PT.Pomi*',
                        // 'url'   => route('rating.insert', $rating->id_do . '?no_tlp=' . $rating->no_tlp)
                    ];
                }
            );
        return response()->json(
            [
                'status'        => 'sukses',
                'list_rating' => $listRating
            ]
        );
    }

    public function sendNotif(Request $request)
    {
        $key = 'MDg2NjY1ZGYtZTgyYy00NTkyLWIyY2MtMDRhNDYyODBiOTU1';
        $client = new Client();
        $request = $client->post('https://onesignal.com/api/v1/notifications', [
            'headers' => [
                'Authorization' => 'Basic ' . $key,
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'included_segments' => ['Subscribed Users'],
                'app_id' => '768c8998-943b-4ffa-8829-07c1107a9216',
                'contents' => ['en' => 'Anda Memiliki Penugasan Baru.'],
                'headings' => ['en' => 'Silahkan Cek Penugasan Sopir.']
            ])
        ]);
        if ($request->getStatusCode() == 200) { // 200 OK
            $response_data = $request->getBody()->getContents();
        }

        return $response_data;
    }

    public function addDevice(Request $request)
    {
        $fields = array(
            'app_id' => "768c8998-943b-4ffa-8829-07c1107a9216",
            'identifier' => "ce777617da7f548fe7a9ab6febb56cf39fba6d382000c0395666288d961ee566",
            'language' => "en",
            'timezone' => "-28800",
            'game_version' => "1.0",
            'device_os' => "9.1.3",
            'device_type' => "1",
            'device_model' => "Redmi 8",
            'tags' => array("foo" => "bar")
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        $return["allresponses"] = $response;
        $return = json_encode($return);

        print("\n\nJSON received:\n");
        print($return);
        print("\n");
    }
}
