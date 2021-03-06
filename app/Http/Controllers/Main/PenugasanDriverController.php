<?php

namespace App\Http\Controllers\Main;

use App\Exports\PenugasanDepartemenExportAll;
use App\Exports\PenugasanDepartemenExportMonth;
use App\Http\Controllers\Controller;
use App\Models\PenugasanBatal;
use App\Models\PenugasanDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class PenugasanDriverController extends Controller
{
    public function index(Request $request)
    {
        $data['assignment'] = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_order_kendaraan.no_so',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan as status_do',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_driver.nama_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_pemesan.nama_lengkap as nama_pemesan',
                'tb_departemen_pemesan.nama_departemen as departemen_pemesan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi'
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_petugas as tb_pemesan', 'tb_pemesan.id_petugas', '=', 'tb_order_kendaraan.id_pemesan')
            ->leftJoin('tb_departemen as tb_departemen_pemesan', 'tb_departemen_pemesan.id_departemen', '=', 'tb_pemesan.id_departemen')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_do')
            ->get();
        // return $data;
        return view('dashboard.main.assignment.index', $data);
    }

    public function detail(Request $request, $id)
    {
        $data['detail'] = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_service_order',
                'tb_penugasan_driver.id_driver',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.status_penugasan as status_do',
                'tb_penugasan_driver.tgl_selesai',
                'tb_penugasan_driver.km_awal',
                'tb_penugasan_driver.km_akhir',
                'tb_penugasan_driver.status_bbm_awal as bbm_awal',
                'tb_penugasan_driver.status_bbm_akhir as bbm_akhir',
                'tb_penugasan_driver.keterangan_bbm',
                'tb_penugasan_driver.waktu_start',
                'tb_penugasan_driver.waktu_finish',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_order_kendaraan.keterangan',
                'tb_order_kendaraan.no_so',
                'tb_order_kendaraan.status_tujuan',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_driver.nama_driver',
                'tb_petugas.no_tlp as p_tlp',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.warna',
                'tb_kendaraan.jenis_penggerak',
                'tb_merk_kendaraan.nama_merk as merk',
                'tb_jenis_kendaraan.nama_jenis as jenis',
                'tb_bahan_bakar.nama_bahan_bakar as bahan_bakar',
                'tb_pemesan.nama_lengkap as nama_pemesan',
                'tb_departemen_pemesan.nama_departemen as departemen_pemesan'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->rightJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_petugas as tb_pemesan', 'tb_pemesan.id_petugas', '=', 'tb_order_kendaraan.id_pemesan')
            ->leftJoin('tb_departemen as tb_departemen_pemesan', 'tb_departemen_pemesan.id_departemen', '=', 'tb_pemesan.id_departemen')
            ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
            ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
            ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
            ->where('id_do', $id)
            ->orderByDesc('id_do')
            ->first();

        $data['driver'] = DB::table('tb_driver')
            ->select(
                'tb_driver.nama_driver',
                'tb_driver.no_tlp as d_tlp',
                'tb_driver.foto_driver',
                'tb_departemen.nama_departemen as departemen'
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_driver.id_driver', $data['detail']->id_driver)
            ->first();

        $data['penumpang'] = DB::table('tb_detail_so')
            ->select(
                'tb_detail_so.id_detail_so',
                'tb_detail_so.nama_penumpang',
                'tb_detail_so.no_tlp',
                'tb_detail_so.jabatan as nama_jabatan',
                'tb_detail_so.status'
            )
            ->orderByDesc('id_detail_so')
            ->where('id_service_order', $data['detail']->id_service_order)->get();

        // return $data;
        return view('dashboard.main.assignment.detail', $data);
    }

    //for pembatalan
    public function indexbatal(Request $request)
    {
        $data['batal'] = DB::table('tb_pembatalan_penugasan')
            ->select(
                'tb_pembatalan_penugasan.id_pembatalan',
                'tb_pembatalan_penugasan.id_do',
                'tb_pembatalan_penugasan.id_driver',
                'tb_pembatalan_penugasan.alasan_pembatalan as alasan',
                'tb_pembatalan_penugasan.tanggal',
                'tb_pembatalan_penugasan.status_pembatalan',
                'tb_driver.nama_driver',
                'tb_order_kendaraan.no_so'
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pembatalan_penugasan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_pembatalan_penugasan.id_driver')
            ->orderByDesc('tb_pembatalan_penugasan.id_pembatalan')
            ->get();

        // return $data;
        return view('dashboard.main.assignmentbatal.index', $data);
    }

    public function detailbatal(Request $request, $id)
    {
        $data['batal'] = DB::table('tb_pembatalan_penugasan')
            ->select(
                'tb_pembatalan_penugasan.id_pembatalan',
                'tb_pembatalan_penugasan.id_do',
                'tb_pembatalan_penugasan.id_driver',
                'tb_pembatalan_penugasan.alasan_pembatalan as alasan',
                'tb_pembatalan_penugasan.tanggal',
                'tb_pembatalan_penugasan.status_pembatalan',
                'tb_pembatalan_penugasan.bukti',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.id_kendaraan',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.id_jenis_sim',
                'tb_jenis_sim.nama_sim',
                'tb_order_kendaraan.no_so'
            )
            ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_do', '=', 'tb_pembatalan_penugasan.id_do')
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_jenis_sim', 'tb_jenis_sim.id_jenis_sim', '=', 'tb_kendaraan.id_jenis_sim')
            ->where('tb_pembatalan_penugasan.id_pembatalan', $id)
            ->first();
        $id_driver = $data['batal']->id_driver;
        $id_sim = $data['batal']->id_jenis_sim;
        $tgl_tugas = $data['batal']->tgl_penugasan;

        $data['driver'] = DB::table('tb_driver')
            ->select(
                'tb_driver.nama_driver',
                'tb_driver.no_tlp',
                'tb_driver.foto_driver',
                'tb_departemen.nama_departemen as departemen',
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_driver.id_driver', $data['batal']->id_driver)
            ->first();
        $data['history'] = PenugasanBatal::where('id_driver', $data['batal']->id_driver)->count();
        $data['terima'] = PenugasanBatal::where([['id_driver', $data['batal']->id_driver], ['status_pembatalan', 't']])->count();
        $data['tolak'] = PenugasanBatal::where([['id_driver', $data['batal']->id_driver], ['status_pembatalan', 'tl']])->count();

        $data['drivers'] = DB::select(
            "SELECT tb_driver.id_driver, tb_driver.no_badge, tb_driver.nama_driver FROM tb_driver
            -- LEFT JOIN tb_detail_sim on tb_detail_sim.id_driver = tb_driver.id_driver
            WHERE tb_driver.status_driver = 'y'
            AND NOT EXISTS (SELECT id_driver FROM tb_status_driver WHERE tb_status_driver.id_driver = tb_driver.id_driver
            AND tb_status_driver.status = 'n' UNION SELECT id_driver FROM tb_penugasan_driver WHERE tb_penugasan_driver.id_driver = tb_driver.id_driver
            AND tb_penugasan_driver.tgl_penugasan = '$tgl_tugas' AND tb_penugasan_driver.status_penugasan = 'p'  )"
        );

        // return $data;
        return view('dashboard.main.assignmentbatal.detail', $data);
    }

    public function terimabatal(Request $request)
    {
        $id_pembatalan = $request->id_pembatalan;
        $id_do = $request->id_do;

        $find_pembatalan = PenugasanBatal::where('id_pembatalan', $id_pembatalan)->first();
        if ($find_pembatalan) {
            $find_pembatalan->update(['status_pembatalan' => 't']);
            $find_do = PenugasanDriver::where('id_do', $id_do)->first();
            $data = [
                'id_driver' => $request->id_driver_baru
            ];
            $find_do->update($data);
            return redirect()->back()->with('success', 'Terima Pembatalan Berhasil Diproses');
        } else {
            return redirect()->back()->with('success', 'Terima Pembatalan Gagal Diproses');
        }
    }

    public function tolakbatal(Request $request, $id)
    {
        // $id_do = $request->get('id_do');
        // $id_driver = $request->get('id_driver');
        $find = PenugasanBatal::where('id_pembatalan', $id)->first();
        if ($find) {
            // return $find;
            $find->update(['status_pembatalan' => 'tl']);
            return redirect()->back()->with('success', 'Tolak Pembatalan Berhasil Diproses');
        } else {
            // return $find;
            return redirect()->back()->with('success', 'Tolak Pembatalan Gagal Diproses');
        }
    }

    //export penugasan

    public function exportPdfPenugasan($id)
    {
        $data['detail'] = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_service_order',
                'tb_penugasan_driver.id_driver',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_penugasan_driver.kembali',
                'tb_penugasan_driver.status_penugasan as status_do',
                'tb_penugasan_driver.tgl_selesai',
                'tb_penugasan_driver.km_awal',
                'tb_penugasan_driver.km_akhir',
                'tb_penugasan_driver.status_bbm_awal as bbm_awal',
                'tb_penugasan_driver.status_bbm_akhir as bbm_akhir',
                'tb_penugasan_driver.keterangan_bbm',
                'tb_penugasan_driver.waktu_start',
                'tb_penugasan_driver.waktu_finish',
                'tb_order_kendaraan.tempat_penjemputan',
                'tb_order_kendaraan.tujuan',
                'tb_order_kendaraan.no_so',
                'tb_order_kendaraan.keterangan',
                'tb_order_kendaraan.status_tujuan',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_driver.nama_driver',
                'tb_petugas.no_tlp as p_tlp',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.kode_asset',
                'tb_kendaraan.warna',
                'tb_kendaraan.jenis_penggerak',
                'tb_merk_kendaraan.nama_merk as merk',
                'tb_jenis_kendaraan.nama_jenis as jenis',
                'tb_bahan_bakar.nama_bahan_bakar as bahan_bakar',
                'tb_pemesan.nama_lengkap as nama_pemesan',
                'tb_departemen_pemesan.nama_departemen as departemen_pemesan'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->rightJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_petugas as tb_pemesan', 'tb_pemesan.id_petugas', '=', 'tb_order_kendaraan.id_pemesan')
            ->leftJoin('tb_departemen as tb_departemen_pemesan', 'tb_departemen_pemesan.id_departemen', '=', 'tb_pemesan.id_departemen')
            ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
            ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
            ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
            ->where('id_do', $id)
            ->orderByDesc('id_do')
            ->first();

        $data['driver'] = DB::table('tb_driver')
            ->select(
                'tb_driver.nama_driver',
                'tb_driver.no_tlp as d_tlp',
                'tb_driver.foto_driver',
                'tb_departemen.nama_departemen as departemen'
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_driver.id_driver', $data['detail']->id_driver)
            ->first();

        $data['penumpang'] = DB::table('tb_detail_so')
            ->select(
                'tb_detail_so.id_detail_so',
                'tb_detail_so.nama_penumpang',
                'tb_detail_so.no_tlp',
                'tb_detail_so.jabatan as nama_jabatan'
            )
            ->orderByDesc('id_detail_so')
            ->where('id_service_order', $data['detail']->id_service_order)->get();

        // return $data;
        // return view('dashboard.export.exPdfPenugasan', $data);
        $pdf = FacadePdf::loadView('dashboard.export.exPdfPenugasan', $data)->setPaper('f4', 'portrait');
        set_time_limit(60);

        return $pdf->download('laporan_penugasan_DO_' . $data['detail']->no_so . '.pdf');
    }

    public function exportPdfFilter(Request $request)
    {
        $tgl = $request->query('tgl_penjemputan');
        $month = Carbon::parse($tgl)->format('m');
        $year = Carbon::parse($tgl)->format('Y');
        $data['bulan'] = Carbon::parse($tgl)->format('F Y');
        $data['assignment'] = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_order_kendaraan.no_so',
                'tb_penugasan_driver.tgl_acc',
                'tb_penugasan_driver.status_penugasan as status_do',
                'tb_penugasan_driver.tgl_penugasan',
                'tb_penugasan_driver.jam_berangkat',
                'tb_driver.nama_driver',
                'tb_petugas.nama_lengkap as nama_petugas',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_pemesan.nama_lengkap as nama_pemesan',
                'tb_departemen_pemesan.nama_departemen as departemen_pemesan'
            )
            ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_service_order', '=', 'tb_penugasan_driver.id_service_order')
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_petugas', 'tb_petugas.id_petugas', '=', 'tb_penugasan_driver.id_petugas')
            ->leftJoin('tb_petugas as tb_pemesan', 'tb_pemesan.id_petugas', '=', 'tb_order_kendaraan.id_pemesan')
            ->leftJoin('tb_departemen as tb_departemen_pemesan', 'tb_departemen_pemesan.id_departemen', '=', 'tb_pemesan.id_departemen')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->orderByDesc('id_do')
            ->whereMonth('tb_penugasan_driver.tgl_penugasan', $month)
            ->whereYear('tb_penugasan_driver.tgl_penugasan', $year)
            ->get();
        if ($data['assignment']->count() > 0) {

            // return view('dashboard.export.exPdfPenugasanFilter', $data);
            // return $data;
            $pdf = FacadePdf::loadView('dashboard.export.exPdfPenugasanFilter', $data)->setPaper('f4', 'portrait');
            set_time_limit(60);

            return $pdf->download('laporan_penugasan_bulan_' . $tgl . '.pdf');
        } else {
            return redirect()->back()->with('success', 'Maaf, Bulan penugasan tidak ditemukan');
        }
    }

    //history

    public function indexHistory(Request $request)
    {
        $status = $request->status;

        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        $bulan = $request->query('bulan');
        $month = Carbon::parse($bulan)->format('m');
        $year = Carbon::parse($bulan)->format('Y');

        if ($status == '') {

            $data['history'] = DB::table('tb_driver')
                ->select(
                    'tb_driver.id_driver',
                    'tb_driver.nama_driver',
                    'tb_driver.no_tlp',
                    DB::raw('COUNT(tb_penugasan_driver.id_driver) as jumlah_all'),
                    DB::raw('(SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE tb_penugasan_driver.status_penugasan is null AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_menunggu,
                    (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE tb_penugasan_driver.status_penugasan = "t" AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_terima,
                    (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE tb_penugasan_driver.status_penugasan = "p" AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_perjalanan,
                    (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE tb_penugasan_driver.status_penugasan = "s" AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_selesai,
                    (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE tb_penugasan_driver.status_penugasan = "c" AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_batal')
                )
                ->leftJoin('tb_penugasan_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
                ->groupBy('tb_driver.id_driver', 'tb_driver.nama_driver', 'tb_driver.no_tlp')
                // ->where('tb_penugasan_driver.status_penugasan', '!=', 'c')
                ->orderByDesc(DB::raw('jumlah_all'))
                ->get()
                ->map(
                    function ($foto) {
                        return [
                            'id_driver' => $foto->id_driver,
                            'nama_driver' => $foto->nama_driver,
                            'no_tlp' => $foto->no_tlp,
                            'history' => [
                                'jumlah_all' => $foto->jumlah_all,
                                'jumlah_menunggu' => $foto->jumlah_menunggu,
                                'jumlah_terima' => $foto->jumlah_terima,
                                'jumlah_perjalan' => $foto->jumlah_perjalanan,
                                'jumlah_selesai' => $foto->jumlah_selesai,
                                'jumlah_batal' => $foto->jumlah_batal
                            ]
                        ];
                    }
                );

            return view(
                'dashboard.main.assignment.history',
                $data
            );
        } else {
            if ($status == 'h') {
                $data['history'] = DB::table('tb_driver')
                    ->select(
                        'tb_driver.id_driver',
                        'tb_driver.nama_driver',
                        'tb_driver.no_tlp',
                        DB::raw('COUNT(tb_penugasan_driver.id_driver) as jumlah_all'),
                        DB::raw("
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE (tb_penugasan_driver.tgl_penugasan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND tb_penugasan_driver.status_penugasan is null AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_menunggu,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE (tb_penugasan_driver.tgl_penugasan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND tb_penugasan_driver.status_penugasan = 't' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_terima,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE (tb_penugasan_driver.tgl_penugasan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND tb_penugasan_driver.status_penugasan = 'p' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_perjalanan,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE (tb_penugasan_driver.tgl_penugasan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND tb_penugasan_driver.status_penugasan = 's' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_selesai,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE (tb_penugasan_driver.tgl_penugasan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND tb_penugasan_driver.status_penugasan = 'c' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_batal
                        ")
                    )
                    ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_driver', '=', 'tb_driver.id_driver')
                    ->whereBetween('tb_penugasan_driver.tgl_penugasan', [$tgl_awal, $tgl_akhir])
                    ->groupBy('tb_driver.id_driver', 'tb_driver.nama_driver', 'tb_driver.no_tlp')
                    ->orderByDesc(DB::raw('jumlah_all'))
                    ->get()
                    ->map(
                        function ($foto) {
                            return [
                                'id_driver' => $foto->id_driver,
                                'nama_driver' => $foto->nama_driver,
                                'no_tlp' => $foto->no_tlp,
                                'history' => [
                                    'jumlah_all' => $foto->jumlah_all,
                                    'jumlah_menunggu' => $foto->jumlah_menunggu,
                                    'jumlah_terima' => $foto->jumlah_terima,
                                    'jumlah_perjalan' => $foto->jumlah_perjalanan,
                                    'jumlah_selesai' => $foto->jumlah_selesai,
                                    'jumlah_batal' => $foto->jumlah_batal
                                ]
                            ];
                        }
                    );
                return view(
                    'dashboard.main.assignment.history',
                    $data
                );
            } else if ($status == 'b') {
                $data['history'] = DB::table('tb_driver')
                    ->select(
                        'tb_driver.id_driver',
                        'tb_driver.nama_driver',
                        'tb_driver.no_tlp',
                        DB::raw('COUNT(tb_penugasan_driver.id_driver) as jumlah_all'),
                        DB::raw("
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver 
                        WHERE YEAR(tb_penugasan_driver.tgl_penugasan) = $year AND MONTH(tb_penugasan_driver.tgl_penugasan) = $month AND tb_penugasan_driver.status_penugasan is null AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_menunggu,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver 
                        WHERE YEAR(tb_penugasan_driver.tgl_penugasan) = $year AND MONTH(tb_penugasan_driver.tgl_penugasan) = $month AND tb_penugasan_driver.status_penugasan = 't' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_terima,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver 
                        WHERE YEAR(tb_penugasan_driver.tgl_penugasan) = $year AND MONTH(tb_penugasan_driver.tgl_penugasan) = $month AND tb_penugasan_driver.status_penugasan = 'p' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_perjalanan,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver 
                        WHERE YEAR(tb_penugasan_driver.tgl_penugasan) = $year AND MONTH(tb_penugasan_driver.tgl_penugasan) = $month AND tb_penugasan_driver.status_penugasan = 's' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_selesai,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver 
                        WHERE YEAR(tb_penugasan_driver.tgl_penugasan) = $year AND MONTH(tb_penugasan_driver.tgl_penugasan) = $month AND tb_penugasan_driver.status_penugasan = 'c' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_batal
                        ")
                    )
                    ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_driver', '=', 'tb_driver.id_driver')
                    ->whereMonth('tb_penugasan_driver.tgl_penugasan', $month)
                    ->whereYear('tb_penugasan_driver.tgl_penugasan', $year)
                    ->groupBy('tb_driver.id_driver', 'tb_driver.nama_driver', 'tb_driver.no_tlp')
                    ->orderByDesc(DB::raw('jumlah_all'))
                    ->get()
                    ->map(
                        function ($foto) {
                            return [
                                'id_driver' => $foto->id_driver,
                                'nama_driver' => $foto->nama_driver,
                                'no_tlp' => $foto->no_tlp,
                                'history' => [
                                    'jumlah_all' => $foto->jumlah_all,
                                    'jumlah_menunggu' => $foto->jumlah_menunggu,
                                    'jumlah_terima' => $foto->jumlah_terima,
                                    'jumlah_perjalan' => $foto->jumlah_perjalanan,
                                    'jumlah_selesai' => $foto->jumlah_selesai,
                                    'jumlah_batal' => $foto->jumlah_batal
                                ]
                            ];
                        }
                    );

                return view(
                    'dashboard.main.assignment.history',
                    $data
                );
            } else {
                abort(403, 'Unauthorized action.');
            }
        }
    }

    public function exportPdfHistory(Request $request)
    {
        $status = $request->status;

        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        $bulan = $request->query('bulan');
        $month = Carbon::parse($bulan)->format('m');
        $year = Carbon::parse($bulan)->format('Y');
        if ($status == '') {
            $data['filter'] = [
                'status' => $status,
                'bulan' => $bulan,
                'tgl_awal' => $tgl_awal,
                'tgl_akhir' => $tgl_akhir
            ];
            // return $data;
            $data['history'] = DB::table('tb_driver')
                ->select(
                    'tb_driver.id_driver',
                    'tb_driver.nama_driver',
                    'tb_driver.no_tlp',
                    DB::raw('COUNT(tb_penugasan_driver.id_driver) as jumlah_all'),
                    DB::raw('(SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE tb_penugasan_driver.status_penugasan is null AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_menunggu,
                    (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE tb_penugasan_driver.status_penugasan = "t" AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_terima,
                    (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE tb_penugasan_driver.status_penugasan = "p" AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_perjalanan,
                    (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE tb_penugasan_driver.status_penugasan = "s" AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_selesai,
                    (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE tb_penugasan_driver.status_penugasan = "c" AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_batal')
                )
                ->leftJoin('tb_penugasan_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
                ->groupBy('tb_driver.id_driver', 'tb_driver.nama_driver', 'tb_driver.no_tlp')
                // ->where('tb_penugasan_driver.status_penugasan', '!=', 'c')
                ->orderByDesc(DB::raw('jumlah_all'))
                ->get()
                ->map(
                    function ($foto) {
                        return [
                            'id_driver' => $foto->id_driver,
                            'nama_driver' => $foto->nama_driver,
                            'no_tlp' => $foto->no_tlp,
                            'history' => [
                                'jumlah_all' => $foto->jumlah_all,
                                'jumlah_menunggu' => $foto->jumlah_menunggu,
                                'jumlah_terima' => $foto->jumlah_terima,
                                'jumlah_perjalan' => $foto->jumlah_perjalanan,
                                'jumlah_selesai' => $foto->jumlah_selesai,
                                'jumlah_batal' => $foto->jumlah_batal
                            ]
                        ];
                    }
                );
            if ($data['history']->count() > 0) {
                // return $data;
                $pdf = FacadePdf::loadView('dashboard.export.exPdfPenugasanHistory', $data)->setPaper('f4', 'portrait');
                set_time_limit(60);

                return $pdf->download('laporan_history_penugasan_all.pdf');
            } else {
                return redirect()->back()->with('success', 'Maaf, Data tidak ditemukan');
            }
        } else {
            if ($status == 'h') {
                $data['filter'] = [
                    'status' => $status,
                    'bulan' => $bulan,
                    'tgl_awal' => $tgl_awal,
                    'tgl_akhir' => $tgl_akhir
                ];
                $data['history'] = DB::table('tb_driver')
                    ->select(
                        'tb_driver.id_driver',
                        'tb_driver.nama_driver',
                        'tb_driver.no_tlp',
                        DB::raw('COUNT(tb_penugasan_driver.id_driver) as jumlah_all'),
                        DB::raw("
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE (tb_penugasan_driver.tgl_penugasan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND tb_penugasan_driver.status_penugasan is null AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_menunggu,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE (tb_penugasan_driver.tgl_penugasan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND tb_penugasan_driver.status_penugasan = 't' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_terima,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE (tb_penugasan_driver.tgl_penugasan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND tb_penugasan_driver.status_penugasan = 'p' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_perjalanan,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE (tb_penugasan_driver.tgl_penugasan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND tb_penugasan_driver.status_penugasan = 's' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_selesai,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver WHERE (tb_penugasan_driver.tgl_penugasan BETWEEN '$tgl_awal' AND '$tgl_akhir') AND tb_penugasan_driver.status_penugasan = 'c' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_batal
                        ")
                    )
                    ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_driver', '=', 'tb_driver.id_driver')
                    ->whereBetween('tb_penugasan_driver.tgl_penugasan', [$tgl_awal, $tgl_akhir])
                    ->groupBy('tb_driver.id_driver', 'tb_driver.nama_driver', 'tb_driver.no_tlp')
                    ->orderByDesc(DB::raw('jumlah_all'))
                    ->get()
                    ->map(
                        function ($foto) {
                            return [
                                'id_driver' => $foto->id_driver,
                                'nama_driver' => $foto->nama_driver,
                                'no_tlp' => $foto->no_tlp,
                                'history' => [
                                    'jumlah_all' => $foto->jumlah_all,
                                    'jumlah_menunggu' => $foto->jumlah_menunggu,
                                    'jumlah_terima' => $foto->jumlah_terima,
                                    'jumlah_perjalan' => $foto->jumlah_perjalanan,
                                    'jumlah_selesai' => $foto->jumlah_selesai,
                                    'jumlah_batal' => $foto->jumlah_batal
                                ]
                            ];
                        }
                    );
                if ($data['history']->count() > 0) {
                    // return $data;
                    $pdf = FacadePdf::loadView('dashboard.export.exPdfPenugasanHistory', $data)->setPaper('f4', 'portrait');
                    set_time_limit(60);

                    return $pdf->download('laporan_history_penugasan_tgl' . $tgl_awal . '-' . $tgl_akhir . '.pdf');
                } else {
                    return redirect()->back()->with('success', 'Maaf, Data tidak ditemukan');
                }
            } else if ($status == 'b') {
                $data['filter'] = [
                    'status' => $status,
                    'bulan' => $bulan,
                    'tgl_awal' => $tgl_awal,
                    'tgl_akhir' => $tgl_akhir
                ];
                $data['history'] = DB::table('tb_driver')
                    ->select(
                        'tb_driver.id_driver',
                        'tb_driver.nama_driver',
                        'tb_driver.no_tlp',
                        DB::raw('COUNT(tb_penugasan_driver.id_driver) as jumlah_all'),
                        DB::raw("
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver 
                        WHERE YEAR(tb_penugasan_driver.tgl_penugasan) = $year AND MONTH(tb_penugasan_driver.tgl_penugasan) = $month AND tb_penugasan_driver.status_penugasan is null AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_menunggu,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver 
                        WHERE YEAR(tb_penugasan_driver.tgl_penugasan) = $year AND MONTH(tb_penugasan_driver.tgl_penugasan) = $month AND tb_penugasan_driver.status_penugasan = 't' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_terima,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver 
                        WHERE YEAR(tb_penugasan_driver.tgl_penugasan) = $year AND MONTH(tb_penugasan_driver.tgl_penugasan) = $month AND tb_penugasan_driver.status_penugasan = 'p' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_perjalanan,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver 
                        WHERE YEAR(tb_penugasan_driver.tgl_penugasan) = $year AND MONTH(tb_penugasan_driver.tgl_penugasan) = $month AND tb_penugasan_driver.status_penugasan = 's' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_selesai,
                        (SELECT COUNT(tb_penugasan_driver.id_driver) FROM tb_penugasan_driver 
                        WHERE YEAR(tb_penugasan_driver.tgl_penugasan) = $year AND MONTH(tb_penugasan_driver.tgl_penugasan) = $month AND tb_penugasan_driver.status_penugasan = 'c' AND tb_penugasan_driver.id_driver = tb_driver.id_driver) as jumlah_batal
                        ")
                    )
                    ->leftJoin('tb_penugasan_driver', 'tb_penugasan_driver.id_driver', '=', 'tb_driver.id_driver')
                    ->whereMonth('tb_penugasan_driver.tgl_penugasan', $month)
                    ->whereYear('tb_penugasan_driver.tgl_penugasan', $year)
                    ->groupBy('tb_driver.id_driver', 'tb_driver.nama_driver', 'tb_driver.no_tlp')
                    ->orderByDesc(DB::raw('jumlah_all'))
                    ->get()
                    ->map(
                        function ($foto) {
                            return [
                                'id_driver' => $foto->id_driver,
                                'nama_driver' => $foto->nama_driver,
                                'no_tlp' => $foto->no_tlp,
                                'history' => [
                                    'jumlah_all' => $foto->jumlah_all,
                                    'jumlah_menunggu' => $foto->jumlah_menunggu,
                                    'jumlah_terima' => $foto->jumlah_terima,
                                    'jumlah_perjalan' => $foto->jumlah_perjalanan,
                                    'jumlah_selesai' => $foto->jumlah_selesai,
                                    'jumlah_batal' => $foto->jumlah_batal
                                ]
                            ];
                        }
                    );
                if ($data['history']->count() > 0) {
                    // return $data;
                    $pdf = FacadePdf::loadView('dashboard.export.exPdfPenugasanHistory', $data)->setPaper('f4', 'portrait');
                    set_time_limit(60);

                    return $pdf->download('laporan_history_penugasan_bulan' . $bulan . '.pdf');
                } else {
                    return redirect()->back()->with('success', 'Maaf, Data tidak ditemukan');
                }
            } else {
                abort(403, 'Unauthorized action.');
            }
        }
    }

    //history departemen 

    public function indexHistoryDepartemen(Request $request)
    {
        // $status = $request->status;
        $bulan = $request->query('bulan');
        $month = Carbon::parse($bulan)->format('m');
        $year = Carbon::parse($bulan)->format('Y');

        if ($bulan != '') {
            $data['history'] = DB::table('tb_departemen as tb_departemen_u')
                ->select(
                    'tb_departemen_u.id_departemen',
                    'tb_departemen_u.nama_departemen',
                    DB::raw('COUNT(tb_order_kendaraan.id_pemesan) as jumlah_total'),
                    DB::raw("
                    (SELECT COUNT(tb_order_kendaraan.id_pemesan) 
                    FROM tb_order_kendaraan
                    LEFT JOIN tb_petugas as tb_pemesan_s on tb_pemesan_s.id_petugas = tb_order_kendaraan.id_pemesan
                    LEFT JOIN tb_departemen on tb_departemen.id_departemen = tb_pemesan_s.id_departemen
                    WHERE tb_departemen.id_departemen = tb_departemen_u.id_departemen
                    AND tb_order_kendaraan.status_tujuan = 'l'
                    AND tb_order_kendaraan.status_so != 'c'
                    AND YEAR(tb_order_kendaraan.tgl_penjemputan) = $year 
                    AND MONTH(tb_order_kendaraan.tgl_penjemputan) = $month) as jumlah_lokal,
                    (SELECT COUNT(tb_order_kendaraan.id_pemesan) 
                    FROM tb_order_kendaraan
                    LEFT JOIN tb_petugas as tb_pemesan_s on tb_pemesan_s.id_petugas = tb_order_kendaraan.id_pemesan
                    LEFT JOIN tb_departemen on tb_departemen.id_departemen = tb_pemesan_s.id_departemen
                    WHERE tb_departemen.id_departemen = tb_departemen_u.id_departemen
                    AND tb_order_kendaraan.status_tujuan = 'o' 
                    AND tb_order_kendaraan.status_so != 'c'
                    AND YEAR(tb_order_kendaraan.tgl_penjemputan) = $year 
                    AND MONTH(tb_order_kendaraan.tgl_penjemputan) = $month) as jumlah_out
                ")
                )
                ->leftJoin('tb_petugas as tb_pemesan', 'tb_pemesan.id_departemen', '=', 'tb_departemen_u.id_departemen')
                ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_pemesan', '=', 'tb_pemesan.id_petugas')
                ->groupBy('tb_departemen_u.id_departemen', 'tb_departemen_u.nama_departemen')
                ->where('tb_order_kendaraan.status_so', '!=', 'c')
                // ->orWhereNull('tb_order_kendaraan.status_so')
                ->whereMonth('tb_order_kendaraan.tgl_penjemputan', $month)
                ->whereYear('tb_order_kendaraan.tgl_penjemputan', $year)
                ->orderByDesc(DB::raw('jumlah_total'))
                ->get();
            $data['total'] = $data['history']->max('jumlah_total') + 10;
            // return $data;
            return view(
                'dashboard.main.assignment.historyDepartemen',
                $data
            );
        } else {
            $data['history'] = DB::table('tb_departemen as tb_departemen_u')
                ->select(
                    'tb_departemen_u.id_departemen',
                    'tb_departemen_u.nama_departemen',
                    DB::raw('COUNT(tb_order_kendaraan.id_pemesan) as jumlah_total'),
                    DB::raw("
                    (SELECT COUNT(tb_order_kendaraan.id_pemesan) 
                    FROM tb_order_kendaraan
                    LEFT JOIN tb_petugas as tb_pemesan_s on tb_pemesan_s.id_petugas = tb_order_kendaraan.id_pemesan
                    LEFT JOIN tb_departemen on tb_departemen.id_departemen = tb_pemesan_s.id_departemen
                    WHERE tb_departemen.id_departemen = tb_departemen_u.id_departemen
                    AND tb_order_kendaraan.status_tujuan = 'l' 
                    AND tb_order_kendaraan.status_so != 'c') as jumlah_lokal,
                    (SELECT COUNT(tb_order_kendaraan.id_pemesan) 
                    FROM tb_order_kendaraan
                    LEFT JOIN tb_petugas as tb_pemesan_s on tb_pemesan_s.id_petugas = tb_order_kendaraan.id_pemesan
                    LEFT JOIN tb_departemen on tb_departemen.id_departemen = tb_pemesan_s.id_departemen
                    WHERE tb_departemen.id_departemen = tb_departemen_u.id_departemen
                    AND tb_order_kendaraan.status_tujuan = 'o' 
                    AND tb_order_kendaraan.status_so != 'c') as jumlah_out
                ")
                )
                ->leftJoin('tb_petugas as tb_pemesan', 'tb_pemesan.id_departemen', '=', 'tb_departemen_u.id_departemen')
                ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_pemesan', '=', 'tb_pemesan.id_petugas')
                ->groupBy('tb_departemen_u.id_departemen', 'tb_departemen_u.nama_departemen')
                ->where('tb_order_kendaraan.status_so', '!=', 'c')
                // ->orWhereNull('tb_order_kendaraan.status_so')
                ->orderByDesc(DB::raw('jumlah_total'))
                ->get();
            $data['total'] = $data['history']->max('jumlah_total') + 10;
            // return $data;
            return view(
                'dashboard.main.assignment.historyDepartemen',
                $data
            );
        }
    }

    public function exportHistoryDepartemenPdf(Request $request)
    {
        $bulan = $request->query('bulan');
        $month = Carbon::parse($bulan)->format('m');
        $year = Carbon::parse($bulan)->format('Y');

        if ($bulan != '') {
            $data['filter'] = [
                'bulan' => $bulan
            ];
            $data['history'] = DB::table('tb_departemen as tb_departemen_u')
                ->select(
                    'tb_departemen_u.id_departemen',
                    'tb_departemen_u.nama_departemen',
                    DB::raw('COUNT(tb_order_kendaraan.id_pemesan) as jumlah_total'),
                    DB::raw("
                    (SELECT COUNT(tb_order_kendaraan.id_pemesan) 
                    FROM tb_order_kendaraan
                    LEFT JOIN tb_petugas as tb_pemesan_s on tb_pemesan_s.id_petugas = tb_order_kendaraan.id_pemesan
                    LEFT JOIN tb_departemen on tb_departemen.id_departemen = tb_pemesan_s.id_departemen
                    WHERE tb_departemen.id_departemen = tb_departemen_u.id_departemen
                    AND tb_order_kendaraan.status_tujuan = 'l' AND tb_order_kendaraan.status_so != 'c'
                    AND YEAR(tb_order_kendaraan.tgl_penjemputan) = $year 
                    AND MONTH(tb_order_kendaraan.tgl_penjemputan) = $month) as jumlah_lokal,
                    (SELECT COUNT(tb_order_kendaraan.id_pemesan) 
                    FROM tb_order_kendaraan
                    LEFT JOIN tb_petugas as tb_pemesan_s on tb_pemesan_s.id_petugas = tb_order_kendaraan.id_pemesan
                    LEFT JOIN tb_departemen on tb_departemen.id_departemen = tb_pemesan_s.id_departemen
                    WHERE tb_departemen.id_departemen = tb_departemen_u.id_departemen
                    AND tb_order_kendaraan.status_tujuan = 'o' AND tb_order_kendaraan.status_so != 'c'
                    AND YEAR(tb_order_kendaraan.tgl_penjemputan) = $year 
                    AND MONTH(tb_order_kendaraan.tgl_penjemputan) = $month) as jumlah_out
                ")
                )
                ->leftJoin('tb_petugas as tb_pemesan', 'tb_pemesan.id_departemen', '=', 'tb_departemen_u.id_departemen')
                ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_pemesan', '=', 'tb_pemesan.id_petugas')
                ->groupBy('tb_departemen_u.id_departemen', 'tb_departemen_u.nama_departemen')
                ->where('tb_order_kendaraan.status_so', '!=', 'c')
                // ->orWhereNull('tb_order_kendaraan.status_so')
                ->whereMonth('tb_order_kendaraan.tgl_penjemputan', $month)
                ->whereYear('tb_order_kendaraan.tgl_penjemputan', $year)
                ->orderByDesc(DB::raw('jumlah_total'))
                ->get();
            // return $data;
            if ($data['history']->count() > 0) {
                // return $data;
                $pdf = FacadePdf::loadView('dashboard.export.exPdfPenugasanDepartemenHistory', $data)->setPaper('f4', 'portrait');
                set_time_limit(60);

                return $pdf->download('laporan_history_penugasan_departemen_bulan' . $bulan . '.pdf');
            } else {
                return redirect()->back()->with('success', 'Maaf, Data tidak ditemukan');
            }
        } else {
            $data['filter'] = [
                'bulan' => $bulan
            ];
            $data['history'] = DB::table('tb_departemen as tb_departemen_u')
                ->select(
                    'tb_departemen_u.id_departemen',
                    'tb_departemen_u.nama_departemen',
                    DB::raw('COUNT(tb_order_kendaraan.id_pemesan) as jumlah_total'),
                    DB::raw("
                    (SELECT COUNT(tb_order_kendaraan.id_pemesan) 
                    FROM tb_order_kendaraan
                    LEFT JOIN tb_petugas as tb_pemesan_s on tb_pemesan_s.id_petugas = tb_order_kendaraan.id_pemesan
                    LEFT JOIN tb_departemen on tb_departemen.id_departemen = tb_pemesan_s.id_departemen
                    WHERE tb_departemen.id_departemen = tb_departemen_u.id_departemen
                    AND tb_order_kendaraan.status_tujuan = 'l' 
                    AND tb_order_kendaraan.status_so != 'c') as jumlah_lokal,
                    (SELECT COUNT(tb_order_kendaraan.id_pemesan) 
                    FROM tb_order_kendaraan
                    LEFT JOIN tb_petugas as tb_pemesan_s on tb_pemesan_s.id_petugas = tb_order_kendaraan.id_pemesan
                    LEFT JOIN tb_departemen on tb_departemen.id_departemen = tb_pemesan_s.id_departemen
                    WHERE tb_departemen.id_departemen = tb_departemen_u.id_departemen
                    AND tb_order_kendaraan.status_tujuan = 'o' 
                    AND tb_order_kendaraan.status_so != 'c') as jumlah_out
                ")
                )
                ->leftJoin('tb_petugas as tb_pemesan', 'tb_pemesan.id_departemen', '=', 'tb_departemen_u.id_departemen')
                ->leftJoin('tb_order_kendaraan', 'tb_order_kendaraan.id_pemesan', '=', 'tb_pemesan.id_petugas')
                ->groupBy('tb_departemen_u.id_departemen', 'tb_departemen_u.nama_departemen')
                ->where('tb_order_kendaraan.status_so', '!=', 'c')
                // ->orWhereNull('tb_order_kendaraan.status_so')
                ->orderByDesc(DB::raw('jumlah_total'))
                ->get();
            if ($data['history']->count() > 0) {
                // return $data;
                $pdf = FacadePdf::loadView('dashboard.export.exPdfPenugasanDepartemenHistory', $data)->setPaper('f4', 'portrait');
                set_time_limit(60);

                return $pdf->download('laporan_history_penugasan_departemen.pdf');
            } else {
                return redirect()->back()->with('success', 'Maaf, Data tidak ditemukan');
            }
        }
    }

    public function exportHistoryDepartemenExsl(Request $request)
    {
        $bulan = $request->query('bulan');
        $month = Carbon::parse($bulan)->format('m');
        $year = Carbon::parse($bulan)->format('Y');
        if ($bulan != '') {
            return Excel::download(new PenugasanDepartemenExportMonth($bulan), 'laporan_history_penugasan_departemen_bulan' . $bulan . '.xlsx');
            // return Excel::download(new PengecekanDateExport($id_kendaraan, $tgl_pengecekan), 'Laporan_pengecekan_tanggal_' . $tanggal . '.xlsx');
        } else {
            return Excel::download(new PenugasanDepartemenExportAll, 'laporan_history_penugasan_departemen.xlsx');
        }
    }
}
