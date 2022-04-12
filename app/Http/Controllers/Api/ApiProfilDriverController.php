<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailSim;
use App\Models\Driver;
use App\Models\DriverStatus;
use App\Models\JenisSim;
use App\Models\PenugasanBatal;
use App\Models\PenugasanDriver;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ApiProfilDriverController extends Controller
{
    public function profil(Request $request)
    {
        $id_driver = $request->query('id_driver');
        $profil_driver = DB::table('tb_driver')
            ->select(
                'tb_driver.id_driver',
                'tb_driver.no_badge',
                'tb_driver.nama_driver',
                'tb_driver.user as username',
                'tb_driver.alamat',
                'tb_driver.umur',
                'tb_driver.no_tlp',
                'tb_driver.foto_driver',
                'tb_driver.id_departemen',
                'tb_departemen.nama_departemen',
                'tb_driver.foto_ktp'
            )
            ->where('id_driver', $id_driver)
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->first();

        return response()->json(
            [
                'status'        => 'sukses',
                'profil_driver' => $profil_driver
            ]
        );
    }

    public function profilDepan(Request $request)
    {
        $id_driver = $request->query('id_driver');
        $profil_driver = DB::table('tb_driver')
            ->select(
                'tb_driver.id_driver',
                'tb_driver.no_badge',
                'tb_driver.nama_driver',
                'tb_driver.foto_driver',
                'tb_departemen.nama_departemen'
            )
            ->where('id_driver', $id_driver)
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_driver.id_departemen')
            ->first();
        $do_selesai = PenugasanDriver::where([['id_driver', $id_driver], ['status_penugasan', 's']])->count();
        $do_batal = PenugasanBatal::where('id_driver', $id_driver)->count();

        return response()->json(
            [
                'status'        => 'sukses',
                'profil_driver' => $profil_driver,
                'do_selesai'    => $do_selesai,
                'do_batal' => $do_batal
            ]
        );
    }

    public function status(Request $request)
    {
        $id_driver = $request->query('id_driver');
        $find_status = DB::table('tb_status_driver')
            ->select(
                'id_status',
                'id_driver',
                'status'
            )
            ->where([['id_driver', $id_driver], ['status', 'n']])
            ->first();
        if ($find_status) {
            return response()->json(
                [
                    'status'        => 'sukses',
                    'status_driver' => 'nonaktif'
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'sukses',
                    'status_driver' => 'aktif'
                ]
            );
        }
    }

    public function nonAktif(Request $request)
    {
        $id_driver = $request->id_driver;
        $foto_bukti = $request->file('foto');
        $name = 'nonaktif_' . uniqid() . '.' . $foto_bukti->getClientOriginalExtension();
        $find_status = DriverStatus::where([['id_driver', $id_driver], ['status', 'n']])->first();
        if ($find_status) {
            return response()->json(
                [
                    'status'        => 'gagal',
                ]
            );
        } else {
            $data = [
                'id_driver' => $id_driver,
                'status' => 'n',
                'tgl_nonaktif' => $request->tgl_nonaktif,
                'keterangan' => $request->keterangan,
                'foto_bukti' => $name
            ];
            $simpan = DriverStatus::create($data);
            if ($simpan) {
                $folder_bukti = 'assets/img_bukti';
                $foto_bukti->move($folder_bukti, $name);
                return response()->json(
                    [
                        'status'         => 'sukses',
                        'status_driver'       => 'nonaktif'
                    ]
                );
            }
        }
    }

    public function aktif(Request $request)
    {
        $id_driver = $request->id_driver;
        $find_status = DriverStatus::where([['id_driver', $id_driver], ['status', 'n']])->first();
        if ($find_status) {
            $tgl_nonaktif = Carbon::parse($find_status->tgl_nonaktif);
            $tgl_aktif = Carbon::parse($request->tgl_aktif);
            if ($tgl_aktif == $tgl_nonaktif) {
                $jml_nonaktif = 1;
            }
            if ($tgl_aktif > $tgl_nonaktif) {
                $jml_nonaktif = $tgl_aktif->diffInDays($tgl_nonaktif);
            }
            $data = [
                'status' => 'r',
                'tgl_aktif' => $request->tgl_aktif,
                'jml_nonaktif' => $jml_nonaktif
            ];
            // return $data;
            $find_status->update($data);
            return response()->json(
                [
                    'status'        => 'sukses',
                    'status_driver' => 'aktif'
                ]
            );
        } else {
            return response()->json(
                [
                    'status'         => 'gagal'
                ]
            );
        }
    }

    public function username(Request $request)
    {
        $id_driver = $request->id_driver;
        $username = $request->username;
        $find = Driver::where('id_driver', $id_driver)->first();
        if ($find) {
            $find->update(['user' => $username]);
            return response()->json(
                [
                    'status'        => 'sukses',
                    'pesan' => 'username berhasil diganti',
                    'username' => $username
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'pesan' => 'username gagal diganti'
                ]
            );
        }
    }

    public function fotoDriver(Request $request)
    {
        $id_driver = $request->id_driver;
        $foto_driver = $request->file('foto_driver');
        $findDriver = Driver::where('id_driver', $id_driver)->select('no_badge', 'foto_driver')->first();
        if ($findDriver != null) {
            $name_profil   = 'pdrv_' . uniqid() . '.' . $foto_driver->getClientOriginalExtension();
            $data = [
                'foto_driver' => $name_profil
            ];
            // return $data;
            if (!is_null($findDriver->foto_driver)) {
                File::delete('assets/img_driver/' . $findDriver->foto_driver);
            }
            $update = Driver::where('id_driver', $id_driver)->update($data);
            $folder_profil     = 'assets/img_driver';
            $foto_driver->move($folder_profil, $name_profil);
            return response()->json(
                [
                    'status' => 'sukses',
                    'pesan' => 'profil berhasil diganti',
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'gagal',
                    'pesan' => 'profil tidak ditemukan',
                ]
            );
        }
    }

    public function password(Request $request)
    {
        $id_driver = $request->id_driver;
        $password_lama = $request->password_lama;
        $password_baru = $request->password_baru;
        $findDriver = Driver::where('id_driver', $id_driver)->first();
        $validator = Validator::make($request->all(), [
            'password_baru' => 'required',
            'password_lama' => 'required'
        ]);

        if (Hash::check($password_lama, $findDriver->password)) {
            $data = ['password' => Hash::make($password_baru)];
            $updatePassword = $findDriver->update($data);
            if ($updatePassword) {
                return response()->json([
                    'status' => 'sukses',
                    'pesan' => 'password berhasil diganti'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'password lama tidak cocok'
            ]);
        }
    }

    public function listSim(Request $request)
    {
        $id_driver = $request->query('id_driver');
        $listSim = DB::table('tb_detail_sim')
            ->select(
                'tb_detail_sim.id_driver',
                'tb_detail_sim.id_detail_sim',
                'tb_detail_sim.id_jenis_sim',
                'tb_detail_sim.foto_sim',
                'tb_jenis_sim.nama_sim'
            )
            ->leftJoin('tb_jenis_sim', 'tb_jenis_sim.id_jenis_sim', '=', 'tb_detail_sim.id_jenis_sim')
            ->where('tb_detail_sim.id_driver', $id_driver)
            ->get();

        if ($listSim->count() > 0) {
            return response()->json(
                [
                    'status' => 'sukses',
                    'list_sim' => $listSim
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'gagal',
                    'list_sim' => $listSim
                ]
            );
        }
    }

    public function listJenisSim()
    {
        $listJenisSim = DB::table('tb_jenis_sim')
            ->select('id_jenis_sim', 'nama_sim')
            ->where('status', 'y')
            ->get();
        if ($listJenisSim->count() > 0) {
            return response()->json(
                [
                    'status' => 'sukses',
                    'list_jenis_sim' => $listJenisSim
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'gagal',
                    'list_jenis_sim' => $listJenisSim
                ]
            );
        }
    }

    public function addSim(Request $request)
    {
        $id_driver = $request->id_driver;
        $id_jenis_sim = $request->id_jenis_sim;
        $foto_sim = $request->file('foto_sim');

        $findDetailSim = DetailSim::where([['id_driver', $id_driver], ['id_jenis_sim', $id_jenis_sim]])->first();

        if ($findDetailSim) {
            return response()->json(
                [
                    'status' => 'gagal',
                    'pesan' => 'SIM sudah ada'
                ]
            );
        } else {
            $findDriver = Driver::where('id_driver', $id_driver)->first();
            $findSim = JenisSim::where('id_jenis_sim', $id_jenis_sim)->first();
            $simName = str_replace(" ", "_", $findSim->nama_sim);
            $name_sim   = $simName . '_' . uniqid() . '.' . $foto_sim->getClientOriginalExtension();
            $data = [
                'id_jenis_sim' => $id_jenis_sim,
                'id_driver' => $id_driver,
                'foto_sim' => $name_sim
            ];
            $addSim = DetailSim::create($data);
            if ($addSim) {
                $folder_sim     = 'assets/img_sim';
                $foto_sim->move($folder_sim, $name_sim);
                return response()->json(
                    [
                        'status' => 'sukses',
                        'pesan' => 'SIM berhasil ditambah'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'status' => 'gagal',
                        'pesan' => 'SIM gagal ditambah'
                    ]
                );
            }
        }
    }

    public function updateSim(Request $request)
    {
        $id_driver = $request->id_driver;
        $id_detail_sim = $request->id_detail_sim;
        $foto_sim = $request->file('foto_sim');
        $findDetailSim = DetailSim::where('id_detail_sim', $id_detail_sim)->first();
        if ($findDetailSim) {
            $findDriver = Driver::where('id_driver', $id_driver)->first();
            $findSim = JenisSim::where('id_jenis_sim', $findDetailSim->id_jenis_sim)->first();
            $simName = str_replace(" ", "_", $findSim->nama_sim);
            $name_sim   = $simName . '_' . uniqid() . '.' . $foto_sim->getClientOriginalExtension();
            $data = [
                'foto_sim' => $name_sim
            ];
            if (!is_null($findDetailSim->foto_sim)) {
                File::delete('assets/img_sim/' . $findDetailSim->foto_sim);
            }
            $updateSim = $findDetailSim->update($data);
            if ($updateSim) {
                $folder_sim     = 'assets/img_sim';
                $foto_sim->move($folder_sim, $name_sim);
                return response()->json(
                    [
                        'status' => 'sukses',
                        'pesan' => 'SIM berhasil diganti'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'status' => 'gagal',
                        'pesan' => 'SIM gagal diganti'
                    ]
                );
            }
        }
    }

    public function fotoKtp(Request $request)
    {
        $id_driver = $request->id_driver;
        $foto_ktp = $request->file('foto_ktp');
        $findDriver = Driver::where('id_driver', $id_driver)->select('no_badge', 'foto_ktp')->first();
        if ($findDriver != null) {
            $name_profil   = 'ktp_' . uniqid() . '.' . $foto_ktp->getClientOriginalExtension();
            $data = [
                'foto_ktp' => $name_profil
            ];
            // return $data;
            if (!is_null($findDriver->foto_ktp)) {
                File::delete('assets/img_ktp/' . $findDriver->foto_ktp);
            }
            $update = Driver::where('id_driver', $id_driver)->update($data);
            $folder_profil     = 'assets/img_ktp';
            $foto_ktp->move($folder_profil, $name_profil);
            return response()->json(
                [
                    'status' => 'sukses',
                    'pesan' => 'ktp berhasil diganti',
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'gagal',
                    'pesan' => 'ktp tidak ditemukan',
                ]
            );
        }
    }

    public function updateData(Request $request)
    {
        $id_driver = $request->id_driver;
        $nama_driver = $request->nama_driver;
        $alamat = $request->alamat;
        $umur = $request->umur;
        $no_tlp = $request->no_tlp;
        $findDriver = Driver::where('id_driver', $id_driver)->first();
        if ($findDriver) {
            $defaultUsernameDriver = str_replace("-", "", $findDriver->no_badge);
            $defaultPasswordDriver = str_replace("-", "", $no_tlp);
            $data = [
                'nama_driver' => $nama_driver,
                'alamat' => $alamat,
                'umur'  => $umur,
                'no_tlp' => $no_tlp,
                'user' => $defaultUsernameDriver,
                'password' => Hash::make($defaultPasswordDriver)
            ];
            $update = $findDriver->update($data);
            if ($update) {
                return response()->json(
                    [
                        'status' => 'sukses',
                        'pesan' => 'Data Umum Driver Berhasil Diganti, Username dan Password direset menjadi NO. BADGE dan NO. TLFN',
                    ]
                );
            } else {
                return response()->json(
                    [
                        'status' => 'gagal',
                        'pesan' => 'Data Umum Driver Gagal Diganti',
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'status'        => 'gagal',
                    'pesan'         => 'data tidak ditemukan'
                ]
            );
        }
    }
}
