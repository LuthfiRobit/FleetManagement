<?php

namespace App\Http\Controllers;

use App\Models\JenisPengecekan;
use App\Http\Requests\StoreJenisPengecekanRequest;
use App\Http\Requests\UpdateJenisPengecekanRequest;
use App\Models\KriteriaPengecekan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisPengecekanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->query('id');
        $data['kriteriaPengecekan'] = DB::table('tb_kriteria_pengecekan')->where('id_kriteria', $id)->first();
        $data['jenisPengecekan'] = DB::table('tb_jenis_pengecekan')
            ->select(
                'tb_jenis_pengecekan.id_jenis_pengecekan',
                'tb_kriteria_pengecekan.nama_kriteria',
                'tb_kriteria_pengecekan.id_kriteria',
                'tb_jenis_pengecekan.jenis_pengecekan',
                'tb_jenis_pengecekan.status'
            )
            ->leftJoin('tb_kriteria_pengecekan', 'tb_kriteria_pengecekan.id_kriteria', '=', 'tb_jenis_pengecekan.id_kriteria')
            ->where('tb_kriteria_pengecekan.id_kriteria', $id)
            ->get();
        // return $data;

        return view('dashboard.pages.jenisPengecekan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['kriteria'] = KriteriaPengecekan::where('status', 'y')->get();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJenisPengecekanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJenisPengecekanRequest $request)
    {
        $data = $request->except(['_token']);
        JenisPengecekan::create($data);
        // return $data;
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisPengecekan  $jenisPengecekan
     * @return \Illuminate\Http\Response
     */
    public function show(JenisPengecekan $jenisPengecekan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisPengecekan  $jenisPengecekan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $data['kriteria'] = KriteriaPengecekan::where('status', 'y')->get();
        $data['jenisPengecekan'] = DB::table('tb_jenis_pengecekan')
            ->select(
                'tb_jenis_pengecekan.id_jenis_pengecekan',
                'tb_kriteria_pengecekan.id_kriteria',
                'tb_kriteria_pengecekan.nama_kriteria',
                'tb_jenis_pengecekan.jenis_pengecekan',
                'tb_jenis_pengecekan.status'
            )
            ->leftJoin('tb_kriteria_pengecekan', 'tb_kriteria_pengecekan.id_kriteria', '=', 'tb_jenis_pengecekan.id_kriteria')
            ->where('id_jenis_pengecekan', $id)->first();
        if ($data['jenisPengecekan']) {
            // return $data;
            return view('dashboard.pages.jenisPengecekan.edit', $data);
        } else {
            return redirect()->route('dashboard.pengecekan.jenis.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJenisPengecekanRequest  $request
     * @param  \App\Models\JenisPengecekan  $jenisPengecekan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJenisPengecekanRequest $request, $id)
    {
        $data = $request->except(['id_kriteria', '_token', '_method']);
        JenisPengecekan::where('id_jenis_pengecekan', $id)->update($data);
        return redirect()->route('dashboard.pengecekan.jenis.index', 'id=' . $request->id_kriteria);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisPengecekan  $jenisPengecekan
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisPengecekan $jenisPengecekan)
    {
        //
    }
}
