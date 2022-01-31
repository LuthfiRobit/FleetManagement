<?php

namespace App\Http\Controllers;

use App\Models\JenisSim;
use App\Http\Requests\StoreJenisSimRequest;
use App\Http\Requests\UpdateJenisSimRequest;
use Illuminate\Support\Facades\DB;

class JenisSimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['jenis_sim'] = DB::table('tb_jenis_sim')->select('id_jenis_sim', 'nama_sim', 'status')
            ->orderByRaw('id_jenis_sim DESC')
            ->get();

        // return $data;
        return view('dashboard.pages.jenisSim.index', $data);
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
     * @param  \App\Http\Requests\StoreJenisSimRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJenisSimRequest $request)
    {
        $data = $request->except(['_token']);
        DB::table('tb_jenis_sim')
            ->insert($data);
        return redirect()->route('dashboard.sim.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisSim  $jenisSim
     * @return \Illuminate\Http\Response
     */
    public function show(JenisSim $jenisSim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JenisSim  $jenisSim
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['jenis_sim'] = JenisSim::where('id_jenis_sim', $id)->first();
        if ($data) {
            return view('dashboard.pages.jenisSim.edit', $data);
        } else {
            return redirect()->route('dashboard.sim.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJenisSimRequest  $request
     * @param  \App\Models\JenisSim  $jenisSim
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJenisSimRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        DB::table('tb_jenis_sim')
            ->where('id_jenis_sim', $id)
            ->update($data);
        // return $data;
        return redirect()->route('dashboard.sim.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisSim  $jenisSim
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisSim $jenisSim)
    {
        //
    }
}
