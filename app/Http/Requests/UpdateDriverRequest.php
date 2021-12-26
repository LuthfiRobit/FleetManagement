<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateDriverRequest extends FormRequest
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
            'id_departemen' => 'required',
            'no_badge'      => 'required',
            // 'no_ktp'        => 'required|max:16',
            'nama_driver'   => 'required|max:45',
            'alamat'        => 'required|max:60',
            'umur'          => 'required|max:3',
            'no_tlp'        => 'required|max:15',
            // 'no_sim'        => 'required|max:13',
            // 'foto_ktp'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'foto_SIM'      => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'User'          => 'required|max:45',
            // 'password'      => [
            //     'required',
            //     'string',
            //     Password::min(8)
            //         ->mixedCase()
            //         ->numbers()
            //         ->uncompromised(),
            // ]
        ];
    }
}
