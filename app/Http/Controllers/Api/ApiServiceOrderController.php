<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KriteriaPengecekan;
use App\Models\PengecekanKendaraan;
use App\Models\PenugasanDriver;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiServiceOrderController extends Controller
{

    public function createSo(Request $request)
    {
        DB::beginTransaction();
        try {
            $so = [
                'id_service_order'  => $request->id_service_order,
                'id_petugas'        => $request->id_petugas,
                'tgl_penjemputan'   => $request->tgl_penjemputan,
                'jam_penjemputan'   => Carbon::parse($request->jam_penjemputan)->format('H:i:s'),
                'jml_penumpang'     => $request->jml_penumpang,
                'tempat_penjemputan' => $request->tempat_penjemputan,
                'tujuan'            => $request->tujuan,
                'keterangan'        => $request->keterangan,
            ];
            // $saveSo = DB::table('tb_order_kendaraan')->insert($so);
            $saveSo = ServiceOrder::create($so);
            $namaPenumpang = $request->nama_penumpang;
            foreach ($namaPenumpang as $key => $value) {
                $serviceDetail = [
                    'id_service_order'  => $request->id_service_order,
                    'nama_penumpang'    => $request->nama_penumpang[$key],
                    'no_tlp'            => $request->no_tlp[$key]
                ];
                $saveDetailSo = DB::table('tb_detail_so')->insert($serviceDetail);
            }

            DB::commit();
            return response()->json(
                [
                    'pesan'             => 'sukses',
                    'id_service_order'  => $request->id_service_order
                ],
                200
            );
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            return response()->json(
                [
                    'pesan' => 'gagal',
                    'errors' => $exception
                ],
                400
            );
        }
    }

    public function getLastIdDo(Request $request)
    {
        $latestId = DB::table('tb_order_kendaraan')
            ->select('id_service_order')
            ->orderByDesc('id_service_order')
            ->first();

        if ($latestId != '') {
            return response()->json(
                $latestId
            );
        } else {
            return response()->json(
                [
                    'id_service_order' => 'kosong'
                ]
            );
        }
    }

    public function getDo(Request $request)
    {
        $id = $request->query('id');
        $tab = $request->query('tab');
        $serviceOrder = DB::table('tb_order_kendaraan')
            ->select(
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tgl_penjemputan',
                'tb_order_kendaraan.jam_penjemputan',
                'tb_order_kendaraan.jml_penumpang',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_order_kendaraan.keterangan',
                'tb_order_kendaraan.status_so',
                'tb_order_kendaraan.keterangan_penolakan',
                'tb_petugas.id_petugas',
                'tb_petugas.nama_lengkap',
            )
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_order_kendaraan.id_petugas')
            ->where('tb_order_kendaraan.id_petugas', $id)
            ->when($tab == '', function ($status) use ($tab) {
                $status->where('status_so', null);
            })
            ->when($tab == 't', function ($status) use ($tab) {
                $status->where('status_so', 't');
            })
            ->when($tab == 'tl', function ($status) use ($tab) {
                $status->where('status_so', 'tl');
            })
            ->when($tab == 'c', function ($status) use ($tab) {
                $status->where('status_so', 'c');
            })
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'service_order' => $serviceOrder
            ]
        );
    }

    public function cancelDo(Request $request)
    {
        $id_petugas = $request->id_petugas;
        $id_so = $request->id_so;
        $cancelSo = ServiceOrder::where([['id_service_order', $id_so], ['id_petugas', $id_petugas]])->first();
        if ($cancelSo == true) {
            $cancelSo->update(['status_so' => 'c']);
            $findDo = PenugasanDriver::where('id_service_order', $id_so)->first();
            $cancelDo = $findDo->update(['status_penugasan' => 'c']);
            return response()->json(
                [
                    'status'        => 'sukses',
                    'status_so' => $cancelSo->status_so,
                    'status_penugasan' => $findDo->status_penugasan
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

    public function getDoDetail(Request $request)
    {
        $id_so = $id = $request->query('id_so');
        $detailAccepted = DB::table('tb_order_kendaraan')
            ->select(
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tgl_penjemputan',
                'tb_order_kendaraan.jam_penjemputan',
                'tb_order_kendaraan.jml_penumpang',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_order_kendaraan.keterangan',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_driver.nama_driver',
                'tb_driver.no_tlp',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
            )
            ->join('tb_penugasan_driver', 'tb_order_kendaraan.id_service_order', '=', 'tb_order_kendaraan.id_service_order')
            ->join('tb_driver', 'tb_penugasan_driver.id_driver', '=', 'tb_driver.id_driver')
            ->join('tb_kendaraan', 'tb_penugasan_driver.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->join('tb_petugas', 'tb_order_kendaraan.id_petugas', '=', 'tb_petugas.id_petugas')
            ->where('tb_order_kendaraan.id_service_order', $id_so)
            ->first();
        $penumpang = DB::table('tb_detail_so')
            ->select(
                'nama_penumpang',
                'no_tlp'
            )
            ->join('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_detail_so.id_service_order')
            ->where('tb_detail_so.id_service_order', $detailAccepted->id_service_order)
            ->get();
        return response()->json(
            [
                'status'    => 'sukses',
                'detail'    => $detailAccepted,
                'penumpang' => $penumpang
            ]
        );
    }

    public function listTransport(Request $request)
    {
        $id = $request->query('id');
        $kendaraan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_petugas',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.status_penugasan',
                'tb_driver.id_driver',
                'tb_driver.nama_driver',
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tujuan',
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->orderByDesc('id_do')
            ->where('tb_penugasan_driver.id_petugas', $id)
            ->where('tb_penugasan_driver.status_penugasan', '!=', 's')
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'cek_kendaraan' => $kendaraan
            ]
        );
    }

    public function accidentReport(Request $request)
    {
        $id_petugas = $request->query('id_petugas');
        $id_do = $request->query('id_do');
        $detail_report = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_petugas',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.status_penugasan',
                'tb_driver.id_driver',
                'tb_driver.nama_driver',
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tujuan',
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->orderByDesc('id_do')
            ->where([['tb_penugasan_driver.id_petugas', $id_petugas], ['tb_penugasan_driver.id_do', $id_do]])
            ->first();
        if ($detail_report != null) {
            return response()->json(
                [
                    'status'        => 'sukses',
                    'cek_kendaraan' => $detail_report
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'cek_kendaraan' => 'kosong'
                ]
            );
        }
    }

    public function accidentReportStore(Request $request)
    {
        DB::beginTransaction();
        try {
            //code...
            $data = [
                'id_do' => $request->id_do,
                'tgl_kecelakaan' => $request->tgl_kecelakaan,
                'jam_kecelakaan' => $request->jam_kecelakaan,
                'lokasi_kejadian' => $request->lokasi_kejadian,
                'kronologi' => $request->kronologi
            ];
            $saveAcd = Kecelakaan::create($data);
            $foto = [$request->file('foto_kecelakaan')];
            foreach ($foto as $key => $value) {
                foreach ($request->foto_kecelakaan as $foto) {
                    $name = 'accident_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                    $foto->move('assets/img_accident', $name);
                    $detailFoto = [
                        'id_kecelakaan' => $saveAcd->id_kecelakaan,
                        'foto_pendukung' => $name
                    ];
                    $saveDetailfoto = DB::table('tb_detail_foto_kecelakaan')->insert($detailFoto);
                }
            }
            DB::commit();
            return response()->json(
                [
                    'pesan'         => 'sukses',
                    'id_kecelakaan' => $saveAcd->id_kecelakaan
                ]
            );
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            return response()->json(
                [
                    'pesan' => 'gagal',
                    'errors' => $exception
                ]
            );
        }
    }

    public function checkinReport(Request $request)
    {
        $awal = DB::table('tb_kriteria_pengecekan')->where('status', 'y')->get();
        $hasil = array();
        foreach ($awal as  $awww) {
            $hasil_awal = array();
            $hasil_awal['id_kriteria'] = $awww->id_kriteria;
            $hasil_awal['nama_kriteria'] = $awww->nama_kriteria;
            $kedua = DB::table('tb_jenis_pengecekan')->where([['id_kriteria', $awww->id_kriteria], ['status', 'y']])->get();
            $hasil_awal['list_jenis'] = array();
            foreach ($kedua as $axx) {
                $hasil_dua = array();
                $hasil_dua['id_pengecekan'] = $axx->id_jenis_pengecekan;
                $hasil_dua['jenis_pengecekan'] = $axx->jenis_pengecekan;
                array_push($hasil_awal['list_jenis'], $hasil_dua);
            }
            array_push($hasil, $hasil_awal);
        }

        return response()->json(
            [
                'status'            => 'sukses',
                'pengecekan'        => $hasil
            ]
        );
    }

    public function checkingReportStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'id_pengecekan'     => $request->id_pengecekan,
                'id_do'             => $request->id_do,
                'id_kendaraan'      => $request->id_kendaraan,
                'tgl_pengecekan'    => $request->tgl_pengecekan,
                'jam_pengecekan'    => Carbon::parse($request->jam_pengecekan)->format('H:i:s'),
                'km_kendaraan'      => $request->km_kendaraan,
                'status_kendaraan'  => $request->status_kendaraan,
                'status_pengecekan' => 'k'
            ];
            if ($request->status_kendaraan == 't') {
                $updateDo = PenugasanDriver::where('id_do', $request->id_do)->update(['status_penugasan' => 's']);
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
                    'pesan'         => 'sukses',
                    'id_pengecekan' => $request->id_pengecekan
                ]
            );
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            return response()->json(
                [
                    'pesan' => 'gagal',
                    'errors' => $exception
                ]
            );
        }
    }

    //driver

    public function latestDo(Request $request)
    {
        $id_dr = $request->query('id_dr');
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
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan',
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_do')
            ->where([['tb_penugasan_driver.id_driver', $id_dr], ['status_penugasan', null]])
            ->get();

        return response()->json(
            [
                'status'        => 'sukses',
                'latest_do'     => $latestDo
            ]
        );
    }

    public function latestDetailDo(Request $request)
    {
        $id_do = $request->query('id_do');
        $latestDetail = DB::table('tb_penugasan_driver')
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
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan',
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->join('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->where('id_do', $id_do)
            ->first();

        return response()->json(
            [
                'status'        => 'sukses',
                'latest_detail'     => $latestDetail
            ]
        );
    }

    public function acceptDo(Request $request)
    {
        $id_dr = $request->id_dr;
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

    public function listDo(Request $request)
    {
        $id_dr = $request->query('id_dr');
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
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan',
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->join('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
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
                'list_do'     => $listDo
            ]
        );
    }

    public function processDo(Request $request)
    {
        $id_dr = $request->id_dr;
        $id_do = $request->id_do;
        $acceptDo = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_dr]])->first();
        if ($acceptDo == true) {
            $acceptDo->update(['status_penugasan' => 'p']);
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

    public function doneDo(Request $request)
    {
        $id_dr = $request->id_dr;
        $id_do = $request->id_do;
        $acceptDo = PenugasanDriver::where([['id_do', $id_do], ['id_driver', $id_dr]])->first();
        if ($acceptDo == true) {
            $acceptDo->update(['status_penugasan' => 's']);
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

    public function listCheckTransport(Request $request)
    {
        $id_dr = $request->query('id_dr');
        $list_check = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.status_penugasan',
                'tb_penugasan_driver.status_pengecekan',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tujuan',
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->orderByDesc('id_do')
            ->where([['tb_penugasan_driver.id_driver', $id_dr], ['tb_penugasan_driver.status_penugasan', 't']])
            ->get();
        $list_kendaraan = array();
        foreach ($list_check as $list) {
            $list_all = array();
            $list_all['id_do'] = $list->id_do;
            $list_all['tgl_penugasan'] = $list->tgl_penugasan;
            $list_all['status_penugasan'] = $list->status_penugasan;
            $list_all['status_pengecekan'] = $list->status_pengecekan;
            $list_all['nama_petugas'] = $list->nama_petugas;
            $list_all['tujuan'] = $list->tujuan;
            $list_all['id_service_order'] = $list->id_service_order;
            $list_all['id_kendaraan'] = $list->id_kendaraan;
            $list_all['nama_kendaraan'] = $list->nama_kendaraan;
            $list_all['no_polisi'] = $list->no_polisi;
            $kendaraan_lama = DB::table('tb_pengecekan_kendaraan')
                ->select(
                    'tb_pengecekan_kendaraan.id_do',
                    'tb_pengecekan_kendaraan.id_kendaraan',
                    'tb_kendaraan.nama_kendaraan',
                    'tb_kendaraan.no_polisi',
                    'tb_penugasan_driver.id_do'
                )
                ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
                ->join('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pengecekan_kendaraan.id_do')
                ->where('tb_pengecekan_kendaraan.id_do', $list->id_do)
                ->orderByDesc('tb_pengecekan_kendaraan.id_pengecekan')
                ->get();
            $list_all['kendaraan_lama'] = array();
            foreach ($kendaraan_lama as $old) {
                $list_old = array();
                $list_old['nama_kendaraan'] = $old->nama_kendaraan;
                $list_old['no_polisi'] = $old->no_polisi;
                array_push($list_all['kendaraan_lama'], $list_old);
            }
            array_push($list_kendaraan, $list_all);
        }

        return response()->json(
            [
                'status'        => 'sukses',
                'list_kendaraan' => $list_kendaraan
            ]
        );
    }

    public function checkTransportDo(Request $request)
    {
        $id_dr = $request->query('id_dr');
        $kendaraan = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.status_penugasan',
                'tb_penugasan_driver.status_pengecekan',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_order_kendaraan.id_service_order',
                'tb_order_kendaraan.tujuan',
            )
            ->join('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->orderByDesc('id_do')
            ->where([['tb_penugasan_driver.id_driver', $id_dr], ['tb_penugasan_driver.status_penugasan', 't']])
            ->first();

        // $pengecekan = KriteriaPengecekan::select('id_kriteria', 'nama_kriteria')
        //     ->with(['jenis_pengecekan' => function ($jenis) {
        //         $jenis->select('id_jenis_pengecekan', 'id_kriteria', 'jenis_pengecekan')
        //             ->where('status', 'y');
        //     }])
        //     ->where('status', 'y')
        //     ->get();

        $awal = DB::table('tb_kriteria_pengecekan')->where('status', 'y')->get();
        $hasil = array();
        foreach ($awal as  $awww) {
            $hasil_awal = array();
            $hasil_awal['id_kriteria'] = $awww->id_kriteria;
            $hasil_awal['nama_kriteria'] = $awww->nama_kriteria;
            $kedua = DB::table('tb_jenis_pengecekan')->where([['id_kriteria', $awww->id_kriteria], ['status', 'y']])->get();
            $hasil_awal['list_jenis'] = array();
            foreach ($kedua as $axx) {
                $hasil_dua = array();
                $hasil_dua['id_pengecekan'] = $axx->id_jenis_pengecekan;
                $hasil_dua['jenis_pengecekan'] = $axx->jenis_pengecekan;
                array_push($hasil_awal['list_jenis'], $hasil_dua);
            }
            array_push($hasil, $hasil_awal);
        }

        return response()->json(
            [
                'status'            => 'sukses',
                'data_kendaraan'    => $kendaraan,
                'pengecekan'        => $hasil
            ]
        );
    }

    public function latestIdCo(Request $request)
    {

        $lastCo = DB::table('tb_pengecekan_kendaraan')
            ->select('id_pengecekan')
            ->orderByDesc('id_pengecekan')
            ->first();
        if ($lastCo != '') {
            return response()->json(
                $lastCo
            );
        } else {
            return response()->json(
                [
                    'id_pengecekan' => 'kosong'
                ]
            );
        }
    }

    public function storeCheckingDo(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                'id_pengecekan'     => $request->id_pengecekan,
                'id_do'             => $request->id_do,
                'id_kendaraan'      => $request->id_kendaraan,
                'tgl_pengecekan'    => $request->tgl_pengecekan,
                'jam_pengecekan'    => Carbon::parse($request->jam_pengecekan)->format('H:i:s'),
                'km_kendaraan'      => $request->km_kendaraan,
                'status_kendaraan'  => $request->status_kendaraan,
                'status_pengecekan' => 'c'
            ];
            if ($request->status_kendaraan == 'r') {
                $updateDo = PenugasanDriver::where('id_do', $request->id_do)->update(['status_penugasan' => 'p']);
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
                    'pesan'         => 'sukses',
                    'id_pengecekan' => $request->id_pengecekan
                ]
            );
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            return response()->json(
                [
                    'pesan' => 'gagal',
                    'errors' => $exception
                ]
            );
        }
    }
}
