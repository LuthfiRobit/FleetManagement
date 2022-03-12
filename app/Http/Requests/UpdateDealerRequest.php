<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDealerRequest extends FormRequest
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
            'nama_dealer' => 'required|max:100',
            'alamat' => 'required',
            // 'no_tlp' => 'required',
            'status' => 'required',
            'status_dealer' => 'required'
        ];
    }
}
