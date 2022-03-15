<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\PenugasanBatal;
use App\Models\PenugasanDriver;
use App\Models\ServiceOrderDetail;
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

    public function detailPenugasan(Request $request)
    {
        $id_do = $request->query('id_do');
        $id_dr = $request->query('id_driver');
        $detail = DB::table('tb_penugasan_driver')
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
            ->where([['tb_penugasan_driver.id_do', $id_do], ['tb_penugasan_driver.id_driver', $id_dr]])
            ->first();

        if ($detail) {
            return response()->json(
                [
                    'status'     => 'sukses',
                    'detail'     => $detail
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
            return response()->json(
                [
                    'status'    => 'ajukan',
                    'pesan'     => 'silahkan ajukan pembatalan'
                ]
            );
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
        $findProses = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_driver], ['status_penugasan', 'p']])->first();

        if ($findProses == true) {
            return response()->json(
                [
                    'status'    => 'gagal',
                    'pesan'     => 'anda masih memiliki satu penugasan proses'
                ]
            );
        } else {
            return response()->json(
                [
                    'status'    => 'sukses',
                    'pesan'     => 'silahkan melakukan proses'
                ]
            );
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
                    'km_akhir' => $request->km_akhir,
                    'status_bbm_akhir' => $request->bbm_akhir,
                    'waktu_finish' => $request->waktu_finish,
                    'keterangan_bbm' => $request->keterangan_bbm,
                    'status_penugasan' => 's'
                ];
                $proses->update($data);
                // foreach ($findPenumpang as $penumpang) {
                $url = route('rating.insert', 'id_do=' . $proses->id_do . '&no_tlp=' . $findPenumpang->no_tlp);
                $client = new Client();
                $request = $client->post('https://api.wappin.id/v1/message/do-send-hsm', [
                    'headers' => ['Authorization' => 'Bearer ' . env('TOKEN_WAPPIN')],
                    'body' => json_encode([
                        'client_id' => '0146',
                        'project_id' => '2825',
                        'type' => 'costumer_notif',
                        'recipient_number' => $findPenumpang->no_tlp,
                        'language_code' => 'id',
                        'params' => [
                            '1' => $findPenumpang->nama_penumpang,
                            '2' => $driver->nama_driver,
                            '3' => $driver->no_tlp,
                            '4' => $url
                        ]
                    ])
                ]);
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
