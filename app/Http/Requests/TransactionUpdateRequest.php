<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Set this to true if you want to allow all users to make this request.
        // Otherwise, you can implement your own authorization logic.
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
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            // Add other validation rules as needed
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'amount.required' => 'Kolom jumlah transaksi wajib diisi.',
            'amount.numeric' => 'Kolom jumlah transaksi harus berupa angka.',
            'amount.min' => 'Kolom jumlah transaksi harus minimal :min.',
            'description.required' => 'Kolom deskripsi wajib diisi.',
            'description.string' => 'Kolom deskripsi harus berupa string.',
            'description.max' => 'Kolom deskripsi tidak boleh lebih dari :max karakter.',
            // Add other error messages for other validation rules as needed
        ];
    }
}
