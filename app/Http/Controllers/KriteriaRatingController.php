<?php

namespace App\Http\Controllers;

use App\Models\KriteriaRating;
use App\Http\Requests\StoreKriteriaRatingRequest;
use App\Http\Requests\UpdateKriteriaRatingRequest;
use Illuminate\Support\Facades\DB;

class KriteriaRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['kriteria_rating'] = DB::table('tb_kriteria_rating')
            ->select(
                'id_kriteria_rating',
                'pertanyaan',
                'status'
            )
            ->orderByDesc('id_kriteria_rating')
            ->get();
        // return $data;
        return view('dashboard.pages.kriteriaRating.index', $data);
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
     * @param  \App\Http\Requests\StoreKriteriaRatingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKriteriaRatingRequest $request)
    {
        $data = $request->except(['_token']);
        DB::table('tb_kriteria_rating')
            ->insert($data);
        return redirect()->route('dashboard.kriteria_rating.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KriteriaRating  $kriteriaRating
     * @return \Illuminate\Http\Response
     */
    public function show(KriteriaRating $kriteriaRating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KriteriaRating  $kriteriaRating
     * @return \Illuminate\Http\Response
     */
    public function edit(KriteriaRating $kriteriaRating)
    {
        $data['kriteria_rating'] = KriteriaRating::where('id_kriteria_rating', $kriteriaRating->id_kriteria_rating)->first();
        if ($data) {
            return view('dashboard.pages.kriteriaRating.edit', $data);
        } else {
            return redirect()->route('dashboard.kriteria_rating.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKriteriaRatingRequest  $request
     * @param  \App\Models\KriteriaRating  $kriteriaRating
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKriteriaRatingRequest $request, KriteriaRating $kriteriaRating)
    {
        $data = $request->except(['_token', '_method']);
        DB::table('tb_kriteria_rating')
            ->where('id_kriteria_rating', $kriteriaRating->id_kriteria_rating)
            ->update($data);
        // return $data;
        return redirect()->route('dashboard.kriteria_rating.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KriteriaRating  $kriteriaRating
     * @return \Illuminate\Http\Response
     */
    public function destroy(KriteriaRating $kriteriaRating)
    {
        //
    }
}
