<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillingStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules = [
            'student_id' => 'required|array',
            'student_id.*' => 'required|exists:students,id',
            'id_telegram' => 'required|string|max:15',
            'bill' => 'required|numeric|min:0',
            // 'date' => 'required|date',
        ];

        // Cek apakah "Lain-Lain" dipilih
        if (in_array('Lain Lain', $this->input('kategori_tagihan', []))) {
            // Jika "Lain-Lain" dipilih, maka kategory_tagihan.* (setiap elemen dalam array) menjadi opsional
            $rules['kategory_tagihan.*'] = 'nullable|string';
        } else {
            // Jika tidak, maka kategory_tagihan.* (setiap elemen dalam array) tetap harus ada
            $rules['kategory_tagihan.*'] = 'required';
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'student_id.required' => 'Kolom siswa wajib diisi.',
            'student_id.array' => 'Kolom siswa harus berupa array.',
            'student_id.*.required' => 'Kolom siswa wajib diisi untuk semua siswa yang dipilih.',
            'student_id.*.exists' => 'Siswa yang dipilih tidak valid.',
            'id_telegram.required' => 'Kolom ID Telegram wajib diisi.',
            'id_telegram.string' => 'Kolom ID Telegram harus berupa string.',
            'id_telegram.max' => 'Kolom ID Telegram tidak boleh lebih dari :max karakter.',
            'bill.required' => 'Kolom tagihan wajib diisi.',
            'bill.numeric' => 'Kolom tagihan harus berupa angka.',
            'bill.min' => 'Kolom tagihan harus minimal :min.',
            // 'date.required' => 'Kolom tanggal jatuh tempo wajib diisi.',
            'date.date' => 'Kolom tanggal jatuh tempo harus tanggal yang valid.',
            'kategori_tagihan.required' => 'Kategori tagihan wajib diisi!',

        ];
    }
}
