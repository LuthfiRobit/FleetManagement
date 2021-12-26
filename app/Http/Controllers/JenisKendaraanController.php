<?php

namespace App\Http\Controllers;

use App\Models\JenisKendaraan;
use App\Http\Requests\StoreJenisKendaraanRequest;
use App\Http\Requests\UpdateJenisKendaraanRequest;
use App\Models\MerkKendaraan;
use Illuminate\Support\Facades\DB;

class JenisKendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['jenisKendaraan'] = DB::table('tb_jenis_kendaraan')
            ->select('id_jenis_kendaraan', 'nama_jenis', 'status')
            ->orderByRaw('id_jenis_kendaraan DESC')
            ->paginate(5);

        // return $data;
        return view('dashboard.pages.jenisKendaraan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJenisKendaraanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJenisKendaraanRequest $request)
    {
        $data = $request->except(['_token']);
        DB::table('tb_jenis_kendaraan')
            ->insert($data);
        // JenisKendaraan::create($data);
        // return $data;
        return redirect()->route('dashboard.kendaraan.jenis.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisKendaraan  $jenisKendaraan
     * @return \Illuminate\Http\Response
     */
    public function show(JenisKendaraan $jenisKendaraan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisKendaraan  $jenisKendaraan
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisKendaraan $jenisKendaraan, $id)
    {
        $data['jenisKendaraan'] = DB::select('select id_jenis_kendaraan,nama_jenis,status
        from tb_jenis_kendaraan where id_jenis_kendaraan = ' . $id);
        // return $data;
        return view('dashboard.pages.jenisKendaraan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJenisKendaraanRequest  $request
     * @param  \App\Models\JenisKendaraan  $jenisKendaraan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJenisKendaraanRequest $request, JenisKendaraan $jenisKendaraan, $id)
    {
        $data = $request->except(['_token', '_method']);
        DB::table('tb_jenis_kendaraan')
            ->where('id_jenis_kendaraan', $id)
            ->update($data);
        // return $data;
        return redirect()->route('dashboard.kendaraan.jenis.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisKendaraan  $jenisKendaraan
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisKendaraan $jenisKendaraan)
    {
        //
    }
}
