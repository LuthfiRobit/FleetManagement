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
                'tb_penugasan_driver.tmp_penjemputan as jemput',
                'tb_penugasan_driver.tmp_tujuan as tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan'
            )
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
                'tb_penugasan_driver.tmp_penjemputan as jemput',
                'tb_penugasan_driver.tmp_tujuan as tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan'
            )
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

    //jadikan query
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
                'tb_penugasan_driver.tmp_penjemputan as jemput',
                'tb_penugasan_driver.tmp_tujuan as tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan'
            )
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

    //jadikan query
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

    //jadikan query
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
                'lat_tujuan' => $request->latitude,
                'long_tujuan' => $request->longitude,
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
                'lat_tujuan' => $latitude,
                'long_tujuan' => $longitude
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
        $response = Http::withBasicAuth('Luthfi_ph', 'Trial!123')
            ->withHeaders([
                'content-type' => 'application/json'
            ])->post('https://wappin.id/v1/token/get');
        return $response;
    }

    // public function selesaiPenugasan(Request $request)
    // {
    //     try {

    //         $id_do = $request->query('id_do');
    //         $id_driver = $request->query('id_driver');
    //         $proses = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_driver]])->first();
    //         $driver = Driver::select('nama_driver', 'no_tlp')->where('id_driver', $id_driver)->first();
    //         if ($proses == true) {
    //             $findPenumpang = ServiceOrderDetail::where('id_service_order', $proses->id_service_order)->get();
    //             if ($findPenumpang) {
    //                 foreach ($findPenumpang as $penumpang) {
    //                     $url = route('rating.insert', 'id_do=' . $proses->id_do . '&no_tlp=' . $penumpang->no_tlp);
    //                     // $builder = new \AshAllenDesign\ShortURL\Classes\Builder();

    //                     // $shortURLObject = $builder->destinationUrl($url)->make();
    //                     // $shortURL = $shortURLObject->default_short_url;
    //                     $client = new Client();
    //                     $res = $client->request('POST', 'http://localhost:8000/send-message', [
    //                         'form_params' => [
    //                             'number' => $penumpang->no_tlp,
    //                             'message' => "Halo *" . $penumpang->nama_penumpang . ".*" . "\r\n" .
    //                                 "Silahkan lakukan penilaian terhadap driver dalam perjalanan anda" . "\r\n" .
    //                                 "*Driver*" . "\r\n" .
    //                                 "Nama : *" . $driver->nama_driver . "*" . "\r\n" .
    //                                 "No. Tlp : *" . $driver->no_tlp . "*" . "\r\n" .
    //                                 "Click Link dibawah" . "\r\n"
    //                                 . $url . "\r\n" .
    //                                 "*) Link tidak boleh dishare"
    //                         ]
    //                     ]);
    //                     if ($res->getStatusCode() == 200) { // 200 OK
    //                         $response_data = $res->getBody()->getContents();
    //                     }
    //                 }
    //                 $data = [
    //                     'km_akhir' => $request->km_akhir,
    //                     'status_bbm_akhir' => $request->bbm_akhir,
    //                     'waktu_finish' => $request->waktu_finish,
    //                     'keterangan_bbm' => $request->keterangan_bbm,
    //                     'status_penugasan' => 's'
    //                 ];
    //                 $proses->update($data);
    //                 return response()->json(
    //                     [
    //                         'status'        => 'sukses',
    //                         'status_penugasan' => $proses->status_penugasan
    //                     ]
    //                 );
    //             }
    //         } else {
    //             return response()->json(
    //                 [
    //                     'status'        => 'gagal'
    //                 ]
    //             );
    //         }
    //         // return response()->json(
    //         //     [
    //         //         'status' => 'gagal',
    //         //         'error' => $proses
    //         //     ]
    //         // );
    //     } catch (\Exception $exception) {
    //         //throw $th;
    //         DB::rollBack();
    //         return response()->json(
    //             [
    //                 'status' => 'gagal',
    //                 'error' => $exception
    //             ]
    //         );
    //     }
    // }

    // public function selesaiPenugasan(Request $request)
    // {
    //     $sid    = env("TWILIO_AUTH_SID");
    //     $token  = env("TWILIO_AUTH_TOKEN");
    //     $wa_from = env("TWILIO_WHATSAPP_FROM");
    //     $recipient = '+6282330199009';
    //     $twilio = new Client($sid, $token);

    //     $body = "Hello, welcome to codelapan.com.";

    //     return $twilio->messages->create("whatsapp:$recipient", ["from" => "whatsapp:$wa_from", "body" => $body]);

    // $client = new Client();
    // $res = $client->request('POST', 'https://api.chat-api.com/instance408414/sendMessage?token=750e6o1h0hb9lt8m', [
    //     'form_params' => [
    //         'phone' => '15855721186',
    //         'body' => "Halo Indra"
    //     ]
    // ]);
    // if ($res->getStatusCode() == 404) { // 200 OK
    //     return $res->getBody()->getContents();
    // } else {
    //     return $res->getBody()->getContents();
    // }
    // }
}
