<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillingUpdateRequest extends FormRequest
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
            'student_id' => 'required',
            'bill' => 'required|numeric|min:0',
            'date' => 'required|date',
            // 'kategori_tagihan' => 'nullable|string|max:191'
        ];

        // Cek apakah "Lain-Lain" dipilih
        if (in_array('Lain Lain', $this->input('kategori_tagihan', []))) {
            // Jika "Lain-Lain" dipilih, maka category.* (setiap elemen dalam array) menjadi opsional
            $rules['kategori_tagihan.*'] = 'nullable|string';
        } else {
            // Jika tidak, maka category.* (setiap elemen dalam array) tetap harus ada
            $rules['kategori_tagihan.*'] = 'required|string';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'student_id.required' => 'Kolom nama pelajar wajib diisi!',

            'bill.required' => 'Kolom tagihan wajib diisi!',
            'bill.numeric' => 'Kolom tagihan harus angka!',
            'bill.min' => 'Kolom tagihan harus minimal 0!',
            'date.required' => 'Kolom tanggal jatuh tempo wajib diisi!',
            'date.date' => 'Kolom tanggal jatuh tempo harus tanggal yang valid!',

            // 'kategori_tagihan.max' => 'Kolom kategori tagihan maksimal 191 karakter!'
        ];
    }
}
