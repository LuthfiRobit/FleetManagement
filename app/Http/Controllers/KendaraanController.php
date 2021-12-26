<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Http\Requests\StoreKendaraanRequest;
use App\Http\Requests\UpdateKendaraanRequest;
use App\Models\BahanBakar;
use App\Models\JenisKendaraan;
use App\Models\MerkKendaraan;
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
        $data = $request->except(['_token']);
        $simpan = Kendaraan::create($data);
        if ($simpan) {
            return redirect()->route('dashboard.kendaraan.main.index');
        } else {
            return $data;
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
        $data['merkKendaraan'] = MerkKendaraan::where('status', 'y')->get();
        $data['bahanBakar'] = BahanBakar::where('status', 'y')->get();
        $data['kendaraan'] = Kendaraan::where('id_kendaraan', $id)->first();
        if ($data['kendaraan']) {
            return view('dashboard.pages.kendaraan.edit', $data);
        } else {
            return $id;
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
        $data = $request->except(['_token', '_method']);
        $update = Kendaraan::where('id_kendaraan', $id)->update($data);
        if ($update) {
            return redirect()->route('dashboard.kendaraan.main.index');
        } else {
            return $data;
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
}
