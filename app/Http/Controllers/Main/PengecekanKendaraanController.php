<?php

namespace App\Http\Controllers\Main;

use App\Exports\PengecekanCarExport;
use App\Exports\PengecekanDateExport;
use App\Http\Controllers\Controller;
use App\Models\PengecekanKendaraan;
use App\Models\PenugasanDriver;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PengecekanKendaraanController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');
        $data['pengecekan'] = DB::table('tb_pengecekan_kendaraan')
            ->select(
                'tb_pengecekan_kendaraan.id_pengecekan',
                'tb_pengecekan_kendaraan.id_kendaraan',
                'tb_pengecekan_kendaraan.tgl_pengecekan',
                'tb_pengecekan_kendaraan.jam_pengecekan',
                'tb_pengecekan_kendaraan.km_kendaraan',
                'tb_pengecekan_kendaraan.status_kendaraan',
                'tb_pengecekan_kendaraan.status_pengecekan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_driver.nama_driver'
            )
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_pengecekan_kendaraan.id_driver')
            // ->orderByDesc('tb_pengecekan_kendaraan.id_pengecekan')
            ->orderByRaw('CONVERT(tb_pengecekan_kendaraan.id_pengecekan, SIGNED) desc')
            ->get();

        $data['kendaraan'] = DB::table('tb_kendaraan')
            ->select(
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.kode_asset'
            )
            ->where('status', 'y')
            ->orderByDesc('id_kendaraan')
            ->get();
        // return $data;
        return view('dashboard.main.checking.index', $data);
    }

    public function updateVehicle(Request $request, $id)
    {
        $find = PenugasanDriver::where('id_do', $id)->first();
        $rules = [
            'id_kendaraan' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('success', 'Failed Change Vehicle');
        } else {
            $data = [
                'id_kendaraan' => $request->id_kendaraan,
                'status_pengecekan' => 'g'
            ];
            $updateVehicle = $find->update($data);
            if ($updateVehicle) {
                return redirect()->back()->with('success', 'Successed Change Vehicle');
            } else {
                return redirect()->back()->with('success', 'Failed Change Vehicle');
            }
        }
    }

    public function detail(Request $request, $id)
    {

        $data['pengecekan'] = DB::table('tb_pengecekan_kendaraan')
            ->select(
                'tb_pengecekan_kendaraan.id_pengecekan',
                'tb_pengecekan_kendaraan.tgl_pengecekan',
                'tb_pengecekan_kendaraan.jam_pengecekan',
                'tb_pengecekan_kendaraan.km_kendaraan',
                'tb_pengecekan_kendaraan.status_kendaraan',
                'tb_pengecekan_kendaraan.status_pengecekan',
                'tb_pengecekan_kendaraan.status_perbaikan',
                'tb_pengecekan_kendaraan.keterangan_pengecekan',
                'tb_kendaraan.kode_asset',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.warna',
                'tb_kendaraan.jenis_penggerak',
                'tb_merk_kendaraan.nama_merk as merk',
                'tb_jenis_kendaraan.nama_jenis as jenis',
                'tb_bahan_bakar.nama_bahan_bakar as bahan_bakar',
                'tb_driver.nama_driver'
            )
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_pengecekan_kendaraan.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
            ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
            ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
            ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
            ->where('id_pengecekan', $id)
            ->first();
        // return $data;
        $kriteria = DB::table('tb_kriteria_pengecekan')->where('status', 'y')->get();
        $hasil = array();
        foreach ($kriteria as  $krt) {
            $hasil_awal = array();
            $hasil_awal['id_kriteria'] = $krt->id_kriteria;
            $hasil_awal['nama_kriteria'] = $krt->nama_kriteria;
            $kedua = DB::table('tb_detail_pengecekan')->where([['id_kriteria', $krt->id_kriteria], ['id_pengecekan', $id]])
                ->leftJoin('tb_jenis_pengecekan', 'tb_jenis_pengecekan.id_jenis_pengecekan', '=', 'tb_detail_pengecekan.id_jenis_pengecekan')
                ->get();
            $hasil_awal['list_jenis'] = array();
            foreach ($kedua as $axx) {
                $hasil_dua = array();
                $hasil_dua['id_detail_pengecekan'] = $axx->id_detail_pengecekan;
                $hasil_dua['kondisi'] = $axx->kondisi;
                $hasil_dua['keterangan'] = $axx->keterangan;
                $hasil_dua['waktu'] = $axx->waktu_pengecekan;
                $hasil_dua['jenis'] = $axx->jenis_pengecekan;
                array_push($hasil_awal['list_jenis'], $hasil_dua);
            }
            array_push($hasil, $hasil_awal);
        }
        $data['detail_check'] = $hasil;
        $data['detail'] = DB::table('tb_detail_pengecekan')
            ->select(
                'tb_detail_pengecekan.id_detail_pengecekan',
                'tb_detail_pengecekan.kondisi',
                'tb_detail_pengecekan.keterangan',
                'tb_detail_pengecekan.waktu_pengecekan as waktu',
                'tb_kriteria_pengecekan.nama_kriteria as kriteria',
                'tb_jenis_pengecekan.jenis_pengecekan as jenis',
            )
            ->join('tb_jenis_pengecekan', 'tb_jenis_pengecekan.id_jenis_pengecekan', '=', 'tb_detail_pengecekan.id_jenis_pengecekan')
            ->join('tb_kriteria_pengecekan', 'tb_kriteria_pengecekan.id_kriteria', '=', 'tb_jenis_pengecekan.id_kriteria')
            ->where('id_pengecekan', $id)
            ->get();

        $data['foto'] = DB::table('tb_detail_foto_pengecekan')
            ->select(
                'tb_detail_foto_pengecekan.id_detail_foto_cek',
                'tb_detail_foto_pengecekan.foto_pengecekan',
                'tb_detail_foto_pengecekan.keterangan'
            )
            ->where('tb_detail_foto_pengecekan.id_pengecekan', $id)
            ->get();

        $data['dealer'] = DB::table('tb_dealer')
            ->select('id_dealer', 'nama_dealer', 'status_dealer')->where('status', 'y')->orderByDesc('id_dealer')->get();
        $latest_wo = DB::table('tb_persetujuan_perbaikan')
            ->select('no_wo')->orderByDesc('no_wo')
            ->first();
        if ($latest_wo == null) {
            $data['latest_wo'] = '12346';
        } else {
            $data['latest_wo'] = $latest_wo->no_wo + 1;
        }
        // return $data;
        return view('dashboard.main.checking.detail', $data);
    }

    public function exportCar($id)
    {
        $kendaraan = DB::table('tb_pengecekan_kendaraan')
            ->select(
                'tb_pengecekan_kendaraan.id_pengecekan',
                'tb_kendaraan.nama_kendaraan',
            )
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
            ->where('id_pengecekan', $id)
            ->first();
        return Excel::download(new PengecekanCarExport($id), 'Laporan_pengecekan_' . $kendaraan->nama_kendaraan . '.xlsx');
    }

    public function exportCarFilter(Request $request)
    {
        $tgl_pengecekan = $request->tgl_pengecekan;
        $id_kendaraan = $request->id_kendaraan;
        $tanggal = \Carbon\Carbon::parse($tgl_pengecekan)->translatedFormat('j F Y');
        $find = PengecekanKendaraan::where('tgl_pengecekan', $tgl_pengecekan)->get();
        if ($find->count() > 0) {
            if ($id_kendaraan != '') {
                $kendaraan = DB::table('tb_pengecekan_kendaraan')
                    ->select(
                        'tb_pengecekan_kendaraan.id_pengecekan',
                        'tb_kendaraan.nama_kendaraan',
                    )
                    ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
                    ->where('tb_pengecekan_kendaraan.id_kendaraan', $id_kendaraan)
                    ->first();
                return Excel::download(new PengecekanDateExport($id_kendaraan, $tgl_pengecekan), 'Laporan_pengecekan_' . $kendaraan->nama_kendaraan . '_tanggal_' . $tanggal . '.xlsx');
            } else {
                return Excel::download(new PengecekanDateExport($id_kendaraan, $tgl_pengecekan), 'Laporan_pengecekan_tanggal_' . $tanggal . '.xlsx');
            }
        } else {
            return redirect()->back()->with('success', 'Maaf, Tanggal pengecekan tidak ditemukan');
        }
    }

    public function exportPdf($id)
    {
        $data['pengecekan'] = DB::table('tb_pengecekan_kendaraan')
            ->select(
                'tb_pengecekan_kendaraan.id_pengecekan',
                'tb_pengecekan_kendaraan.tgl_pengecekan',
                'tb_pengecekan_kendaraan.jam_pengecekan',
                'tb_pengecekan_kendaraan.km_kendaraan',
                'tb_pengecekan_kendaraan.status_kendaraan',
                'tb_pengecekan_kendaraan.status_pengecekan',
                'tb_pengecekan_kendaraan.status_perbaikan',
                'tb_pengecekan_kendaraan.keterangan_pengecekan',
                'tb_kendaraan.kode_asset',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.warna',
                'tb_kendaraan.jenis_penggerak',
                'tb_kendaraan.tahun_kendaraan',
                'tb_merk_kendaraan.nama_merk as merk',
                'tb_jenis_kendaraan.nama_jenis as jenis',
                'tb_bahan_bakar.nama_bahan_bakar as bahan_bakar',
                'tb_driver.nama_driver'
            )
            ->join('tb_driver', 'tb_driver.id_driver', '=', 'tb_pengecekan_kendaraan.id_driver')
            ->join('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
            ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
            ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
            ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
            ->where('id_pengecekan', $id)
            ->first();
        // return $data;
        $kriteria = DB::table('tb_kriteria_pengecekan')->where('status', 'y')->get();
        $hasil = array();
        foreach ($kriteria as  $krt) {
            $hasil_awal = array();
            $hasil_awal['id_kriteria'] = $krt->id_kriteria;
            $hasil_awal['nama_kriteria'] = $krt->nama_kriteria;
            $kedua = DB::table('tb_detail_pengecekan')->where([['id_kriteria', $krt->id_kriteria], ['id_pengecekan', $id]])
                ->leftJoin('tb_jenis_pengecekan', 'tb_jenis_pengecekan.id_jenis_pengecekan', '=', 'tb_detail_pengecekan.id_jenis_pengecekan')
                ->get();
            $hasil_awal['list_jenis'] = array();
            foreach ($kedua as $axx) {
                $hasil_dua = array();
                $hasil_dua['id_detail_pengecekan'] = $axx->id_detail_pengecekan;
                $hasil_dua['kondisi'] = $axx->kondisi;
                $hasil_dua['keterangan'] = $axx->keterangan;
                $hasil_dua['waktu'] = $axx->waktu_pengecekan;
                $hasil_dua['jenis'] = $axx->jenis_pengecekan;
                array_push($hasil_awal['list_jenis'], $hasil_dua);
            }
            array_push($hasil, $hasil_awal);
        }
        $data['detail_check'] = $hasil;
        $data['detail'] = DB::table('tb_detail_pengecekan')
            ->select(
                'tb_detail_pengecekan.id_detail_pengecekan',
                'tb_detail_pengecekan.waktu_pengecekan as waktu',
            )
            ->join('tb_jenis_pengecekan', 'tb_jenis_pengecekan.id_jenis_pengecekan', '=', 'tb_detail_pengecekan.id_jenis_pengecekan')
            ->join('tb_kriteria_pengecekan', 'tb_kriteria_pengecekan.id_kriteria', '=', 'tb_jenis_pengecekan.id_kriteria')
            ->where('id_pengecekan', $id)
            ->get();
        // return view('dashboard.export.exPdfPengecekan', $data);
        // $pdf = PDF::loadView('dashboard.export.exPdfPengecekan', $data)->setPaper('f4');
        $pdf = FacadePdf::loadView('dashboard.export.exPdfPengecekan', $data)->setPaper('f4', 'portrait');
        set_time_limit(60);

        return $pdf->download('laporan_pengecekan_' . $data['pengecekan']->nama_kendaraan . '.pdf');
    }

    public function exportPdfFilter(Request $request)
    {
        $tgl = $request->query('tgl_pengecekan');
        $month = Carbon::parse($tgl)->format('m');
        $year = Carbon::parse($tgl)->format('Y');
        $status = $request->query('status');; //$request->status;
        $data['filter'] = [
            'bulan' => $tgl,
            'status' => $status,
        ];
        $data['pengecekan'] = DB::table('tb_pengecekan_kendaraan')
            ->select(
                'tb_pengecekan_kendaraan.id_pengecekan',
                'tb_pengecekan_kendaraan.id_kendaraan',
                'tb_pengecekan_kendaraan.tgl_pengecekan',
                'tb_pengecekan_kendaraan.jam_pengecekan',
                'tb_pengecekan_kendaraan.km_kendaraan',
                'tb_pengecekan_kendaraan.status_kendaraan',
                'tb_pengecekan_kendaraan.status_pengecekan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_driver.nama_driver'
            )
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_pengecekan_kendaraan.id_driver')
            ->when($status != '', function ($filter) use ($status) {
                $filter->where('tb_pengecekan_kendaraan.status_kendaraan', $status);
            })
            ->whereMonth('tb_pengecekan_kendaraan.tgl_pengecekan', $month)
            ->whereYear('tb_pengecekan_kendaraan.tgl_pengecekan', $year)
            ->orderByRaw('CONVERT(tb_pengecekan_kendaraan.id_pengecekan, SIGNED) asc')
            ->get();

        if ($data['pengecekan']->count() > 0) {
            // return $data;
            $pdf = FacadePdf::loadView('dashboard.export.exPdfPengecekanFilter', $data)->setPaper('f4', 'portrait');
            set_time_limit(60);

            return $pdf->download('laporan_penggecekan_bulan_' . $tgl . '.pdf');
        } else {
            return redirect()->back()->with('success', 'Maaf, Data tidak ditemukan');
        }
    }
}
