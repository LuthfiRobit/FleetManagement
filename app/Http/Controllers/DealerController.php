<?php

namespace App\Http\Controllers;

use App\Models\Dealer;
use App\Http\Requests\StoreDealerRequest;
use App\Http\Requests\UpdateDealerRequest;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['dealer'] = Dealer::select('id_dealer', 'nama_dealer', 'alamat', 'no_tlp', 'status', 'status_dealer')
            ->orderByRaw('id_dealer DESC')
            ->get();
        // return $data;
        return view('dashboard.pages.dealer.index', $data);
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
     * @param  \App\Http\Requests\StoreDealerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDealerRequest $request)
    {
        $data = $request->except(['_token']);
        $simpan = Dealer::create($data);
        if ($simpan) {
            return redirect()->route('dashboard.dealer.index')->with('success', 'Data Dealer Berhasi Disimpan');
        } else {

            return redirect()->route('dashboard.dealer.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function show(Dealer $dealer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['dealer'] = Dealer::where('id_dealer', $id)->first();
        if ($data) {
            // return $data;
            return view('dashboard.pages.dealer.edit', $data);
        } else {
            return redirect()->route('dashboard.delaer.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDealerRequest  $request
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDealerRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $update = Dealer::where('id_dealer', $id)->update($data);
        if ($update) {
            return redirect()->route('dashboard.dealer.index')->with('success', 'Data Dealer Berhasi Diedit');
        } else {

            return redirect()->route('dashboard.dealer.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dealer $dealer)
    {
        //
    }
}
