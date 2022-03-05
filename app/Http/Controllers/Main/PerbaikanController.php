<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\PengecekanKendaraan;
use App\Models\PengecekanKendaraanDetail;
use App\Models\Perbaikan;
use App\Models\PerbaikanDetail;
use App\Models\PerbaikanPersetujuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerbaikanController extends Controller
{
    public function index(Request $request)
    {
        $data['perbaikan'] = DB::table('tb_perbaikan')
            ->select(
                'tb_perbaikan.id_perbaikan',
                'tb_perbaikan.tgl_perbaikan',
                'tb_perbaikan.tgl_selesai',
                'tb_perbaikan.status_perbaikan',
                'tb_perbaikan.status_penyelesaian',
                'tb_dealer.nama_dealer',
                'tb_persetujuan_perbaikan.no_wo',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi'
            )
            ->leftJoin('tb_dealer', 'tb_dealer.id_dealer', '=', 'tb_perbaikan.id_dealer')
            ->leftJoin('tb_persetujuan_perbaikan', 'tb_persetujuan_perbaikan.id_persetujuan', '=', 'tb_perbaikan.id_persetujuan')
            ->leftJoin('tb_pengecekan_kendaraan', 'tb_pengecekan_kendaraan.id_pengecekan', '=', 'tb_persetujuan_perbaikan.id_pengecekan')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
            ->orderByDesc('tb_perbaikan.id_perbaikan')
            ->get();

        // return $data;
        return view('dashboard.main.repair.index', $data);
    }

    public function detail(Request $request, $id)
    {
        $data['perbaikan'] = DB::table('tb_perbaikan')
            ->select(
                'tb_perbaikan.id_perbaikan',
                'tb_perbaikan.tgl_perbaikan',
                'tb_perbaikan.tgl_selesai',
                'tb_perbaikan.tgl_selesai_pengerjaan as tgl_penyelesaian',
                'tb_perbaikan.status_perbaikan',
                'tb_perbaikan.status_penyelesaian',
                'tb_perbaikan.total_biaya_perbaikan as total',
                'tb_dealer.nama_dealer',
                'tb_dealer.status_dealer',
                'tb_dealer.alamat',
                'tb_persetujuan_perbaikan.no_wo',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_pengecekan_kendaraan.km_kendaraan'
            )
            ->leftJoin('tb_dealer', 'tb_dealer.id_dealer', '=', 'tb_perbaikan.id_dealer')
            ->leftJoin('tb_persetujuan_perbaikan', 'tb_persetujuan_perbaikan.id_persetujuan', '=', 'tb_perbaikan.id_persetujuan')
            ->leftJoin('tb_pengecekan_kendaraan', 'tb_pengecekan_kendaraan.id_pengecekan', '=', 'tb_persetujuan_perbaikan.id_pengecekan')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
            ->where('tb_perbaikan.id_perbaikan', $id)
            ->first();

        $data['detail_perbaikan'] = DB::table('tb_detail_pergantian as tb_ganti')
            ->select(
                'tb_ganti.id_detail_pergantian as id_ganti',
                'tb_ganti.nama_komponen',
                'tb_ganti.jml_komponen',
                'tb_ganti.harga_satuan'
            )
            ->orderByDesc('id_ganti')
            ->where('id_perbaikan', $id)
            ->get();
        // return $data;
        return view('dashboard.main.repair.detail', $data);
    }

    public function invoice(Request $request, $id)
    {
        $data['perbaikan'] = DB::table('tb_perbaikan')
            ->select(
                'tb_perbaikan.id_perbaikan',
                'tb_perbaikan.tgl_perbaikan',
                'tb_perbaikan.tgl_selesai',
                'tb_perbaikan.status_perbaikan',
                'tb_perbaikan.status_penyelesaian',
                'tb_dealer.nama_dealer',
                'tb_dealer.status_dealer',
                'tb_dealer.alamat',
                'tb_persetujuan_perbaikan.no_wo',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_pengecekan_kendaraan.km_kendaraan'
            )
            ->leftJoin('tb_dealer', 'tb_dealer.id_dealer', '=', 'tb_perbaikan.id_dealer')
            ->leftJoin('tb_persetujuan_perbaikan', 'tb_persetujuan_perbaikan.id_persetujuan', '=', 'tb_perbaikan.id_persetujuan')
            ->leftJoin('tb_pengecekan_kendaraan', 'tb_pengecekan_kendaraan.id_pengecekan', '=', 'tb_persetujuan_perbaikan.id_pengecekan')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_pengecekan_kendaraan.id_kendaraan')
            ->where('tb_perbaikan.id_perbaikan', $id)
            ->first();

        $data['detail_perbaikan'] = DB::table('tb_detail_pergantian as tb_ganti')
            ->select(
                'tb_ganti.id_detail_pergantian as id_ganti',
                'tb_ganti.nama_komponen',
                'tb_ganti.jml_komponen',
                'tb_ganti.harga_satuan'
            )
            ->orderByDesc('id_ganti')
            ->where('id_perbaikan', $id)
            ->get();
        // return $data;
        return view('dashboard.main.repair.invoice', $data);
    }

    public function updateJumlah(Request $request)
    {
        $findDetail = PerbaikanDetail::find($request->id_detail);
        $findDetail->jml_komponen = $request->jml;
        $findDetail->save();

        return $findDetail;
    }

    public function updateHarga(Request $request)
    {
        $findDetail = PerbaikanDetail::find($request->id_detail);
        $findDetail->harga_satuan = $request->harga;
        $findDetail->save();
        return $findDetail;
    }

    public function update(Request $request, $id)
    {
        $data = [
            'tgl_selesai_pengerjaan' => $request->tgl_penyelesaian,
            'status_perbaikan' => 's',
            'total_biaya_perbaikan' => $request->total_biaya
        ];
        $findPerbaikan = Perbaikan::where('id_perbaikan', $id)->first();

        if ($findPerbaikan) {
            if (Carbon::parse($request->tgl_penyelesaian)->lessThanOrEqualTo(Carbon::parse($findPerbaikan->tgl_selesai))) {
                $data['status_penyelesaian'] = 'o';
            } else {
                $data['status_penyelesaian'] = 'p';
            }
            $updatePerbaikan = $findPerbaikan->update($data);
            // if ($updatePerbaikan) {

            //     $findDetail = PerbaikanDetail::where('id_perbaikan', $id)->get();
            //     if ($findDetail > 0) {
            //     } else {
            //         return redirect()->route('reapair.main')->with('success', 'Gagal! Data tidak ditemukan.');
            //     }
            // }

        } else {
            return redirect()->route('reapair.main')->with('success', 'Gagal! Data tidak ditemukan.');
        }
    }

    public function store(Request $request)
    {

        $id_pengecekan = $request->id_pengecekan;
        $id_petugas = 4;

        $data_approval = [
            'no_wo' => $request->no_wo,
            'id_pengecekan' => $id_pengecekan,
            'id_petugas' => $id_petugas,
            'tgl_persetujuan' => $request->tgl_persetujuan,
        ];

        // if ($status == 't') {
        //     $data_approval['status'] = 't';
        //     $store_approval = PerbaikanPersetujuan::create($data_approval);
        //     // return $data_approval;
        //     // return redirect()->route('checking.serviceorder')->with('success', 'Service Order is Rejected');
        //     return redirect()->back()->with('success', 'Approval is Rejected');
        // } else if ($status == 's') {
        DB::beginTransaction();
        try {
            $updatePengecekan = PengecekanKendaraan::where('id_pengecekan', $id_pengecekan)->update(['status_perbaikan' => 't']);
            $store_approval = PerbaikanPersetujuan::create($data_approval);
            $data_repair = [
                'id_persetujuan' => $store_approval->id_persetujuan,
                'id_dealer' => $request->id_dealer,
                'tgl_perbaikan' => $request->tgl_perbaikan,
                'tgl_selesai' => $request->tgl_selesai,
                'status_pebaikan' => 'p'
            ];
            $store_repair = Perbaikan::create($data_repair);
            $get_detail =  DB::table('tb_detail_pengecekan')
                ->select(
                    'tb_detail_pengecekan.id_detail_pengecekan',
                    'tb_jenis_pengecekan.jenis_pengecekan as komponen',
                )
                ->join('tb_jenis_pengecekan', 'tb_jenis_pengecekan.id_jenis_pengecekan', '=', 'tb_detail_pengecekan.id_jenis_pengecekan')
                ->where('id_pengecekan', $id_pengecekan)
                ->get();
            foreach ($get_detail as $key => $de) {
                $data_detail = [
                    'id_perbaikan' => $store_repair->id_perbaikan,
                    'tgl_pergantian' => $request->tgl_perbaikan,
                    'nama_komponen' => $de->komponen,
                    'jml_komponen' => 1
                ];
                $store_detail = DB::table('tb_detail_pergantian')->insert($data_detail);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Persetujuan perbaikan berhasil dibuat.');
            // return response()->json(
            //     [
            //         'pesan' => 'sukses',
            //         'setuju' => $store_approval,
            //         'baik' => $data_repair,
            //         'detail' => $get_detail
            //     ]
            // );
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            return redirect()->back()->with('success', 'Gagal, persetujuan perbaikan gagal dibuat.');
            // return response()->json(
            //     [
            //         'pesan' => 'gagal',
            //         'errors' => $exception
            //     ]
            // );
        }
        // }
    }

    public function reject(Request $request, $id)
    {
        $id_petugas = 4;
        // $id_pengecekan = $request->id_pengecekan;
        $findPengecekan = PengecekanKendaraan::where('id_pengecekan', $id)->first();
        if ($findPengecekan) {
            $data = [
                'status_perbaikan' => 'tl',
                'keterangan_penolakan' => $request->keterangan_penolakan
            ];
            $reject = $findPengecekan->update($data);
            if ($reject) {
                return redirect()->back()->with('success', 'Berhasil tolak perbaikan.');
            } else {
                return redirect()->back()->with('success', 'Gagal tolak perbaikan!');
            }
        } else {
            return redirect()->back()->with('success', 'Gagal tolak perbaikan, data tidak ditemukan!');
        }
        // $data_approval = [
        //     'id_pengecekan' => $request->get('id_pengecekan'),
        //     'id_petugas' => $id_petugas,
        //     'tgl_persetujuan' => Carbon::now()->format('Y-m-d'),
        //     'status' => 't'
        // ];
        // $reject = PerbaikanPersetujuan::create($data_approval);
        // if ($reject) {
        //     return redirect()->back()->with('success', 'Berhasil tolak perbaikan.');
        // } else {
        //     return redirect()->back()->with('success', 'Gagal tolak perbaikan!');
        // }
    }
}
