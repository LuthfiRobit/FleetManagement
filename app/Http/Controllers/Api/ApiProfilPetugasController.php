<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ApiProfilPetugasController extends Controller
{
    public function profil(Request $request)
    {
        $id_petugas = $request->query('id_petugas');
        $findPetugas = DB::table('tb_petugas')
            ->select(
                'tb_petugas.id_petugas',
                'tb_petugas.nama_lengkap',
                'tb_petugas.tempat_lahir as tmp_lahir',
                'tb_petugas.tgl_lahir',
                'tb_petugas.no_tlp',
                'tb_petugas.user as username',
                'tb_petugas.foto_petugas',
                'tb_departemen.nama_departemen',
                'tb_jabatan.nama_jabatan'
            )
            ->leftJoin('tb_jabatan', 'tb_jabatan.id_jabatan', '=', 'tb_petugas.id_jabatan')
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_petugas.id_departemen')
            ->where('tb_petugas.id_petugas', $id_petugas)
            ->first();
        if ($findPetugas) {
            return response()->json(
                [
                    'status'        => 'sukses',
                    'profil_petugas' => $findPetugas
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal'
                ]
            );
        }
    }

    public function fotoPetugas(Request $request)
    {
        $id_petugas = $request->id_petugas;
        $foto_petugas = $request->file('foto_petugas');
        $findPetugas = Petugas::select('no_badge', 'foto_petugas')->where('id_petugas', $id_petugas)->first();
        if ($findPetugas != null) {
            $name_profil = 'prp_' . $findPetugas->no_badge . '.' . $foto_petugas->getClientOriginalExtension();
            $data = [
                'foto_petugas' => $name_profil
            ];
            if (!is_null($findPetugas->foto_petugas)) {
                File::delete('assets/img_petugas/' . $findPetugas->foto_petugas);
            }
            $update = Petugas::where('id_petugas', $id_petugas)->update($data);
            $folder_profil = 'assets/img_petugas';
            $foto_petugas->move($folder_profil, $name_profil);
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

    public function username(Request $request)
    {
        $id_petugas = $request->id_petugas;
        $username = $request->username;
        $findPetugas = Petugas::where('id_petugas', $id_petugas)->first();
        if ($findPetugas) {
            $findPetugas->update(['user' => $username]);
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

    public function password(Request $request)
    {
        $id_petugas = $request->id_petugas;
        $password_lama = $request->password_lama;
        $password_baru = $request->password_baru;
        $findPetugas = Petugas::where('id_petugas', $id_petugas)->first();
        $rules = [
            'password_baru' => [
                'required',
                'string',
                Password::min(8)->mixedCase()
            ],
            'password_lama' => [
                'required',
                function ($attribute, $value, $fail) use ($findPetugas) {
                    if (!Hash::check($value, $findPetugas->password)) {
                        return $fail(__('Password lama tidak cocok'));
                    }
                }
            ]
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'gagal',
                    'errors' => $validator->errors()
                ],
                422
            );
        } else {
            $data = ['password' => Hash::make($password_baru)];
            $updatePassword = $findPetugas->update($data);
            if ($updatePassword) {
                return response()->json(
                    [
                        'status' => 'sukses',
                        'pesan' => 'password berhasil diganti',
                    ]
                );
            } else {
                return response()->json(
                    [
                        'status' => 'gagal',
                        'pesan' => 'password gagal diganti',
                    ]
                );
            }
        }
    }

    public function formEdit(Request $request)
    {
        $id_petugas = $request->query('id_petugas');
        $findPetugas = DB::table('tb_petugas')
            ->select(
                'tb_petugas.id_petugas',
                'tb_petugas.nama_lengkap',
                'tb_petugas.tempat_lahir as tmp_lahir',
                'tb_petugas.tgl_lahir',
                'tb_petugas.no_tlp',
                'tb_petugas.id_departemen',
                'tb_petugas.id_jabatan',
                'tb_departemen.nama_departemen',
                'tb_jabatan.nama_jabatan'
            )
            ->leftJoin('tb_jabatan', 'tb_jabatan.id_jabatan', '=', 'tb_petugas.id_jabatan')
            ->leftJoin('tb_departemen', 'tb_departemen.id_departemen', '=', 'tb_petugas.id_departemen')
            ->where('tb_petugas.id_petugas', $id_petugas)
            ->first();
        $departemen = Departemen::where('status', 'y')->get();
        $jabatan    = Jabatan::where('status', 'y')->get();
        if ($findPetugas) {
            return response()->json(
                [
                    'status'        => 'sukses',
                    'profil_petugas' => $findPetugas,
                    'list_departemen' => $departemen,
                    'list_jabatan' => $jabatan
                ]
            );
        } else {
            return response()->json(
                [
                    'status'        => 'gagal'
                ]
            );
        }
    }

    public function updateData(Request $request)
    {
        $id_petugas = $request->id_petugas;
        $nama_lengkap = $request->nama_lengkap;
        $tmp_lahir = $request->tmp_lahir;
        $tgl_lahir = $request->tgl_lahir;
        $no_tlp = $request->no_tlp;
        $id_departemen = $request->id_departemen;
        $id_jabatan = $request->id_jabatan;
        $findPetugas = Petugas::where('id_petugas', $id_petugas)->first();
        if ($findPetugas) {
            $data = [
                'id_departemen' => $id_departemen,
                'id_jabatan' => $id_jabatan,
                'no_tlp' => $no_tlp,
                'tgl_lahir' => Carbon::parse($tgl_lahir)->format('Y-m-d'),
                'tempat_lahir' => $tmp_lahir,
                'nama_lengkap' => $nama_lengkap
            ];
            $update = $findPetugas->update($data);
            if ($update) {
                return response()->json(
                    [
                        'status'        => 'sukses',
                        'pesan'         => 'data berhasil diupdate'
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'status'        => 'gagal'
                ]
            );
        }
    }
}
