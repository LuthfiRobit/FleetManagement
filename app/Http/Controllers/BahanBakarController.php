<?php

namespace App\Http\Controllers;

use App\Models\BahanBakar;
use App\Http\Requests\StoreBahanBakarRequest;
use App\Http\Requests\UpdateBahanBakarRequest;

class BahanBakarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['bahanBakar'] = BahanBakar::select('id_bahan_bakar', 'nama_bahan_bakar', 'status')
            ->orderByRaw('id_bahan_bakar DESC')
            ->get();

        // return $data;
        return view('dashboard.pages.bahanBakar.index', $data);
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
     * @param  \App\Http\Requests\StoreBahanBakarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBahanBakarRequest $request)
    {
        $data = $request->except(['_token']);
        BahanBakar::create($data);
        // return $data;
        return redirect()->route('dashboard.bahanbakar.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BahanBakar  $bahanBakar
     * @return \Illuminate\Http\Response
     */
    public function show(BahanBakar $bahanBakar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BahanBakar  $bahanBakar
     * @return \Illuminate\Http\Response
     */
    public function edit(BahanBakar $bahanBakar, $id)
    {
        $data['bahanBakar'] = BahanBakar::where('id_bahan_bakar', $id)->first();
        // return $data;
        return view('dashboard.pages.bahanBakar.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBahanBakarRequest  $request
     * @param  \App\Models\BahanBakar  $bahanBakar
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBahanBakarRequest $request, BahanBakar $bahanBakar, $id)
    {
        $data = $request->except(['_token', '_method']);
        $bahanBakar->where('id_bahan_bakar', $id)->update($data);
        // return $data;
        return redirect()->route('dashboard.bahanbakar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BahanBakar  $bahanBakar
     * @return \Illuminate\Http\Response
     */
    public function destroy(BahanBakar $bahanBakar)
    {
        //
    }
}
