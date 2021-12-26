<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreDriverRequest extends FormRequest
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
            'nama_driver'   => 'required|max:45',
            'alamat'        => 'required|max:60',
            'umur'          => 'required|max:3',
            'no_tlp'        => 'required|max:15',
        ];
    }
}
