<?php

namespace App\Http\Controllers;

use App\Models\MerkKendaraan;
use App\Http\Requests\StoreMerkKendaraanRequest;
use App\Http\Requests\UpdateMerkKendaraanRequest;

class MerkKendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['merkKendaraan'] = MerkKendaraan::select('id_merk', 'nama_merk', 'status')
            ->orderByRaw('id_merk DESC')
            ->get();
        // return $data;
        return view('dashboard.pages.merkKendaraan.index', $data);
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
     * @param  \App\Http\Requests\StoreMerkKendaraanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMerkKendaraanRequest $request)
    {
        $data = $request->except(['_token']);
        MerkKendaraan::create($data);
        return redirect()->route('dashboard.kendaraan.merk.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MerkKendaraan  $merkKendaraan
     * @return \Illuminate\Http\Response
     */
    public function show(MerkKendaraan $merkKendaraan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MerkKendaraan  $merkKendaraan
     * @return \Illuminate\Http\Response
     */
    public function edit(MerkKendaraan $merkKendaraan, $id)
    {
        $data['merkKendaraan'] = MerkKendaraan::where('id_merk', $id)->first();
        if ($data) {
            return view('dashboard.pages.merkKendaraan.edit', $data);
        } else {
            return redirect()->route('dashboard.kendaraan.merk.index');
        }

        // return view('dashboard.pages.merkKendaraan.edit', compact(''));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMerkKendaraanRequest  $request
     * @param  \App\Models\MerkKendaraan  $merkKendaraan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMerkKendaraanRequest $request, MerkKendaraan $merkKendaraan, $id)
    {
        $data = $request->except(['_token', '_method']);
        $merkKendaraan->where('id_merk', $id)->update($data);
        return redirect()->route('dashboard.kendaraan.merk.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MerkKendaraan  $merkKendaraan
     * @return \Illuminate\Http\Response
     */
    public function destroy(MerkKendaraan $merkKendaraan)
    {
        //
    }
}
