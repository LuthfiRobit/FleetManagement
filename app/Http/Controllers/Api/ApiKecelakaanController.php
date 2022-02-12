<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kecelakaan;
use App\Models\KecelakaanFoto;
use App\Models\PenugasanDriver;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApiKecelakaanController extends Controller
{
    public function listKendaraan(Request $request)
    {

        $level = $request->query('level');
        $id = $request->query('id');
        $kendaraan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_driver',
                'tb_penugasan_driver.id_petugas',
                'tb_penugasan_driver.id_kendaraan',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_petugas.no_tlp as no_petugas',
                'tb_driver.nama_driver',
                'tb_driver.no_tlp as no_driver',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_penugasan_driver.tmp_penjemputan as jemput',
                'tb_penugasan_driver.tmp_tujuan as tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.status_penugasan'
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->when($level == 'driver', function ($by_driver) use ($id) {
                $by_driver->where('tb_penugasan_driver.id_driver', $id)
                    ->whereIn('tb_penugasan_driver.status_penugasan', ['t', 'p']);
            })
            ->when($level == 'petugas', function ($by_petugas) use ($id) {
                $by_petugas->where('tb_penugasan_driver.id_petugas', $id)
                    ->whereIn('tb_penugasan_driver.status_penugasan', ['t', 'p']);
            })
            ->orderByDesc('tb_penugasan_driver.id_do')
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'list_kendaraan' => $kendaraan
            ]
        );
    }

    public function formKecelakaan(Request $request)
    {
        $id_do = $request->query('id_do');
        $kendaraan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_driver',
                'tb_penugasan_driver.id_petugas',
                'tb_penugasan_driver.id_kendaraan',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_petugas.no_tlp as no_petugas',
                'tb_driver.nama_driver',
                'tb_driver.no_tlp as no_driver',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_penugasan_driver.tmp_penjemputan as jemput',
                'tb_penugasan_driver.tmp_tujuan as tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.status_penugasan'
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->where('tb_penugasan_driver.id_do', $id_do)
            ->first();
        if ($kendaraan != null) {
            return response()->json(
                [
                    'status'        => 'sukses',
                    'kendaraan'     => $kendaraan
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'kendaraan'     => 'kosong'
                ]
            );
        }
    }

    public function storeKecelakaan(Request $request)
    {
        $data = [
            'id_do' => $request->id_do,
            'tgl_kecelakaan' => Carbon::parse($request->tgl_kecelakaan)->format('Y-m-d'),
            'jam_kecelakaan' => Carbon::parse($request->jam_kecelakaan)->format('H:i:s'),
            'lokasi_kejadian' => $request->lokasi_kejadian,
            'kronologi' => $request->kronologi
        ];
        $storeKecelakaan = Kecelakaan::create($data);

        if ($storeKecelakaan) {
            $findPenugasan = PenugasanDriver::where('id_do', $request->id_do)->first();
            $findPenugasan->update(['status_penugasan' => 's']);
            return response()->json(
                [
                    'status'         => 'sukses',
                    'id_kecelakaan' => $storeKecelakaan->id_kecelakaan,
                    'status_penugasan' => $findPenugasan->status_penugasan
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

    public function listFotoKecelakaan(Request $request)
    {
        $id_kecelakaan = $request->query('id_kecelakaan');
        $list_foto = DB::table('tb_detail_foto_kecelakaan')
            ->select(
                'id_detail_foto',
                'id_kecelakaan',
                'foto_pendukung',
                'keterangan'
            )
            ->where('id_kecelakaan', $id_kecelakaan)
            ->get()
            ->map(
                function ($foto) {
                    return [
                        'id_foto' => $foto->id_detail_foto,
                        'id_kecelakaan' => $foto->id_kecelakaan,
                        'path' => '/assets/img_accident/' . $foto->foto_pendukung,
                        'keterangan' => $foto->keterangan
                    ];
                }
            );

        return response()->json(
            [
                'status' => 'sukses',
                'list_foto' => $list_foto
            ]
        );
    }

    public function storeFotoKecelakaan(Request $request)
    {
        $id_kecelakaan = $request->id_kecelakaan;
        $foto_pendukung = $request->file('foto');
        $keterangan = $request->keterangan;
        if ($foto_pendukung != null) {
            $name = 'accident_' . uniqid() . '.' . $foto_pendukung->getClientOriginalExtension();
            $data = [
                'id_kecelakaan' => $id_kecelakaan,
                'foto_pendukung' => $name,
                'keterangan' => $keterangan
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

    public function updateFotoKecelakaan(Request $request)
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

    public function deletFotoKecelakaan(Request $request)
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
                    'pesan'          => 'data terhapus'
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
}
