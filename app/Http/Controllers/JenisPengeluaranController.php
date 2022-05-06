<?php

namespace App\Http\Controllers;

use App\Models\JenisPengeluaran;
use App\Http\Requests\StoreJenisPengeluaranRequest;
use App\Http\Requests\UpdateJenisPengeluaranRequest;
use Illuminate\Support\Facades\DB;

class JenisPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['jenis_pengeluaran'] = DB::table('tb_jenis_pengeluaran')
            ->select(
                'tb_jenis_pengeluaran.id_jenis_pengeluaran',
                'tb_jenis_pengeluaran.nama_jenis',
                'tb_jenis_pengeluaran.status'
            )
            ->orderByRaw('id_jenis_pengeluaran DESC')
            ->get();

        // return $data;
        return view('dashboard.pages.jenisPengeluaran.index', $data);
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
     * @param  \App\Http\Requests\StoreJenisPengeluaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJenisPengeluaranRequest $request)
    {
        $data = $request->except(['_token']);
        DB::table('tb_jenis_pengeluaran')
            ->insert($data);
        return redirect()->route('dashboard.jenis_pengeluaran.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisPengeluaran  $jenisPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(JenisPengeluaran $jenisPengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisPengeluaran  $jenisPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(JenisPengeluaran $jenisPengeluaran)
    {
        $data['jenis_pengeluaran'] = JenisPengeluaran::where('id_jenis_pengeluaran', $jenisPengeluaran->id_jenis_pengeluaran)->first();
        if ($data) {
            // return $data;
            return view('dashboard.pages.jenisPengeluaran.edit', $data);
        } else {
            return redirect()->route('dashboard.jenis_pengeluaran.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJenisPengeluaranRequest  $request
     * @param  \App\Models\JenisPengeluaran  $jenisPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJenisPengeluaranRequest $request, JenisPengeluaran $jenisPengeluaran)
    {
        $data = $request->except(['_token', '_method']);
        DB::table('tb_jenis_pengeluaran')
            ->where('id_jenis_pengeluaran', $jenisPengeluaran->id_jenis_pengeluaran)
            ->update($data);
        // return $data;
        return redirect()->route('dashboard.jenis_pengeluaran.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisPengeluaran  $jenisPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisPengeluaran $jenisPengeluaran)
    {
        //
    }
}
