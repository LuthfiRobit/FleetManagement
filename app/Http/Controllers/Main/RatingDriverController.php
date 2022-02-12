<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\RatingDriver;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingDriverController extends Controller
{
    public function viewInsert(Request $request)
    {
        $id = $request->query('id_do');
        $no_tlp = $request->query('no_tlp');

        $data['driver'] = DB::table('tb_penugasan_driver')
            ->select(
                'tb_penugasan_driver.id_do',
                'tb_penugasan_driver.id_service_order',
                'tb_driver.nama_driver',
                'tb_departemen.nama_departemen as departemen',
                'tb_driver.no_tlp',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi'
            )
            ->leftJoin('tb_driver', 'tb_driver.id_driver', '=', 'tb_penugasan_driver.id_driver')
            ->leftJoin('tb_kendaraan', 'tb_kendaraan.id_kendaraan', '=', 'tb_penugasan_driver.id_kendaraan')
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('id_do', $id)
            ->first();

        $data['responden'] = ServiceOrderDetail::where([['id_service_order', $data['driver']->id_service_order], ['no_tlp', $no_tlp]])->first();

        if ($data['responden'] == true) {
            $data['find'] = RatingDriver::where([['id_do', $id], ['id_detail_so', $data['responden']->id_detail_so]])->get();
            $data['pertanyaan'] = DB::table('tb_kriteria_rating')
                ->select(
                    'id_kriteria_rating as id_rating',
                    'pertanyaan'
                )
                ->where('status', 'y')
                ->get();
            return view('dashboard.main.rating.insert', $data);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function storeRating(Request $request)
    {
        $findRating = RatingDriver::where([['id_do', $request->id_do], ['id_kriteria_rating', $request->id_rating], ['id_detail_so', $request->id_so]])->first();
        if ($findRating) {
            $findRating->update(['nilai' => $request->nilai]);
            return $findRating;
        } else {
            $data = [
                'id_do' => $request->id_do,
                'id_kriteria_rating' => $request->id_rating,
                'id_detail_so' => $request->id_so,
                'nilai' => $request->nilai,
            ];
            $simpan = RatingDriver::create($data);
            return $data;
        }
    }
}
