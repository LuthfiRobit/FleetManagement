<?php

namespace App\Http\Controllers;

use App\Models\JenisAlokasi;
use App\Http\Requests\StoreJenisAlokasiRequest;
use App\Http\Requests\UpdateJenisAlokasiRequest;
use Illuminate\Support\Facades\DB;

class JenisAlokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['jenis_alokasi'] = DB::table('tb_jenis_alokasi')
            ->select(
                'id_jenis_alokasi',
                'nama_alokasi',
                'status'
            )
            ->orderByDesc('id_jenis_alokasi')
            ->get();
        // return $data;
        return view('dashboard.pages.jenisAlokasi.index', $data);
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
     * @param  \App\Http\Requests\StoreJenisAlokasiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJenisAlokasiRequest $request)
    {
        $data = $request->except(['_token']);
        DB::table('tb_jenis_alokasi')
            ->insert($data);
        return redirect()->route('dashboard.kendaraan.jenis_alokasi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisAlokasi  $jenisAlokasi
     * @return \Illuminate\Http\Response
     */
    public function show(JenisAlokasi $jenisAlokasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisAlokasi  $jenisAlokasi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['jenis_alokasi'] = JenisAlokasi::where('id_jenis_alokasi', $id)->first();
        if ($data) {
            return view('dashboard.pages.jenisAlokasi.edit', $data);
        } else {
            return redirect()->route('dashboard.kendaraan.jenis_alokasi.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJenisAlokasiRequest  $request
     * @param  \App\Models\JenisAlokasi  $jenisAlokasi
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJenisAlokasiRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        DB::table('tb_jenis_alokasi')
            ->where('id_jenis_alokasi', $id)
            ->update($data);
        // return $data;
        return redirect()->route('dashboard.kendaraan.jenis_alokasi.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisAlokasi  $jenisAlokasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisAlokasi $jenisAlokasi)
    {
        //
    }
}
