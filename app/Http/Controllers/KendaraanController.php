<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Http\Requests\StoreKendaraanRequest;
use App\Http\Requests\UpdateKendaraanRequest;
use App\Models\AlokasiKendaraan;
use App\Models\BahanBakar;
use App\Models\JenisAlokasi;
use App\Models\JenisKendaraan;
use App\Models\JenisSim;
use App\Models\MerkKendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['kendaraan'] = DB::table('tb_kendaraan')
            ->select(
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.kode_asset',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.warna',
                'tb_merk_kendaraan.nama_merk',
                'tb_jenis_kendaraan.nama_jenis',
                'tb_bahan_bakar.nama_bahan_bakar',
            )
            ->leftJoin('tb_bahan_bakar', 'tb_bahan_bakar.id_bahan_bakar', '=', 'tb_kendaraan.id_bahan_bakar')
            ->leftJoin('tb_merk_kendaraan', 'tb_merk_kendaraan.id_merk', '=', 'tb_kendaraan.id_merk')
            ->leftJoin('tb_jenis_kendaraan', 'tb_jenis_kendaraan.id_jenis_kendaraan', '=', 'tb_kendaraan.id_jenis_kendaraan')
            ->orderByDesc('id_kendaraan')
            ->get();
        return view('dashboard.pages.kendaraan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['jenisKendaraan'] = JenisKendaraan::where('status', 'y')->get();
        $data['jenisAlokasi'] = JenisAlokasi::where('status', 'y')->get();
        $data['jenisSim'] = JenisSim::where('status', 'y')->get();
        $data['merkKendaraan'] = MerkKendaraan::where('status', 'y')->get();
        $data['bahanBakar'] = BahanBakar::where('status', 'y')->get();
        // return $data;
        return view('dashboard.pages.kendaraan.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKendaraanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKendaraanRequest $request)
    {
        $data = $request->except(['_token', 'id_jenis_alokasi']);
        $simpan = Kendaraan::create($data);
        if ($simpan) {
            $dataAlokasi = [
                'id_jenis_alokasi' => $request->id_jenis_alokasi,
                'id_kendaraan' => $simpan->id_kendaraan
            ];
            $simpanAlokasi = AlokasiKendaraan::create($dataAlokasi);
            if ($simpanAlokasi) {
                return redirect()->route('dashboard.kendaraan.main.index')->with('success', 'Data Kendaraan dan Alokasi Berhasi Disimpan');
            } else {
                return redirect()->route('dashboard.kendaraan.main.index')->with('success', 'Data Kendaraan dan Alokasi Gagal Disimpan');
            }
            return redirect()->route('dashboard.kendaraan.main.index')->with('success', 'Data Kendaraan dan Alokasi Berhasi Disimpan');
        } else {
            // return $data;
            return redirect()->route('dashboard.kendaraan.main.index')->with('success', 'Data Kendaraan dan Alokasi Gagal Disimpan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function show(Kendaraan $kendaraan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['jenisKendaraan'] = JenisKendaraan::where('status', 'y')->get();
        $data['jenisAlokasi'] = JenisAlokasi::where('status', 'y')->get();
        $data['jenisSim'] = JenisSim::where('status', 'y')->get();
        $data['merkKendaraan'] = MerkKendaraan::where('status', 'y')->get();
        $data['bahanBakar'] = BahanBakar::where('status', 'y')->get();
        // $data['kendaraan'] = Kendaraan::where('id_kendaraan', $id)
        //     ->with('alokasiKendaraan')->first();
        $data['kendaraan'] = DB::table('tb_kendaraan')
            ->select(
                'tb_kendaraan.id_kendaraan',
                'tb_kendaraan.id_jenis_kendaraan',
                'tb_kendaraan.id_merk',
                'tb_alokasi_kendaraan.id_jenis_alokasi',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.id_bahan_bakar',
                'tb_kendaraan.id_jenis_sim',
                'tb_kendaraan.kode_asset',
                'tb_kendaraan.no_polisi',
                'tb_kendaraan.nomor_rangka',
                'tb_kendaraan.nomor_mesin',
                'tb_kendaraan.nama_kendaraan',
                'tb_kendaraan.warna',
                'tb_kendaraan.tanggal_pembelian',
                'tb_kendaraan.harga',
                'tb_kendaraan.jenis_penggerak',
                'tb_kendaraan.tahun_kendaraan',
                'tb_kendaraan.pemilik',
                'tb_kendaraan.status'
            )
            ->leftJoin('tb_alokasi_kendaraan', 'tb_alokasi_kendaraan.id_kendaraan', '=', 'tb_kendaraan.id_kendaraan')
            ->where('tb_kendaraan.id_kendaraan', '=', $id)
            ->first();
        $data['alokasiKendaraan'] = DB::table('tb_alokasi_kendaraan')
            ->select(
                'tb_alokasi_kendaraan.id_alokasi',
                'tb_alokasi_kendaraan.id_jenis_alokasi',
                'tb_jenis_alokasi.nama_alokasi'
            )
            ->leftJoin('tb_jenis_alokasi', 'tb_jenis_alokasi.id_jenis_alokasi', '=', 'tb_alokasi_kendaraan.id_jenis_alokasi')
            ->where('tb_alokasi_kendaraan.id_kendaraan', $id)
            ->get();
        if ($data['kendaraan']) {
            // return $data['kendaraan'];
            return view('dashboard.pages.kendaraan.edit', $data);
        } else {
            // return $id;
            return redirect()->route('dashboard.kendaraan.main.index')->with('success', 'Data Tidak Ditemukan');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKendaraanRequest  $request
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKendaraanRequest $request, Kendaraan $kendaraan, $id)
    {
        try {
            $data = $request->except(['_token', '_method']);
            $update = Kendaraan::where('id_kendaraan', $id)->update($data);
            // $findAlokasi = AlokasiKendaraan::where('id_kendaraan', $id)->first();
            // if ($findAlokasi) {
            //     $findAlokasi->update(['id_jenis_alokasi' => $request->id_jenis_alokasi]);
            // } else {
            //     $dataAlokasi = [
            //         'id_jenis_alokasi' => $request->id_jenis_alokasi,
            //         'id_kendaraan' => $id
            //     ];
            //     AlokasiKendaraan::create($dataAlokasi);
            // }
            return redirect()->route('dashboard.kendaraan.main.index')->with('success', 'Data Berhasil Diganti');
        } catch (\Illuminate\Database\QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $errorInfo = $exception->errorInfo;
            // return $errorInfo;
            return redirect()->route('dashboard.kendaraan.main.index')->with('success', 'Data Gagal Diganti. Error(' . $errorInfo . ')');
            // Return the response to the client..
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kendaraan $kendaraan)
    {
        //
    }

    public function addAlokasi(Request $request)
    {
        $id_kendaraan = $request->id_kendaraan;
        $id_jenis_alokasi = $request->id_jenis_alokasi;
        $findAlokasi = AlokasiKendaraan::where([['id_jenis_alokasi', $id_jenis_alokasi], ['id_kendaraan', $id_kendaraan]])->first();
        if ($findAlokasi) {
            return redirect()->back()->with('success', 'Gagal Menambah Alokasi Kendaraan (Alokasi Sudah Ada)');
        } else {
            $data = [
                'id_jenis_alokasi' => $id_jenis_alokasi,
                'id_kendaraan' => $id_kendaraan
            ];

            $simpanAlokasi = AlokasiKendaraan::create($data);
            if ($simpanAlokasi) {
                return redirect()->back()->with('success', 'Berhasil Menambah Alokasi Kendaraan');
            } else {
                return redirect()->back()->with('success', 'Gagal Menambah Alokasi Kendaraan');
            }
        }
    }

    public function removeAlokasi(Request $request)
    {
        $findAlokasi = AlokasiKendaraan::find($request->id_alokasi);
        // $findDetail->jml_komponen = $request->jml;
        $findAlokasi->delete();

        return $findAlokasi;
    }
}
