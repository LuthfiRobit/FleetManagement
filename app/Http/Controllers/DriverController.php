<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Departemen;
use App\Models\DetailSim;
use App\Models\JenisSim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

use function PHPUnit\Framework\isEmpty;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['driver'] = DB::table('tb_driver')
            ->select(
                'tb_driver.id_driver',
                'tb_driver.id_departemen',
                'tb_departemen.nama_departemen',
                'tb_driver.no_badge',
                'tb_driver.nama_driver',
                'tb_driver.alamat',
                'tb_driver.umur',
                'tb_driver.no_tlp',
                'tb_driver.status_driver as status',
                'tb_driver.foto_driver',
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->orderByRaw('tb_driver.no_badge ASC')
            ->get();
        // return $data;
        return view('dashboard.pages.driver.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['departemen'] = Departemen::where('status', 'y')->get();
        $data['jenisSim'] = JenisSim::where('status', 'y')->get();
        // return $data;
        return view('dashboard.pages.driver.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDriverRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDriverRequest $request)
    {

        $defaultUsernameDriver = str_replace("-", "", $request->input('no_badge'));
        $defaultPasswordDriver = str_replace("-", "", $request->input('no_tlp'));

        $foto_driver = $request->file('foto_driver');
        $foto_ktp = $request->file('foto_ktp');
        $foto_sim = $request->file('foto_sim');

        if ($foto_driver == null || $foto_ktp == null || $foto_sim == null) {
            $data = $request->except(['_token', 'foto_ktp', 'foto_sim', 'id_jenis_sim']);
            $data['password'] = Hash::make($defaultPasswordDriver);
            $data['user'] = $defaultUsernameDriver;
            $data['status_driver'] = 'y';
            $simpan = Driver::create($data);
            return redirect()->route('dashboard.driver.index')->with('success', 'Data Driver Berhasi Disimpan');
        } else {
            $data = $request->except(['_token', 'foto_sim', 'id_jenis_sim']);
            $take_ktp = $request->no_badge;
            $take_profil = $request->no_badge;
            $findSim = JenisSim::where('id_jenis_sim', $request->id_jenis_sim)->first();
            // $take_sim = $request->no_badge;
            $name_ktp   = 'ktp_' . $take_ktp . '.' . $foto_ktp->getClientOriginalExtension();
            $name_profil = 'pdrv_' . $take_profil . '.' . $foto_driver->getClientOriginalExtension();
            // $name_sim = 'sim_' . $take_sim . '.' . $foto_sim->getClientOriginalExtension();
            $data['foto_ktp'] = $name_ktp;
            $data['foto_driver'] = $name_profil;
            // $data['foto_sim'] = $name_sim;
            $data['password'] = Hash::make($defaultPasswordDriver);
            $data['user'] = $defaultUsernameDriver;
            $data['status_driver'] = 'y';
            $simpan = Driver::create($data);
            if ($simpan) {
                $simName = str_replace(" ", "_", $findSim->nama_sim);
                $name_sim = $simName . '_' .  $request->no_badge . '.' . $foto_sim->getClientOriginalExtension();
                $dataSim = [
                    'id_driver' => $simpan->id_driver,
                    'id_jenis_sim' => $request->id_jenis_sim,
                    'foto_sim' => $name_sim
                ];
                $simpanSim = DB::table('tb_detail_sim')->insert($dataSim);
                if ($simpanSim) {
                    $folder_sim   = 'assets/img_sim';
                    $foto_sim->move($folder_sim, $name_sim);
                }
                $folder_ktp     = 'assets/img_ktp';
                $folder_profil = 'assets/img_driver';
                $foto_ktp->move($folder_ktp, $name_ktp);
                $foto_driver->move($folder_profil, $name_profil);
                // return $data;
                return redirect()->route('dashboard.driver.index')->with('success', 'Data Driver Berhasi Disimpan');
            } else {
                return redirect()->back()->with('success', 'Data Driver Gagal Disimpan');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['departemen'] = Departemen::where('status', 'y')->get();
        $data['jenisSim'] = JenisSim::where('status', 'y')->get();
        // $data['driver'] = Driver::where('id_driver', $id)->first();
        $data['driver'] = DB::table('tb_driver')
            ->select(
                'tb_driver.id_driver',
                'tb_driver.id_departemen',
                'tb_driver.no_badge',
                'tb_driver.nama_driver',
                'tb_driver.alamat',
                'tb_driver.umur',
                'tb_driver.no_tlp',
                'tb_driver.foto_ktp',
                'tb_driver.foto_driver',
                'tb_driver.user',
                'tb_driver.password',
                'tb_driver.status_driver',
                'tb_departemen.nama_departemen',
                // 'tb_detail_sim.id_jenis_sim',
                // 'tb_detail_sim.foto_sim'
            )
            // ->leftJoin('tb_detail_sim', 'tb_detail_sim.id_driver', '=', 'tb_driver.id_driver')
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->where('tb_driver.id_driver', '=', $id)
            ->first();
        $data['detailSim'] = DB::table('tb_detail_sim')
            ->select(
                'tb_detail_sim.id_detail_sim',
                'tb_detail_sim.id_jenis_sim',
                'tb_detail_sim.foto_sim',
                'tb_jenis_sim.nama_sim'
            )
            ->leftJoin('tb_jenis_sim', 'tb_jenis_sim.id_jenis_sim', '=', 'tb_detail_sim.id_jenis_sim')
            ->where('tb_detail_sim.id_driver', $id)
            ->get();
        // return $data;
        return view('dashboard.pages.driver.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDriverRequest  $request
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDriverRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $update = Driver::where('id_driver', $id)->update($data);
        if ($update) {
            return redirect()->back()->with('success', 'Data Umum Driver Berhasil Diganti');
        } else {
            return redirect()->back()->with('success', 'Data Umum Driver Gagal Diganti');
        }
    }

    public function statusDriverAktif(Request $request, $id)
    {
        $find = Driver::where('id_driver', $id)->first();
        if ($find) {
            $find->update(['status_driver' => 'y']);
            return redirect()->back()->with('success', 'Driver Diaktifkan');
        } else {
            return redirect()->back()->with('success', 'Data Tidak Ditemukan');
        }
    }

    public function statusDriverNonAktif(Request $request, $id)
    {
        $find = Driver::where('id_driver', $id)->first();
        if ($find) {
            $find->update(['status_driver' => 't']);
            return redirect()->back()->with('success', 'Driver Dinonaktifkan');
        } else {
            return redirect()->back()->with('success', 'Data Tidak Ditemukan');
        }
    }

    public function username(Request $request, $id)
    {
        $newUsername = $request->user;
        $find = Driver::where('id_driver', $id)->first();
        if ($find) {
            $find->update(['user' => $newUsername]);
            return redirect()->back()->with('success', 'Username Berhasil Diganti');
        }
    }

    public function password(Request $request, $id)
    {
        $oldPwd = Driver::where('id_driver', $id)->first();
        $rules = [
            'new_password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->numbers()
            ],
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($oldPwd) {
                    if (!Hash::check($value, $oldPwd->password)) {
                        return $fail(__('Current Password tidak cocok'));
                    }
                }
            ]
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        } else {
            $data = ['password' => Hash::make($request->new_password)];
            $updatePwd = Driver::where('id_driver', $id)->update($data);
            if ($updatePwd) {
                return redirect()->back()->with('success', 'Password Berhasil Diganti');
            }
        }
    }

    public function resetAllPassword(Request $request)
    {
        try {
            $driver = Driver::select('id_driver', 'no_badge', 'no_tlp')->get();
            foreach ($driver as $dr) {
                $data = [
                    'user' => $dr->no_badge,
                    'password' => Hash::make($dr->no_tlp)
                ];
                $update = Driver::where('id_driver', $dr->id_driver)->update($data);
            }
            // return $driver;
            return redirect()->back()->with('success', 'Username dan Password seluruh driver berhasil direset menjadi NO. BADGE dan NO. TLFN');
        } catch (\Exception $exception) {
            //throw $th;
            // DB::rollBack();
            // return $exception;
            return redirect()->back()->with('success', 'Username dan Password driver gagal direset');
        }
    }

    public function resetPassword(Request $request, $id)
    {
        $findDriver = Driver::where('id_driver', $id)->first();
        if ($findDriver) {
            $data = [
                'user' => $findDriver->no_badge,
                'password' => Hash::make($findDriver->no_tlp)
            ];
            $update = $findDriver->update($data);
            return redirect()->back()->with('success', 'Username dan Password driver ' . $findDriver->nama_driver . ' berhasil direset menjadi NO. BADGE dan NO. TLFN');
        } else {
            return redirect()->back()->with('success', 'Username dan Password driver gagal direset');
        }
    }

    public function changeKtp(Request $request, $id)
    {
        $find = Driver::where('id_driver', $id)->first();
        $rules = [
            // 'no_ktp' => 'required|max:16',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5040'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        } else {
            $foto_ktp = $request->file('foto_ktp');
            $take_ktp = $find->no_badge;
            $name_ktp   = 'ktp_' . $take_ktp . '.' . $foto_ktp->getClientOriginalExtension();
            $data = [
                // 'no_ktp' => $request->no_ktp,
                'foto_ktp' => $name_ktp
            ];
            // return $data;
            if (!is_null($find->foto_ktp)) {
                File::delete('assets/img_ktp/' . $find->foto_ktp);
            }
            $update = Driver::where('id_driver', $id)->update($data);
            $folder_ktp     = 'assets/img_ktp';
            $foto_ktp->move($folder_ktp, $name_ktp);
            // return $data;
            return redirect()->back()->with('success', 'KTP Driver Berhasil Diganti');
            // return $data;
        }
    }

    public function changeProfil(Request $request, $id)
    {
        $find = Driver::where('id_driver', $id)->first();
        $rules = [
            'foto_driver' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5040'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        } else {
            $foto_driver = $request->file('foto_driver');
            $take_profil = $find->no_badge;
            $name_profil   = 'pdrv_' . $take_profil . '.' . $foto_driver->getClientOriginalExtension();
            $data = [
                'foto_driver' => $name_profil
            ];
            // return $data;
            if (!is_null($find->foto_driver)) {
                File::delete('assets/img_driver/' . $find->foto_driver);
            }
            $update = Driver::where('id_driver', $id)->update($data);
            $folder_profil     = 'assets/img_driver';
            $foto_driver->move($folder_profil, $name_profil);
            return redirect()->back()->with('success', 'Foto Profil Berhasil Diganti');
        }
    }

    public function changeSim(Request $request, $id)
    {
        $findDriver = Driver::where('id_driver', $id)->first();
        $find = DetailSim::where('id_driver', $id)->first();
        if ($find) {
            $rules = [
                'id_jenis_sim' => 'required',
                'foto_sim' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5040'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            } else {
                $foto_sim = $request->file('foto_sim');
                // $take_sim = $request->no_sim;
                $name_sim   = 'sim_' . $findDriver->no_badge . '.' . $foto_sim->getClientOriginalExtension();
                $data = [
                    'id_jenis_sim' => $request->id_jenis_sim,
                    'foto_sim' => $name_sim
                ];
                // return $data;
                if (!is_null($find->foto_sim)) {
                    File::delete('assets/img_sim/' . $find->foto_sim);
                }
                // $update = Driver::where('id_driver', $id)->update($data);
                $updateSim = DetailSim::where('id_driver', $id)->update($data);
                $folder_sim     = 'assets/img_sim';
                $foto_sim->move($folder_sim, $name_sim);
                // return $data;
                return redirect()->back()->with('success', 'Data SIM Driver Berhasil Diganti');
                // return $data;
            }
        } else {
            $rules = [
                'id_jenis_sim' => 'required',
                'foto_sim' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5040'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            } else {
                $foto_sim = $request->file('foto_sim');
                $name_sim   = 'sim_' . $findDriver->no_badge . '.' . $foto_sim->getClientOriginalExtension();
                $data = [
                    'id_jenis_sim' => $request->id_jenis_sim,
                    'id_driver' => $id,
                    'foto_sim' => $name_sim
                ];
                // $update = Driver::where('id_driver', $id)->update($data);
                $updateSim = DetailSim::create($data);
                $folder_sim     = 'assets/img_sim';
                $foto_sim->move($folder_sim, $name_sim);
                // return $data;
                return redirect()->back()->with('success', 'Berhasil Menambahkan SIM Driver');
                // return $data;
            }
        }
    }

    public function addSim(Request $request, $id)
    {
        $findDriver = Driver::where('id_driver', $id)->first();
        $findSim = JenisSim::where('id_jenis_sim', $request->id_jenis_sim)->first();
        $findDetailSim = DetailSim::where([['id_driver', $id], ['id_jenis_sim', $request->id_jenis_sim]])->first();
        if ($findDetailSim) {
            return redirect()->back()->with('success', 'Gagal Menambahkan SIM Driver, SIM sudah tersedia');
        } else {
            $simName = str_replace(" ", "_", $findSim->nama_sim);
            $rules = [
                'id_jenis_sim' => 'required',
                'foto_sim' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5040'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->all);
            } else {
                $foto_sim = $request->file('foto_sim');
                $name_sim   = $simName . '_' . $findDriver->no_badge . '.' . $foto_sim->getClientOriginalExtension();
                $data = [
                    'id_jenis_sim' => $request->id_jenis_sim,
                    'id_driver' => $id,
                    'foto_sim' => $name_sim
                ];
                // $update = Driver::where('id_driver', $id)->update($data);
                $addSim = DetailSim::create($data);
                $folder_sim     = 'assets/img_sim';
                $foto_sim->move($folder_sim, $name_sim);
                // return $name_sim;
                return redirect()->back()->with('success', 'Berhasil Menambahkan SIM Driver');
                // return $data;
            }
        }
    }

    public function removeSim(Request $request)
    {
        $findDetailSim = DetailSim::where('id_detail_sim', $request->id_detail_sim)->first();
        // if ($findDetailSim) {
        if (!is_null($findDetailSim->foto_sim)) {
            File::delete('assets/img_sim/' . $findDetailSim->foto_sim);
        }
        $findDetailSim->delete();
        return $findDetailSim;
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        //
    }
}
