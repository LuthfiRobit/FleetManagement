<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenugasanBiaya;
use App\Models\PenugasanBiayaDetail;
use App\Models\PenugasanDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApiBiayaPenugasanController extends Controller
{
    public function formBiaya(Request $request)
    {
        $id_do = $request->query('id_do');
        $data = ['id_do' => $id_do];
        $find = PenugasanDriver::where('id_do', $id_do)->first();
        if ($find) {
            $createIdBiaya = PenugasanBiaya::create($data);
            $jenisPengeluaran = DB::table('tb_jenis_pengeluaran')
                ->select(
                    'id_jenis_pengeluaran',
                    'nama_jenis',
                    'status'
                )
                ->where('status', 'y')
                ->get();
            return response()->json(
                [
                    'status'        => 'sukses',
                    'id_biaya_penugasan' => $createIdBiaya->id_biaya_penugasan,
                    'list_pengeluaran' => $jenisPengeluaran
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

    public function simpanBiaya(Request $request)
    {
        $id_biaya_penugasan = $request->id_biaya_penugasan;
        $data = [
            'tgl_pengajuan' => $request->tgl_pengajuan,
            'total_biaya' => $request->total_biaya
        ];
        $find = PenugasanBiaya::where('id_biaya_penugasan', $id_biaya_penugasan)->first();
        if ($find) {
            $find->update($data);
            return response()->json(
                [
                    'status'        => 'sukses',
                    'id_biaya_penugasan' => $find->id_biaya_penugasan
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

    public function listBukti(Request $request)
    {
        $id_biaya_penugasan = $request->query('id_biaya_penugasan');
        $list_bukti = DB::table('tb_detail_biaya')
            ->select(
                'id_detail_biaya',
                'id_jenis_pengeluaran',
                'bukti',
                'nominal',
                'keterangan'
            )
            ->where('id_biaya_penugasan', $id_biaya_penugasan)
            ->get();

        return response()->json(
            [
                'status' => 'sukses',
                'list_bukti' => $list_bukti
            ]
        );
    }

    public function insertBuktiBiaya(Request $request)
    {
        $bukti = $request->file('bukti_biaya');
        if ($bukti != null) {
            $name = 'biaya_' . uniqid() . '.' . $bukti->getClientOriginalExtension();
            $data = [
                'id_biaya_penugasan' => $request->id_biaya_penugasan,
                'id_jenis_pengeluaran' => $request->id_jenis_pengeluaran,
                'nominal' => $request->nominal,
                'bukti' => $name,
                'keterangan' => $request->keterangan
            ];
            $simpan = DB::table('tb_detail_biaya')->insertGetId($data);
            if ($simpan) {
                $folder_biaya = 'assets/img_biaya';
                $bukti->move($folder_biaya, $name);
                return response()->json(
                    [
                        'status'         => 'sukses',
                        'id_detail_biaya' => $simpan
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

    public function updateBuktiBiaya(Request $request)
    {
        $id_detail_biaya = $request->id_detail_biaya;
        $find = PenugasanBiayaDetail::where('id_detail_biaya', $id_detail_biaya)->first();
        if (!is_null($find->bukti)) {
            File::delete('assets/img_biaya/' . $find->bukti);
        }
        $bukti = $request->file('bukti_biaya');
        $name = 'biaya_' . uniqid() . '.' . $bukti->getClientOriginalExtension();
        $data = [
            'id_jenis_pengeluaran' => $request->id_jenis_pengeluaran,
            'nominal' => $request->nominal,
            'bukti' => $name,
            'keterangan' => $request->keterangan
        ];
        $update = $find->update($data);
        if ($update) {
            $folder_biaya = 'assets/img_biaya';
            $bukti->move($folder_biaya, $name);
            return response()->json(
                [
                    'status'         => 'sukses',
                    'id_detail_biaya' => $find->id_detail_biaya
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

    public function deleteBuktiBiaya(Request $request)
    {
        $id_detail_biaya = $request->id_detail_biaya;
        $find = PenugasanBiayaDetail::where('id_detail_biaya', $id_detail_biaya)->first();

        if ($find) {
            if (!is_null($find->bukti)) {
                File::delete('assets/img_biaya/' . $find->bukti);
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

    public function cancelBiaya(Request $request)
    {
        $id_biaya_penugasan = $request->id_biaya_penugasan;
        $find = PenugasanBiaya::where('id_biaya_penugasan', $id_biaya_penugasan)->first();
        if ($find == '') {
            return response()->json(
                [
                    'status'      => 'gagal',
                    'pesan'       => 'data tidak ada'
                ]
            );
        } else {
            $findBukti = PenugasanBiayaDetail::where('id_biaya_penugasan', $id_biaya_penugasan)->get();
            if ($findBukti->count() > 0) {
                $findBukti->each(function ($file, $key) {
                    File::delete('assets/img_biaya/' . $file->bukti);
                    $file->delete();
                });
            }
            $find->delete();
            return response()->json(
                [
                    'status'         => 'sukses',
                    'pesan'          => 'data terhapus'
                ]
            );
        }
    }

    // public function formBiaya(){

    // }
}
