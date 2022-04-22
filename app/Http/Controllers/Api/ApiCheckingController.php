<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PengecekanKendaraan;
use App\Models\PengecekanKendaraanDetail;
use App\Models\PengecekanKendaraanFoto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApiCheckingController extends Controller
{
    public function listKendaraan(Request $request)
    {
        $tgl_sekarang = Carbon::now()->format('Y-m-d');
        $jam_awal = $request->query('jam_awal');
        $jam_akhir = $request->query('jam_akhir');
        // $kendaraan =  DB::select(
        //     'SELECT
        //     tb_kendaraan.id_kendaraan,
        //     tb_kendaraan.nama_kendaraan,
        //     tb_kendaraan.no_polisi,
        //     tb_jenis_sim.nama_sim as sim,
        //     tb_jenis_alokasi.nama_alokasi as alokasi FROM tb_kendaraan
        //     JOIN tb_jenis_sim on tb_jenis_sim.id_jenis_sim = tb_kendaraan.id_jenis_sim
        //     JOIN tb_alokasi_kendaraan on tb_alokasi_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan
        //     JOIN tb_jenis_alokasi on tb_jenis_alokasi.id_jenis_alokasi = tb_alokasi_kendaraan.id_jenis_alokasi
        //     WHERE NOT EXISTS (SELECT id_kendaraan FROM tb_pengecekan_kendaraan WHERE tb_pengecekan_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan AND tb_pengecekan_kendaraan.status_kendaraan = "t"
        //     UNION SELECT id_kendaraan FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_kendaraan = tb_kendaraan.id_kendaraan AND tb_penugasan_driver.tgl_penugasan = ' . '"' . $tgl_sekarang . '")'
        // );
        $kendaraan = DB::select(
            "SELECT
            tb_kendaraan.id_kendaraan,
            tb_kendaraan.nama_kendaraan,
            tb_kendaraan.no_polisi,
            tb_jenis_sim.nama_sim as sim
            -- tb_jenis_alokasi.nama_alokasi as alokasi
            FROM tb_kendaraan
            LEFT JOIN tb_jenis_sim on tb_jenis_sim.id_jenis_sim = tb_kendaraan.id_jenis_sim
            -- JOIN tb_alokasi_kendaraan on tb_alokasi_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan
            -- JOIN tb_jenis_alokasi on tb_jenis_alokasi.id_jenis_alokasi = tb_alokasi_kendaraan.id_jenis_alokasi
            WHERE NOT EXISTS (SELECT id_kendaraan FROM tb_pengecekan_kendaraan WHERE tb_pengecekan_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan AND tb_pengecekan_kendaraan.status_kendaraan = 't'
            AND  tb_pengecekan_kendaraan.jam_pengecekan BETWEEN '$jam_awal' AND '$jam_akhir' AND tb_pengecekan_kendaraan.tgl_pengecekan = '$tgl_sekarang'
            UNION SELECT id_kendaraan FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_kendaraan = tb_kendaraan.id_kendaraan AND tb_penugasan_driver.tgl_penugasan = '$tgl_sekarang')"
        );

        return response()->json(
            [
                'status'            => 'sukses',
                'tgl_sekarang'      => $tgl_sekarang,
                'list_kendaraan'    => $kendaraan
            ]
        );
    }

    public function idPengecekan(Request $request)
    {
        // $lastId = DB::table('tb_pengecekan_kendaraan')
        //     ->select('id_pengecekan')
        //     ->orderByDesc('id_pengecekan')
        //     ->first();
        // $lastId = DB::select('SELECT MAX(CONVERT(id_pengecekan, SIGNED)) as id FROM tb_pengecekan_kendaraan LIMIT 1');
        $lastId = DB::table('tb_pengecekan_kendaraan')
            ->selectRaw('MAX(CONVERT(id_pengecekan, SIGNED)) as id_pengecekan ')
            ->first();
        return response()->json(
            $lastId
        );
    }

    public function checkForm(Request $request)
    {
        $id_kendaraan = $request->query('id_kendaraan');
        $kendaraan = DB::table('tb_kendaraan')
            ->select(
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_jenis_sim.nama_sim',
                // 'tb_jenis_alokasi.nama_alokasi'
            )
            ->leftJoin('tb_jenis_sim', 'tb_jenis_sim.id_jenis_sim', '=', 'tb_kendaraan.id_jenis_sim')
            // ->leftJoin('tb_alokasi_kendaraan', 'tb_alokasi_kendaraan.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            // ->leftJoin('tb_jenis_alokasi', 'tb_jenis_alokasi.id_jenis_alokasi', '=', 'tb_alokasi_kendaraan.id_jenis_alokasi')
            ->where('tb_kendaraan.id_kendaraan', $id_kendaraan)
            ->first();
        $kriteria = DB::table('tb_kriteria_pengecekan')->where('status', 'y')->get();
        $hasil = array();
        foreach ($kriteria as  $krt) {
            $hasil_awal = array();
            $hasil_awal['id_kriteria'] = $krt->id_kriteria;
            $hasil_awal['nama_kriteria'] = $krt->nama_kriteria;
            $kedua = DB::table('tb_jenis_pengecekan')->where([['id_kriteria', $krt->id_kriteria], ['status', 'y']])->get();
            $hasil_awal['list_jenis'] = array();
            foreach ($kedua as $axx) {
                $hasil_dua = array();
                $hasil_dua['id_jenis_pengecekan'] = $axx->id_jenis_pengecekan;
                $hasil_dua['jenis_pengecekan'] = $axx->jenis_pengecekan;
                array_push($hasil_awal['list_jenis'], $hasil_dua);
            }
            array_push($hasil, $hasil_awal);
        }

        if ($kendaraan) {
            return response()->json(
                [
                    'status'       => 'sukses',
                    'kendaraan'    => $kendaraan,
                    'list_pengecekan' => $hasil
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'kendaraan' => 'kosong'
                ]
            );
        }
    }

    public function simpanPengecekan(Request $request)
    {
        DB::beginTransaction();
        try {
            $status_kendaraan = $request->status_kendaraan;
            $data = [
                'id_pengecekan'     => $request->id_pengecekan,
                'id_driver'         => $request->id_driver,
                'id_kendaraan'      => $request->id_kendaraan,
                'tgl_pengecekan'    => Carbon::parse($request->tgl_pengecekan)->format('Y-m-d'),
                'jam_pengecekan'    => Carbon::parse($request->jam_pengecekan)->format('H:i:s'),
                'km_kendaraan'      => $request->km_kendaraan,
                'status_kendaraan'  => $status_kendaraan,
                'status_pengecekan' => $request->status_pengecekan
            ];
            if ($status_kendaraan == 'r') {
                $data['status_perbaikan'] = 'n';
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
                    'status'         => 'sukses',
                    'id_pengecekan' => $request->id_pengecekan
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

    public function listFotoPengecekan(Request $request)
    {
        $id_pengecekan = $request->query('id_pengecekan');
        $list_foto = DB::table('tb_detail_foto_pengecekan')
            ->select(
                'id_detail_foto_cek',
                'id_pengecekan',
                'foto_pengecekan',
                'keterangan'
            )
            ->where('id_pengecekan', $id_pengecekan)
            ->get()
            ->map(
                function ($foto) {
                    return [
                        'id_foto' => $foto->id_detail_foto_cek,
                        'id_pengecekan' => $foto->id_pengecekan,
                        'path' => $foto->foto_pengecekan,
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

    public function simpanFotoPengecekan(Request $request)
    {
        $foto_pengecekan = $request->file('foto_pengecekan');
        if ($foto_pengecekan != null) {
            $name = 'checking_' . uniqid() . '.' . $foto_pengecekan->getClientOriginalExtension();
            $data = [
                'id_pengecekan' => $request->id_pengecekan,
                'foto_pengecekan' => $name,
                'keterangan' => $request->keterangan
            ];
            // $simpan = PengecekanKendaraanFoto::create($data);
            $simpan = DB::table('tb_detail_foto_pengecekan')->insertGetId($data);
            if ($simpan) {
                $folder_accident = 'assets/img_checking';
                $foto_pengecekan->move($folder_accident, $name);
                return response()->json(
                    [
                        'status'         => 'sukses',
                        'id_detail_foto_cek' => $simpan
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

    public function updateFotoPengecekan(Request $request)
    {
        $id_foto = $request->id_detail_foto_cek;
        $find = PengecekanKendaraanFoto::where('id_detail_foto_cek', $id_foto)->first();
        if (!is_null($find->foto_pengecekan)) {
            File::delete('assets/img_checking/' . $find->foto_pengecekan);
        }
        $foto_pengecekan = $request->file('foto_pengecekan');
        $name = 'checking_' . uniqid() . '.' . $foto_pengecekan->getClientOriginalExtension();

        $data = [
            'foto_pengecekan' => $name,
            'keterangan'    => $request->keterangan
        ];
        $update = $find->update($data);
        if ($update) {
            $folder = 'assets/img_checking';
            $foto_pengecekan->move($folder, $name);
            return response()->json(
                [
                    'status'         => 'sukses',
                    'id_detail_foto_cek'       => $find->id_detail_foto_cek
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

    public function deleteFotoPengecekan(Request $request)
    {
        $id_foto = $request->id_detail_foto_cek;
        $find = PengecekanKendaraanFoto::where('id_detail_foto_cek', $id_foto)->first();
        if ($find) {
            if (!is_null($find->foto_pengecekan)) {
                File::delete('assets/img_checking/' . $find->foto_pengecekan);
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

    public function cancelPengecekan(Request $request)
    {
        $id_pengecekan = $request->id_pengecekan;
        $findPengecekan = PengecekanKendaraan::where('id_pengecekan', $id_pengecekan)->first();
        if ($findPengecekan == '') {
            return response()->json(
                [
                    'status'         => 'gagal',
                    'pesan'       => 'data tidak ada'
                ]
            );
        } else {
            $findFoto = PengecekanKendaraanFoto::where('id_pengecekan', $id_pengecekan)->get();
            if ($findFoto->count() > 0) {
                $findFoto->each(function ($file, $key) {
                    File::delete('assets/img_checking/' . $file->foto_pengecekan);
                    $file->delete();
                });
            }
            $findDetail = PengecekanKendaraanDetail::where('id_pengecekan', $id_pengecekan)->delete();
            $findPengecekan->delete();
            return response()->json(
                [
                    'status'         => 'sukses',
                    'pesan'          => 'data terhapus'
                ]
            );
        }
    }

    public function FilterBy(Request $request){
        $nomorpolisi = $request->query('noplat');
        $tgl_sekarang = Carbon::now()->format('Y-m-d');
        $jam_awal = $request->query('jam_awal');
        $jam_akhir = $request->query('jam_akhir');
       

        $kendaraan = DB::select(
            "SELECT
            tb_kendaraan.id_kendaraan,
            tb_kendaraan.nama_kendaraan,
            tb_kendaraan.no_polisi,
            tb_jenis_sim.nama_sim as sim
            -- tb_jenis_alokasi.nama_alokasi as alokasi
            FROM tb_kendaraan
            
            LEFT JOIN tb_jenis_sim on tb_jenis_sim.id_jenis_sim = tb_kendaraan.id_jenis_sim
            -- JOIN tb_alokasi_kendaraan on tb_alokasi_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan
            -- JOIN tb_jenis_alokasi on tb_jenis_alokasi.id_jenis_alokasi = tb_alokasi_kendaraan.id_jenis_alokasi
            WHERE  tb_kendaraan.no_polisi LIKE '%$nomorpolisi%' AND NOT EXISTS (SELECT id_kendaraan FROM tb_pengecekan_kendaraan WHERE tb_pengecekan_kendaraan.id_kendaraan = tb_kendaraan.id_kendaraan AND tb_pengecekan_kendaraan.status_kendaraan = 't'
            AND  tb_pengecekan_kendaraan.jam_pengecekan BETWEEN '$jam_awal' AND '$jam_akhir' AND tb_pengecekan_kendaraan.tgl_pengecekan = '$tgl_sekarang'
            UNION SELECT id_kendaraan FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_kendaraan = tb_kendaraan.id_kendaraan AND tb_penugasan_driver.tgl_penugasan = '$tgl_sekarang')"

        );
        return response()->json(
            [
                'status'            => 'sukses',
                'tgl_sekarang'      => $tgl_sekarang,
                'list_kendaraan'    => $kendaraan
            ]
        ); 
       

        // if($kendaraan->count()> 0){
             
        // }
    }
}
