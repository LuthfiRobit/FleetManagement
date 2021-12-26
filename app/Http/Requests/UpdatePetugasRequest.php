<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePetugasRequest extends FormRequest
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
            'no_badge'          => 'required|max:10',
            'id_jabatan'        => 'required',
            'id_departemen'     => 'required',
            'nama_lengkap'      => 'required|max:45',
            'tempat_lahir'      => 'required|max:20',
            'tgl_lahir'         => 'required',
            'tgl_mulai_kerja'   => 'required',
            'no_tlp'            => 'required|max:15',
            'status'            => 'required'
        ];
    }
}
