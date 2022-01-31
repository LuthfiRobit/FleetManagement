<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Departemen;
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
                'tb_departemen.id_departemen',
                'tb_departemen.nama_departemen',
                'tb_driver.no_badge',
                'tb_driver.nama_driver',
                'tb_driver.alamat',
                'tb_driver.umur',
                'tb_driver.no_tlp',
                'tb_driver.id_driver',
                'tb_driver.foto_ktp',
            )
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
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

        $foto_ktp = $request->file('foto_ktp');
        $foto_sim = $request->file('foto_sim');

        if ($foto_ktp == null || $foto_sim == null) {
            $data = $request->except(['_token', 'foto_ktp', 'foto_sim']);
            $data['password'] = Hash::make($defaultPasswordDriver);
            $data['user'] = $defaultUsernameDriver;
            $simpan = Driver::create($data);
            return redirect()->route('dashboard.driver.index');
        } else {
            $data = $request->except(['_token']);
            $take_ktp = $request->no_ktp;
            $take_sim = $request->no_sim;
            $name_ktp   = 'ktp_' . $take_ktp . '.' . $foto_ktp->getClientOriginalExtension();
            $name_sim = 'sim_' . $take_sim . '.' . $foto_sim->getClientOriginalExtension();
            $data['foto_ktp'] = $name_ktp;
            $data['foto_sim'] = $name_sim;
            $data['password'] = Hash::make($defaultPasswordDriver);
            $data['user'] = $defaultUsernameDriver;
            $simpan = Driver::create($data);
            if ($simpan) {
                $folder_ktp     = 'assets/img_ktp';
                $folder_sim   = 'assets/img_sim';
                $foto_ktp->move($folder_ktp, $name_ktp);
                $foto_sim->move($folder_sim, $name_sim);
                // return $data;
                return redirect()->route('dashboard.driver.index');
            } else {
                return 'gagal';
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
        $data['driver'] = Driver::where('id_driver', $id)->first();
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
            return redirect()->route('dashboard.driver.index');
        } else {
            return "gagal";
        }
        // $data = $request->except(['_token', '_method']);
        // $foto_ktp = $request->file('foto_ktp');
        // $foto_sim = $request->file('foto_sim');
        // $take_name = $request->nama_driver;
        // $nama       = str_replace(" ", "_", $take_name);
        // $name_ktp   = 'ktp_' . $nama . '.' . $foto_ktp->getClientOriginalExtension();
        // $name_sim = 'sim_' . $nama . '.' . $foto_sim->getClientOriginalExtension();

        // $data['password'] = Hash::make($data['password']);
        // $data['foto_ktp'] = $name_ktp;
        // $data['foto_sim'] = $name_sim;



        // if ($request->file('foto_ktp')) {
        //     $data = $request->except(['_token', '_method']);
        //     $foto_ktp = $request->file('foto_ktp');
        //     // $foto_sim = $request->file('foto_sim');
        //     $take_name = $request->nama_driver;
        //     $nama       = str_replace(" ", "_", $take_name);
        //     $name_ktp   = 'ktp_' . $nama . '.' . $foto_ktp->getClientOriginalExtension();
        //     // $name_sim = 'sim_' . $nama . '.' . $foto_sim->getClientOriginalExtension();

        //     $data['password'] = Hash::make($data['password']);
        //     $data['foto_ktp'] = $name_ktp;
        //     // $data['foto_sim'] = $name_sim;
        //     $find = Driver::where('id_driver', $id)->first();
        //     if (!is_null($find->foto_ktp)) {
        //         File::delete('assets/img_ktp' . $find->foto_ktp);
        //         // File::delete('assets/img_sim' . $find->foto_sim);
        //     }
        //     $update = Driver::where('id_driver', $id)->update($data);
        //     if ($update) {
        //         $folder_ktp     = 'assets/img_ktp';
        //         $folder_sim   = 'assets/img_sim';
        //         $foto_ktp->move($folder_ktp, $name_ktp);
        //         // $foto_sim->move($folder_sim, $name_sim);
        //         // return $data;
        //         return redirect()->route('dashboard.driver.index');
        //     } else {
        //         return "gagal";
        //     }
        //     // return $data;
        // } else if ($request->hasFile('foto_sim')) {
        //     $data = $request->except(['_token', '_method']);
        //     // $foto_ktp = $request->file('foto_ktp');
        //     $foto_sim = $request->file('foto_sim');
        //     $take_name = $request->nama_driver;
        //     $nama       = str_replace(" ", "_", $take_name);
        //     // $name_ktp   = 'ktp_' . $nama . '.' . $foto_ktp->getClientOriginalExtension();
        //     $name_sim = 'sim_' . $nama . '.' . $foto_sim->getClientOriginalExtension();

        //     $data['password'] = Hash::make($data['password']);
        //     // $data['foto_ktp'] = $name_ktp;
        //     $data['foto_sim'] = $name_sim;
        //     $find = Driver::where('id_driver', $id)->first();
        //     if (!is_null($find->foto_sim)) {
        //         // File::delete('assets/img_ktp' . $find->foto_ktp);
        //         File::delete('assets/img_sim' . $find->foto_sim);
        //     }
        //     $update = Driver::where('id_driver', $id)->update($data);
        //     if ($update) {
        //         // $folder_ktp     = 'assets/img_ktp';
        //         $folder_sim   = 'assets/img_sim';
        //         // $foto_ktp->move($folder_ktp, $name_ktp);
        //         $foto_sim->move($folder_sim, $name_sim);
        //         // return $data;
        //         return redirect()->route('dashboard.driver.index');
        //     } else {
        //         return "gagal";
        //     }
        // } else {
        //     $data = $request->except(['_token', '_method']);
        //     $data['password'] = Hash::make($data['password']);
        //     $update = Driver::where('id_driver', $id)->update($data);
        //     if ($update) {
        //         // return $data;
        //         return redirect()->route('dashboard.driver.index');
        //     } else {
        //         return "gagal";
        //     }
        // }
    }

    public function username(Request $request, $id)
    {
        $newUsername = $request->user;
        $find = Driver::where('id_driver', $id)->first();
        if ($find) {
            $find->update(['user' => $newUsername]);
            return redirect()->back();
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
                return redirect()->back();
            }
        }
    }

    public function changeKtp(Request $request, $id)
    {
        $find = Driver::where('id_driver', $id)->first();
        $rules = [
            'no_ktp' => 'required|max:16',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5040'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        } else {
            $foto_ktp = $request->file('foto_ktp');
            $take_ktp = $request->no_ktp;
            $name_ktp   = 'ktp_' . $take_ktp . '.' . $foto_ktp->getClientOriginalExtension();
            $data = [
                'no_ktp' => $request->no_ktp,
                'foto_ktp' => $name_ktp
            ];
            // return $data;
            if (!is_null($find->foto_ktp)) {
                File::delete('assets/img_ktp' . $find->foto_ktp);
            }
            $update = Driver::where('id_driver', $id)->update($data);
            $folder_ktp     = 'assets/img_ktp';
            $foto_ktp->move($folder_ktp, $name_ktp);
            // return $data;
            return redirect()->route('dashboard.driver.index');
            // return $data;
        }
    }

    public function changeSim(Request $request, $id)
    {
        $find = Driver::where('id_driver', $id)->first();
        $rules = [
            'no_sim' => 'required|max:16',
            'foto_sim' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5040'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        } else {
            $foto_sim = $request->file('foto_sim');
            $take_sim = $request->no_sim;
            $name_sim   = 'sim_' . $take_sim . '.' . $foto_sim->getClientOriginalExtension();
            $data = [
                'no_sim' => $request->no_sim,
                'foto_sim' => $name_sim
            ];
            // return $data;
            if (!is_null($find->foto_sim)) {
                File::delete('assets/img_sim' . $find->foto_sim);
            }
            $update = Driver::where('id_driver', $id)->update($data);
            $folder_sim     = 'assets/img_sim';
            $foto_sim->move($folder_sim, $name_sim);
            // return $data;
            return redirect()->route('dashboard.driver.index');
            // return $data;
        }
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
