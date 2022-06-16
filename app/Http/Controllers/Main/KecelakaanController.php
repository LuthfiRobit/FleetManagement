<?php

namespace App\Http\Controllers\Main;

use App\Exports\KecelakaanExportDate;
use App\Exports\KecelakaanExportOne;
use App\Http\Controllers\Controller;
use App\Models\Kecelakaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;

class KecelakaanController extends Controller
{
    public function index(Request $request)
    {
        $data['kecelakaan'] = DB::table('tb_kecelakaan')
            ->select(
                'tb_kecelakaan.id_kecelakaan',
                'tb_kecelakaan.id_do',
                'tb_order_kendaraan.no_so',
                'tb_kendaraan.nama_kendaraan as kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kecelakaan.tgl_kecelakaan as tgl',
                'tb_kecelakaan.jam_kecelakaan as jam',
                'tb_kecelakaan.lokasi_kejadian as lokasi',
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_kecelakaan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_kecelakaan')
            ->get();

        // return $data;
        return view('dashboard.main.accident.index', $data);
    }

    public function detail(Request $request, $id)
    {
        $data['kecelakaan'] = DB::table('tb_kecelakaan')
            ->select(
                'tb_kecelakaan.id_kecelakaan',
                'tb_kecelakaan.id_do',
                'tb_order_kendaraan.no_so',
                'tb_order_kendaraan.tujuan',
                'tb_kecelakaan.tgl_kecelakaan as tgl',
                'tb_kecelakaan.jam_kecelakaan as jam',
                'tb_kecelakaan.lokasi_kejadian as lokasi',
                'tb_kecelakaan.kronologi',
                'tb_kendaraan.kode_asset',
                'tb_kendaraan.nama_kendaraan as kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.warna',
                'tb_kendaraan.jenis_penggerak',
                'tb_merk_kendaraan.nama_merk as merk',
                'tb_jenis_kendaraan.nama_jenis as jenis',
                'tb_bahan_bakar.nama_bahan_bakar as bahan_bakar',
                'tb_driver.nama_driver',
                'tb_petugas.nama_lengkap as atasan',
                'tb_detail_so.nama_penumpang as saksi'
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_kecelakaan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
            ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
            ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_saksi_kecelakaan', 'tb_saksi_kecelakaan.id_kecelakaan', '=', 'tb_kecelakaan.id_kecelakaan')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_saksi_kecelakaan.id_atasan')
            ->leftJoin('tb_detail_so', 'tb_detail_so.id_detail_so', '=', 'tb_saksi_kecelakaan.id_saksi')
            ->where('tb_kecelakaan.id_kecelakaan', $id)
            ->first();

        $data['kerusakan'] = DB::table('tb_detail_foto_kecelakaan as tb_foto')
            ->select(
                'tb_foto.foto_pendukung',
                'tb_foto.keterangan'
            )
            ->where('id_kecelakaan',  $data['kecelakaan']->id_kecelakaan)
            ->get();

        // return $data;

        return view('dashboard.main.accident.detail', $data);
    }

    public function exportAcdFilter(Request $request)
    {
        $tgl_kecelakaan = $request->tgl_kecelakaan;
        $tanggal = \Carbon\Carbon::parse($tgl_kecelakaan)->translatedFormat('j F Y');
        $find = Kecelakaan::where('tgl_kecelakaan', $tgl_kecelakaan)->get();
        // return $find;
        if ($find->count() > 0) {
            return Excel::download(new KecelakaanExportDate($tgl_kecelakaan), 'Laporan_kecelakaan_tanggal_' . $tanggal . '.xlsx');
        } else {
            return redirect()->back()->with('success', 'Maaf, Tanggal kecelakaan tidak ditemukan');
        }
    }

    public function exportOne($id)
    {
        $find = Kecelakaan::select('id_kecelakaan')->where('id_kecelakaan', $id)->first();
        if ($find) {
            return Excel::download(new KecelakaanExportOne($id), 'Laporan_kecelakaan_ACD' . $find->id_kecelakaan . '.xlsx');
        } else {
            return redirect()->back()->with('success', 'Maaf, Data kecelakaan tidak ditemukan');
        }
    }

    public function exportPdfOne($id)
    {
        $data['kecelakaan'] = DB::table('tb_kecelakaan')
            ->select(
                'tb_kecelakaan.id_kecelakaan',
                'tb_kecelakaan.id_do',
                'tb_order_kendaraan.no_so',
                'tb_order_kendaraan.tujuan',
                'tb_kecelakaan.tgl_kecelakaan as tgl',
                'tb_kecelakaan.jam_kecelakaan as jam',
                'tb_kecelakaan.lokasi_kejadian as lokasi',
                'tb_kecelakaan.kronologi',
                'tb_kendaraan.kode_asset',
                'tb_kendaraan.nama_kendaraan as kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.warna',
                'tb_kendaraan.jenis_penggerak',
                'tb_merk_kendaraan.nama_merk as merk',
                'tb_jenis_kendaraan.nama_jenis as jenis',
                'tb_bahan_bakar.nama_bahan_bakar as bahan_bakar',
                'tb_driver.nama_driver',
                'tb_petugas.nama_lengkap as atasan',
                'tb_detail_so.nama_penumpang as saksi'
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_kecelakaan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
            ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
            ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_saksi_kecelakaan', 'tb_saksi_kecelakaan.id_kecelakaan', '=', 'tb_kecelakaan.id_kecelakaan')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_saksi_kecelakaan.id_atasan')
            ->leftJoin('tb_detail_so', 'tb_detail_so.id_detail_so', '=', 'tb_saksi_kecelakaan.id_saksi')
            ->where('tb_kecelakaan.id_kecelakaan', $id)
            ->first();
        if ($data['kecelakaan']) {
            $pdf = FacadePdf::loadView('dashboard.export.exPdfKecelakaanOne', $data)->setPaper('f4', 'portrait');
            set_time_limit(60);
            return $pdf->download('laporan_kecalakaan_acd_' . $data['kecelakaan']->id_kecelakaan . '.pdf');
        } else {
            return redirect()->back()->with('success', 'Maaf, Data tidak ditemukan');
        }
    }

    public function exportPdfFilter(Request $request)
    {
        $tgl = $request->query('tgl_kecelakaan');
        $month = Carbon::parse($tgl)->format('m');
        $year = Carbon::parse($tgl)->format('Y');
        $data['filter'] = [
            'bulan' => $tgl
        ];
        $data['kecelakaan'] = DB::table('tb_kecelakaan')
            ->select(
                'tb_kecelakaan.id_kecelakaan',
                'tb_kecelakaan.id_do',
                'tb_order_kendaraan.no_so',
                'tb_kendaraan.nama_kendaraan as kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kecelakaan.tgl_kecelakaan as tgl',
                'tb_kecelakaan.jam_kecelakaan as jam',
                'tb_kecelakaan.lokasi_kejadian as lokasi',
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_kecelakaan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->whereMonth('tb_kecelakaan.tgl_kecelakaan', $month)
            ->whereYear('tb_kecelakaan.tgl_kecelakaan', $year)
            ->orderBy('tb_kecelakaan.tgl_kecelakaan')
            ->get();
        if ($data['kecelakaan']->count() > 0) {
            $pdf = FacadePdf::loadView('dashboard.export.exPdfKecelakaanFilter', $data)->setPaper('f4', 'portrait');
            set_time_limit(60);
            return $pdf->download('laporan_kecelakaan_bulan_' . $tgl . '.pdf');
        } else {
            return redirect()->back()->with('success', 'Maaf, Data tidak ditemukan');
        }
    }
}
