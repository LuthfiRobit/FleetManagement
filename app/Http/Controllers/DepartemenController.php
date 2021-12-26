<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Http\Requests\StoreDepartemenRequest;
use App\Http\Requests\UpdateDepartemenRequest;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['departemen'] = Departemen::select('id_departemen', 'nama_departemen', 'perusahaan', 'status')
            ->orderByRaw('id_departemen DESC')
            ->get();
        // return $data;
        return view('dashboard.pages.departemen.index', $data);
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
     * @param  \App\Http\Requests\StoreDepartemenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartemenRequest $request)
    {
        $data = $request->except(['_token']);
        Departemen::create($data);
        return redirect()->route('dashboard.petugas.departemen.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function show(Departemen $departemen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function edit(Departemen $departemen, $id)
    {
        $data['departemen'] = Departemen::where('id_departemen', $id)->first();
        if ($data) {
            // return $data;
            return view('dashboard.pages.departemen.edit', $data);
        } else {
            return redirect()->route('dashboard.pages.departemen.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartemenRequest  $request
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartemenRequest $request, Departemen $departemen, $id)
    {
        $data = $request->except(['_token', '_method']);
        $departemen->where('id_departemen', $id)->update($data);
        return redirect()->route('dashboard.petugas.departemen.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departemen $departemen)
    {
        //
    }
}
