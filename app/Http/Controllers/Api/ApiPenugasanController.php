<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenugasanBatal;
use App\Models\PenugasanDriver;
use Illuminate\Http\Request;

class ApiPenugasanController extends Controller
{
    public function index()
    {
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

    public function selesaiPenugasan(Request $request)
    {
        $id_dr = $request->id_driver;
        $id_do = $request->id_do;
        $proses = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_dr]])->first();
        if ($proses == true) {
            $data = [
                'km_akhir' => $request->km_akhir,
                'status_bbm_akhir' => $request->bbm_akhir,
                'waktu_finish' => $request->waktu_finish,
                'keterangan_bbm' => $request->keterangan_bbm,
                'status_penugasan' => 's'
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
}
