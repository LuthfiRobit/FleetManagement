<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kecelakaan;
use App\Models\KecelakaanFoto;
use App\Models\KecelakaanSaksi;
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
                'tb_order_kendaraan.tempat_penjemputan as jemput',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.status_penugasan'
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
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
                'tb_penugasan_driver.id_service_order',
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
                'tb_order_kendaraan.tempat_penjemputan as jemput',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.status_penugasan'
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->where('tb_penugasan_driver.id_do', $id_do)
            ->first();

        if ($kendaraan != null) {
            $data = ['id_do' => $id_do];
            $kecelakaan = Kecelakaan::create($data);
            $saksi = DB::table('tb_detail_so')
                ->select(
                    'tb_detail_so.id_detail_so',
                    'tb_detail_so.nama_penumpang'
                )
                ->where('tb_detail_so.id_service_order', $kendaraan->id_service_order)
                ->get();
            return response()->json(
                [
                    'status'        => 'sukses',
                    'id_kecelakaan' => $kecelakaan->id_kecelakaan,
                    'kendaraan'     => $kendaraan,
                    'saksi'         => $saksi
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'kendaraan'     =>  $kendaraan
                ]
            );
        }
    }

    public function storeKecelakaan(Request $request)
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
            $id_kecelakaan = $request->id_kecelakaan;
            // $saveAcd = Kecelakaan::create($data);
            $saveAcd = Kecelakaan::where('id_kecelakaan', $id_kecelakaan)->update($data);
            if ($saveAcd) {
                $dataSaksi = [
                    'id_kecelakaan' => $id_kecelakaan,
                    'id_saksi' => $request->id_saksi,
                    'id_atasan' => $request->id_atasan
                ];
                $saveSaksi = KecelakaanSaksi::create($dataSaksi);
                $findfoto = KecelakaanFoto::where('id_kecelakaan', $id_kecelakaan)->get();
                if ($findfoto->count() > 0) {
                    $findfoto->each(function ($file, $key) use ($saveAcd, $id_kecelakaan) {
                        $file->update(array('id_kecelakaan' => $id_kecelakaan));
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
            PenugasanDriver::where('id_do', $request->id_do)->update(
                [
                    'status_penugasan' => 's'
                ]
            );
            DB::commit();
            return response()->json(
                [
                    'status'         => 'sukses',
                    'id_kecelakaan' => $id_kecelakaan
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
                        'path' => $foto->foto_pendukung,
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
        // $id_kecelakaan = $request->id_kecelakaan;
        $foto_pendukung = $request->file('foto');
        $keterangan = $request->keterangan;
        if ($foto_pendukung != null) {
            $name = 'accident_' . uniqid() . '.' . $foto_pendukung->getClientOriginalExtension();
            $data = [
                // 'id_kecelakaan' => $id_kecelakaan,
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
        $id_foto = $request->query('id_foto');
        $find = KecelakaanFoto::where('id_detail_foto', $id_foto)->first();
        if (!is_null($find->foto_pendukung)) {
            File::delete('assets/img_accident/' . $find->foto_pendukung);
        }
        $foto_pendukung = $request->file('foto');
        $name = 'accident_' . uniqid() . '.' . $foto_pendukung->getClientOriginalExtension();

        $data = [
            'foto_pendukung' => $name,
            'keterangan' => $request->keterangan
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
        $id_foto = $request->query('id_foto');
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

    public function cancelFotoKecelakaan(Request $request)
    {
        $id_kecelakaan = $request->id_kecelakaan;
        $find = KecelakaanFoto::where('id_kecelakaan', $id_kecelakaan)->get();

        if ($find->count() == 0) {

            KecelakaanSaksi::where('id_kecelakaan', $id_kecelakaan)->delete();
            Kecelakaan::where('id_kecelakaan', $id_kecelakaan)->delete();

            return response()->json(
                [
                    'status'         => 'sukses',
                    'pesan'       => 'data terhapus'
                ]
            );
        } else {
            $find->each(function ($file, $key) {
                File::delete('assets/img_accident/' . $file->foto_pendukung);
                $file->delete();
            });
            KecelakaanSaksi::where('id_kecelakaan', $id_kecelakaan)->delete();
            Kecelakaan::where('id_kecelakaan', $id_kecelakaan)->delete();
            return response()->json(
                [
                    'status'         => 'sukses',
                    'pesan'       => 'data terhapus'
                ]
            );
        }
    }

    public function saveFotoKecelakaan(Request $request)
    {
        $id_kecelakaan = $request->id_kecelakaan;
        $foto_pendukung = $request->file('foto');
        $keterangan = $request->keterangan;
        if ($foto_pendukung != null) {
            $name = 'accident_' . uniqid() . '.' . $foto_pendukung->getClientOriginalExtension();
            $data = [
                'id_kecelakaan' => $id_kecelakaan,
                'foto_pendukung' => $name,
                // 'keterangan' => $keterangan
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

    public function editFotoKecelakaan(Request $request)
    {
        $id_foto = $request->query('id_foto');
        $find = KecelakaanFoto::where('id_detail_foto', $id_foto)->first();
        if (!is_null($find->foto_pendukung)) {
            File::delete('assets/img_accident/' . $find->foto_pendukung);
        }
        $foto_pendukung = $request->file('foto');
        $name = 'accident_' . uniqid() . '.' . $foto_pendukung->getClientOriginalExtension();

        $data = [
            'foto_pendukung' => $name,
            // 'keterangan' => $request->keterangan
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

    public function saveKeteranganFotoKecelakaan(Request $request)
    {
        $id_foto = $request->query('id_foto');
        $find = KecelakaanFoto::where('id_detail_foto', $id_foto)->first();
        if ($find) {
            $data = [
                'keterangan' => $request->keterangan
            ];
            $find->update($data);
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
}
