<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKendaraanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_jenis_kendaraan' => 'required',
            'id_merk' => 'required',
            'id_bahan_bakar' => 'required',
            'id_jenis_sim' => 'required',
            'kode_asset' => 'required|max:20',
            'no_polisi' => 'required|max:11',
            'nomor_rangka' => 'required|max:45',
            'nomor_mesin' => 'required|max:45',
            'nama_kendaraan' => 'required|max:20',
            'warna' => 'required|max:20',
            'tanggal_pembelian' => 'required',
            // 'harga' => 'required',
            'jenis_penggerak' => 'required',
            'tahun_kendaraan' => 'required',
            'pemilik' => 'required',
            'status' => 'required'
        ];
    }
}
