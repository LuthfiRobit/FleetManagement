<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailSim;
use App\Models\Driver;
use App\Models\DriverStatus;
use App\Models\JenisSim;
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
                'tb_departemen.nama_departemen'
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
}
