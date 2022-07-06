<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenugasanBiaya;
use App\Models\PenugasanBiayaDetail;
use App\Models\PenugasanDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
                'tb_detail_biaya.id_detail_biaya',
                'tb_detail_biaya.id_jenis_pengeluaran',
                'tb_jenis_pengeluaran.nama_jenis',
                'tb_detail_biaya.bukti',
                'tb_detail_biaya.nominal',
                'tb_detail_biaya.keterangan'
            )
            ->leftJoin('tb_jenis_pengeluaran', 'tb_jenis_pengeluaran.id_jenis_pengeluaran', '=', 'tb_detail_biaya.id_jenis_pengeluaran')
            ->where('tb_detail_biaya.id_biaya_penugasan', $id_biaya_penugasan)
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

    public function listTunggu(Request $request)
    {
        $id = $request->query('id');
        $listTunggu = DB::select("
        SELECT tb_order_kendaraan.no_so,tb_biaya_penugasan.id_biaya_penugasan,
        tb_biaya_penugasan.tgl_pengajuan, tb_biaya_penugasan.total_biaya
        FROM tb_biaya_penugasan 
        LEFT JOIN tb_detail_biaya on tb_detail_biaya.id_biaya_penugasan = tb_biaya_penugasan.id_biaya_penugasan
        LEFT JOIN tb_detail_acc_biaya on tb_detail_acc_biaya.id_detail_biaya = tb_detail_biaya.id_detail_biaya
        LEFT JOIN tb_penugasan_driver on tb_penugasan_driver.id_do = tb_biaya_penugasan.id_do
        LEFT JOIN tb_order_kendaraan on tb_order_kendaraan.id_service_order = tb_penugasan_driver.id_service_order
        WHERE tb_penugasan_driver.id_driver = $id 
        AND tb_detail_biaya.id_detail_biaya 
        IN (SELECT id_detail_biaya FROM tb_detail_acc_biaya GROUP BY id_detail_biaya HAVING COUNT(id_detail_biaya) = 1)
        GROUP BY tb_biaya_penugasan.id_biaya_penugasan, tb_order_kendaraan.no_so,
        tb_biaya_penugasan.id_biaya_penugasan, tb_biaya_penugasan.tgl_pengajuan, tb_biaya_penugasan.total_biaya
        ORDER BY tb_biaya_penugasan.tgl_pengajuan DESC
        ");
        $hasil = array();
        foreach ($listTunggu as $lT) {
            $hasil_awal = array();
            $hasil_awal['id_biaya_penugasan'] = $lT->id_biaya_penugasan;
            $hasil_awal['no_so'] = $lT->no_so;
            $hasil_awal['tgl_pengajuan'] = $lT->tgl_pengajuan;
            $hasil_awal['total_biaya'] = $lT->total_biaya;
            $item = DB::table('tb_detail_biaya')
                ->selectRaw('
                tb_detail_biaya.id_detail_biaya,
                tb_jenis_pengeluaran.nama_jenis,
                tb_detail_biaya.nominal,
                tb_detail_acc_biaya.tgl_pengecekan,
                tb_detail_acc_biaya.status_acc
            ')
                ->leftJoin('tb_biaya_penugasan', 'tb_biaya_penugasan.id_biaya_penugasan', 'tb_detail_biaya.id_biaya_penugasan')
                ->leftJoin('tb_jenis_pengeluaran', 'tb_jenis_pengeluaran.id_jenis_pengeluaran', 'tb_detail_biaya.id_jenis_pengeluaran')
                ->leftJoin('tb_detail_acc_biaya', 'tb_detail_acc_biaya.id_detail_biaya', 'tb_detail_biaya.id_detail_biaya')
                ->where([
                    ['tb_detail_biaya.id_biaya_penugasan', $lT->id_biaya_penugasan], ['tb_detail_acc_biaya.id_petugas', 5]
                    // , ['tb_detail_acc_biaya.status_acc', 'tr']
                ])
                ->get();
            $hasil_awal['item'] = array();
            foreach ($item as $it) {
                $hasil_item = array();
                $hasil_item['id_detail_biaya'] = $it->id_detail_biaya;
                $hasil_item['nama_item'] = $it->nama_jenis;
                $hasil_item['nominal'] = $it->nominal;
                $hasil_item['tgl_pengecekan'] = $it->tgl_pengecekan;
                $hasil_item['status_acc'] = $it->status_acc;
                array_push($hasil_awal['item'], $hasil_item);
            }
            array_push($hasil, $hasil_awal);
        }
        return response()->json(
            [
                'status'         => 'sukses',
                'list_pengajuan' => $hasil
            ]
        );
    }

    public function listSelesai(Request $request)
    {
        $id = $request->query('id');
        $listTunggu = DB::select("
        SELECT tb_order_kendaraan.no_so,tb_biaya_penugasan.id_biaya_penugasan,
        tb_biaya_penugasan.tgl_pengajuan, tb_biaya_penugasan.total_biaya, SUM(tb_detail_biaya.nominal) as total_terima
        FROM tb_biaya_penugasan 
        LEFT JOIN tb_detail_biaya on tb_detail_biaya.id_biaya_penugasan = tb_biaya_penugasan.id_biaya_penugasan
        LEFT JOIN tb_detail_acc_biaya on tb_detail_acc_biaya.id_detail_biaya = tb_detail_biaya.id_detail_biaya
        LEFT JOIN tb_penugasan_driver on tb_penugasan_driver.id_do = tb_biaya_penugasan.id_do
        LEFT JOIN tb_order_kendaraan on tb_order_kendaraan.id_service_order = tb_penugasan_driver.id_service_order
        WHERE tb_penugasan_driver.id_driver = $id 
        AND tb_detail_acc_biaya.status_acc = 't' 
        AND tb_detail_acc_biaya.id_petugas = 4
        AND tb_detail_biaya.id_detail_biaya 
        IN (SELECT id_detail_biaya FROM tb_detail_acc_biaya GROUP BY id_detail_biaya HAVING COUNT(id_detail_biaya) > 1)
        GROUP BY tb_biaya_penugasan.id_biaya_penugasan, tb_order_kendaraan.no_so,
        tb_biaya_penugasan.id_biaya_penugasan, tb_biaya_penugasan.tgl_pengajuan, tb_biaya_penugasan.total_biaya
        ORDER BY tb_biaya_penugasan.tgl_pengajuan DESC
        ");
        $hasil = array();
        foreach ($listTunggu as $lT) {
            $hasil_awal = array();
            $hasil_awal['id_biaya_penugasan'] = $lT->id_biaya_penugasan;
            $hasil_awal['no_so'] = $lT->no_so;
            $hasil_awal['tgl_pengajuan'] = $lT->tgl_pengajuan;
            $hasil_awal['total_biaya'] = $lT->total_biaya;
            $hasil_awal['total_terima'] = $lT->total_terima;
            $item = DB::table('tb_detail_biaya')
                ->selectRaw('
                tb_detail_biaya.id_detail_biaya,
                tb_jenis_pengeluaran.nama_jenis,
                tb_detail_biaya.nominal,
                tb_detail_acc_biaya.tgl_pengecekan,
                tb_detail_acc_biaya.status_acc
            ')
                ->leftJoin('tb_biaya_penugasan', 'tb_biaya_penugasan.id_biaya_penugasan', 'tb_detail_biaya.id_biaya_penugasan')
                ->leftJoin('tb_jenis_pengeluaran', 'tb_jenis_pengeluaran.id_jenis_pengeluaran', 'tb_detail_biaya.id_jenis_pengeluaran')
                ->leftJoin('tb_detail_acc_biaya', 'tb_detail_acc_biaya.id_detail_biaya', 'tb_detail_biaya.id_detail_biaya')
                ->where([['tb_detail_biaya.id_biaya_penugasan', $lT->id_biaya_penugasan], ['tb_detail_acc_biaya.id_petugas', 4]])
                ->get();
            $hasil_awal['item'] = array();
            foreach ($item as $it) {
                $hasil_item = array();
                $hasil_item['id_detail_biaya'] = $it->id_detail_biaya;
                $hasil_item['nama_item'] = $it->nama_jenis;
                $hasil_item['nominal'] = $it->nominal;
                $hasil_item['tgl_pengecekan'] = $it->tgl_pengecekan;
                $hasil_item['status_acc'] = $it->status_acc;
                array_push($hasil_awal['item'], $hasil_item);
            }
            array_push($hasil, $hasil_awal);
        }
        return response()->json(
            [
                'status'         => 'sukses',
                'list_pengajuan' => $hasil
            ]
        );
    }

    public function detailRevisi(Request $request)
    {
        $id_detail = $request->query('id_detail');
        $detailRevisi = DB::table('tb_detail_biaya')
            ->select(
                'tb_detail_biaya.id_detail_biaya',
                'tb_jenis_pengeluaran.nama_jenis',
                'tb_detail_biaya.nominal',
                'tb_detail_biaya.bukti',
                'tb_detail_acc_biaya.tgl_pengecekan',
                'tb_detail_acc_biaya.status_acc',
                'tb_detail_acc_biaya.keterangan'
            )
            ->leftJoin('tb_jenis_pengeluaran', 'tb_detail_biaya.id_jenis_pengeluaran', '=', 'tb_jenis_pengeluaran.id_jenis_pengeluaran')
            ->leftJoin('tb_detail_acc_biaya', 'tb_detail_biaya.id_detail_biaya', '=', 'tb_detail_acc_biaya.id_detail_biaya')
            ->where([['tb_detail_biaya.id_detail_biaya', $id_detail], ['tb_detail_acc_biaya.id_petugas', 5]])
            ->first();
        if ($detailRevisi) {
            return response()->json(
                [
                    'status' => 'sukses',
                    'detail' => $detailRevisi
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

    public function updateRevisi(Request $request)
    {
        $id_detail = $request->id_detail;
        $nominal = $request->nominal;
        $keterangan = $request->keterangan;
        $bukti = $request->file('bukti');
        $find = PenugasanBiayaDetail::where('id_detail_biaya', $id_detail)->first();
        if ($find) {
            $findBiaya = PenugasanBiaya::where('id_biaya_penugasan', $find->id_biaya_penugasan)->first();
            $kurang = $findBiaya->total_biaya - $find->nominal;
            $tambah = $kurang + $nominal;
            if (!is_null($find->bukti)) {
                File::delete('assets/img_biaya/' . $find->foto_pengecekan);
            }
            $name = 'biaya_' . uniqid() . '.' . $bukti->getClientOriginalExtension();
            $data = [
                'nominal' => $nominal,
                'bukti' => $name,
                'keterangan' => $keterangan
            ];
            $update = $find->update($data);
            if ($update) {
                $findBiaya->update(['total_biaya' => $tambah]);
                $folder_biaya = 'assets/img_biaya';
                $bukti->move($folder_biaya, $name);
                return response()->json(
                    [
                        'status'         => 'sukses',
                        'pesan' => 'detail berhasil diupdate'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'status'         => 'gagal',
                        'pesan' => 'detail gagal diupadate'
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'status'         => 'gagal',
                    'pesan'          => 'Id detail tidak ditemukan'
                ]
            );
        }
    }

    // public function formBiaya(){

    // }
}
