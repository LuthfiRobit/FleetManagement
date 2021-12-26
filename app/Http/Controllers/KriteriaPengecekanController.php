<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPengecekan;
use App\Http\Requests\StoreKriteriaPengecekanRequest;
use App\Http\Requests\UpdateKriteriaPengecekanRequest;
use Illuminate\Support\Facades\DB;

class KriteriaPengecekanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['kriteriaPengecekan'] = DB::table('tb_kriteria_pengecekan')
            ->select('id_kriteria', 'nama_kriteria', 'status')
            ->orderByRaw('id_kriteria DESC')
            ->get();
        // return $data;
        return view('dashboard.pages.kriteriaPengecekan.index', $data);
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
     * @param  \App\Http\Requests\StoreKriteriaPengecekanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKriteriaPengecekanRequest $request)
    {
        $data = $request->except(['_token']);
        KriteriaPengecekan::create($data);
        return redirect()->route('dashboard.pengecekan.kriteria.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KriteriaPengecekan  $kriteriaPengecekan
     * @return \Illuminate\Http\Response
     */
    public function show(KriteriaPengecekan $kriteriaPengecekan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KriteriaPengecekan  $kriteriaPengecekan
     * @return \Illuminate\Http\Response
     */
    public function edit(KriteriaPengecekan $kriteriaPengecekan, $id)
    {
        $data['kriteriaPengecekan'] = KriteriaPengecekan::where('id_kriteria', $id)->first();
        if ($data) {
            // return $data;
            return view('dashboard.pages.kriteriaPengecekan.edit', $data);
        } else {
            return redirect()->route('dashboard.kriteria.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKriteriaPengecekanRequest  $request
     * @param  \App\Models\KriteriaPengecekan  $kriteriaPengecekan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKriteriaPengecekanRequest $request, KriteriaPengecekan $kriteriaPengecekan, $id)
    {
        $data = $request->except(['_token', '_method']);
        $kriteriaPengecekan->where('id_kriteria', $id)->update($data);
        return redirect()->route('dashboard.pengecekan.kriteria.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KriteriaPengecekan  $kriteriaPengecekan
     * @return \Illuminate\Http\Response
     */
    public function destroy(KriteriaPengecekan $kriteriaPengecekan)
    {
        //
    }
}
