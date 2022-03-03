<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\DriverStatus;
use App\Models\PenugasanBatal;
use App\Models\PenugasanDriver;
use App\Models\RatingDriver;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingDriverController extends Controller
{

    public function index(Request $request)
    {
        $data['rating'] = DB::select(
            "SELECT tb_driver.id_driver, tb_driver.nama_driver, tb_departemen.nama_departemen as departemen, CEIL(AVG(tb_rating_driver.nilai)) as rating
            FROM tb_driver
            LEFT JOIN tb_departemen ON tb_departemen.id_departemen=tb_driver.id_departemen
            LEFT JOIN tb_penugasan_driver ON tb_penugasan_driver.id_driver=tb_driver.id_driver
            LEFT JOIN tb_rating_driver ON tb_rating_driver.id_do=tb_penugasan_driver.id_do
            WHERE tb_driver.status_driver = 'y'
            GROUP BY tb_driver.nama_driver, tb_driver.id_driver,tb_departemen.nama_departemen
            ORDER BY rating DESC
            "
        );
        // return $data;
        return view('dashboard.main.rating.index', $data);
    }

    public function detail(Request $request, $id)
    {
        $driver = DB::table('tb_driver')
            ->select(
                'tb_driver.nama_driver',
                'tb_driver.no_tlp',
                'tb_departemen.nama_departemen'
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_driver.id_driver', $id)
            ->first();
        $rating = DB::select(
            "SELECT tb_driver.id_driver, tb_driver.nama_driver, tb_kriteria_rating.pertanyaan, CEIL(avg(tb_rating_driver.nilai)) as nilai
            FROM tb_driver
            JOIN tb_penugasan_driver ON tb_driver.id_driver=tb_penugasan_driver.id_driver
            JOIN tb_rating_driver ON tb_penugasan_driver.id_do=tb_rating_driver.id_do
            JOIN tb_kriteria_rating ON tb_rating_driver.id_kriteria_rating=tb_kriteria_rating.id_kriteria_rating
            WHERE tb_driver.id_driver= '$id' GROUP BY tb_driver.id_driver, tb_driver.nama_driver, tb_kriteria_rating.pertanyaan"
        );
        $perjalanan = PenugasanDriver::where('id_driver', $id)->count();
        $pembatalan = PenugasanBatal::where('id_driver', $id)->count();
        $nonaktif = DriverStatus::where('id_driver', $id)->count();
        $data = [
            'driver' => $driver,
            'perjalanan' => $perjalanan,
            'pembatalan' => $pembatalan,
            'nonaktif' => $nonaktif,
            'rating' => $rating
        ];
        // return $data;
        return view('dashboard.main.rating.detail', $data);
    }

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
