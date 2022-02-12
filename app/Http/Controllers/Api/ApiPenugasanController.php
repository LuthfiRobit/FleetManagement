<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenugasanBatal;
use App\Models\PenugasanDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if ($latestDo->count() > 0) {
            return response()->json(
                [
                    'status'        => 'sukses',
                    'terbaru'     => $latestDo
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'terbaru'     => 'kosong'
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
                    'status'        => 'sukses',
                    'detail'     => $detail
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'detail'     => 'kosong'
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
