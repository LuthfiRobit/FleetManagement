<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Http\Requests\StorePetugasRequest;
use App\Http\Requests\UpdatePetugasRequest;
use App\Models\Departemen;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['petugas'] = DB::table('tb_petugas')
            ->select(
                'tb_petugas.id_petugas',
                'tb_petugas.no_badge',
                'tb_petugas.nama_lengkap',
                'tb_departemen.nama_departemen',
                'tb_jabatan.nama_jabatan',
                'tb_petugas.tgl_mulai_kerja',
                'tb_petugas.no_tlp',
                'tb_petugas.status'
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_petugas.id_departemen')
            ->leftJoin('tb_jabatan', 'tb_jabatan.id_jabatan', '=', 'tb_petugas.id_jabatan')
            ->get();

        // return $data;
        return view('dashboard.pages.petugas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['departemen'] = Departemen::where('status', 'y')->get();
        $data['jabatan']    = Jabatan::where('status', 'y')->get();
        // return $data;
        return view('dashboard.pages.petugas.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePetugasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePetugasRequest $request)
    {
        $data = $request->except(['_token']);
        $defaultPasswordUser = str_replace("-", "", $data['tgl_lahir']);
        $data['password'] = Hash::make($defaultPasswordUser);
        $data['user'] = $defaultPasswordUser;
        $simpan = Petugas::create($data);
        if ($simpan) {
            return redirect()->route('dashboard.petugas.main.index');
        } else {
            return "gagal";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function show(Petugas $petugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['departemen'] = Departemen::where('status', 'y')->get();
        $data['jabatan']    = Jabatan::where('status', 'y')->get();
        $data['petugas']    = Petugas::where('id_petugas', $id)->first();
        // return $data;
        return view('dashboard.pages.petugas.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePetugasRequest  $request
     * @param  \App\Models\Petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePetugasRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        // $data['password'] = Hash::make($data['password']);
        $update = Petugas::where('id_petugas', $id)->update($data);
        if ($update) {
            return redirect()->route('dashboard.petugas.main.index');
            // return $data;
        } else {
            return "gagal";
        }
    }

    public function username(Request $request, $id)
    {
        $newUsername = $request->user;
        $find = Petugas::where('id_petugas', $id)->first();
        if ($find) {
            $find->update(['user' => $newUsername]);
            return redirect()->back();
        }
    }

    public function password(Request $request, $id)
    {
        $old_pwd = Petugas::where('id_petugas', $id)->first();
        $rules = [
            'new_password' =>  [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                // ->uncompromised(),
            ],
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($old_pwd) {
                    if (!Hash::check($value, $old_pwd->password)) {
                        return $fail(__('The current password is incorrect.'));
                    }
                }
            ]
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
            // return $request->all();
        } else {
            $data = [
                'password' => Hash::make($request->new_password)
            ];
            $update_pwd = Petugas::where('id_petugas', $id)->update($data);
            if ($update_pwd) {
                return redirect()->back();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Petugas  $petugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Petugas $petugas)
    {
        //
    }
}
