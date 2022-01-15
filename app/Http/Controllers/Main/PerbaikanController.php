<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\PengecekanKendaraanDetail;
use App\Models\Perbaikan;
use App\Models\PerbaikanPersetujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerbaikanController extends Controller
{
    public function index(Request $request)
    {
    }

    public function store(Request $request)
    {

        $id_pengecekan = $request->id_pengecekan;
        $id_petugas = 1;
        $status = $request->req_status;

        $data_approval = [
            'no_wo' => $request->no_wo,
            'id_pengecekan' => $id_pengecekan,
            'id_petugas' => $id_petugas,
            'tgl_persetujuan' => $request->tgl_persetujuan
        ];

        if ($status == 't') {
            $data_approval['status'] = 't';
            $store_approval = PerbaikanPersetujuan::create($data_approval);
            // return $data_approval;
            // return redirect()->route('checking.serviceorder')->with('success', 'Service Order is Rejected');
            return redirect()->back()->with('success', 'Approval is Rejected');
        } else if ($status == 's') {
            DB::beginTransaction();
            try {
                $data_approval['status'] = 's';
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
                return redirect()->back()->with('success', 'Approval is Accepted');
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
                return redirect()->back()->with('success', 'Some Errors ' . $exception);
                // return response()->json(
                //     [
                //         'pesan' => 'gagal',
                //         'errors' => $exception
                //     ]
                // );
            }
        }
    }
}
