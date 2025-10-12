<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationStepTwoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'father_name' => ['required', 'string', 'max:255'],
            'father_nik' => ['required', 'digits:16'],
            'father_birth_year' => ['required', 'integer', 'min:1950', 'max:' . (date('Y') - 15)],
            'father_education' => ['required', 'string', 'max:100'],
            'father_occupation' => ['required', 'string', 'max:100'],
            'father_income' => ['required', 'string', 'max:50'],
            'father_phone' => ['required', 'string', 'min:10', 'max:15'],
            'mother_name' => ['required', 'string', 'max:255'],
            'mother_nik' => ['required', 'digits:16'],
            'mother_birth_year' => ['required', 'integer', 'min:1950', 'max:' . (date('Y') - 15)],
            'mother_education' => ['required', 'string', 'max:100'],
            'mother_occupation' => ['required', 'string', 'max:100'],
            'mother_income' => ['required', 'string', 'max:50'],
            'mother_phone' => ['required', 'string', 'min:10', 'max:15'],
            'guardian_name' => ['nullable', 'string', 'max:255'],
            'guardian_relation' => ['nullable', 'string', 'max:50'],
            'guardian_phone' => ['nullable', 'string', 'min:10', 'max:15'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'father_name.required' => 'Nama ayah wajib diisi.',
            'father_name.max' => 'Nama ayah maksimal 255 karakter.',
            'father_nik.required' => 'NIK ayah wajib diisi.',
            'father_nik.digits' => 'NIK ayah harus 16 digit.',
            'father_birth_year.required' => 'Tahun lahir ayah wajib diisi.',
            'father_birth_year.integer' => 'Tahun lahir ayah harus berupa angka.',
            'father_birth_year.min' => 'Tahun lahir ayah minimal 1950.',
            'father_birth_year.max' => 'Tahun lahir ayah maksimal ' . (date('Y') - 15) . '.',
            'father_education.required' => 'Pendidikan terakhir ayah wajib diisi.',
            'father_education.max' => 'Pendidikan terakhir ayah maksimal 100 karakter.',
            'father_occupation.required' => 'Pekerjaan ayah wajib diisi.',
            'father_occupation.max' => 'Pekerjaan ayah maksimal 100 karakter.',
            'father_income.required' => 'Penghasilan ayah wajib diisi.',
            'father_income.max' => 'Penghasilan ayah maksimal 50 karakter.',
            'father_phone.required' => 'Nomor telepon ayah wajib diisi.',
            'father_phone.min' => 'Nomor telepon ayah minimal 10 digit.',
            'father_phone.max' => 'Nomor telepon ayah maksimal 15 digit.',
            'mother_name.required' => 'Nama ibu wajib diisi.',
            'mother_name.max' => 'Nama ibu maksimal 255 karakter.',
            'mother_nik.required' => 'NIK ibu wajib diisi.',
            'mother_nik.digits' => 'NIK ibu harus 16 digit.',
            'mother_birth_year.required' => 'Tahun lahir ibu wajib diisi.',
            'mother_birth_year.integer' => 'Tahun lahir ibu harus berupa angka.',
            'mother_birth_year.min' => 'Tahun lahir ibu minimal 1950.',
            'mother_birth_year.max' => 'Tahun lahir ibu maksimal ' . (date('Y') - 15) . '.',
            'mother_education.required' => 'Pendidikan terakhir ibu wajib diisi.',
            'mother_education.max' => 'Pendidikan terakhir ibu maksimal 100 karakter.',
            'mother_occupation.required' => 'Pekerjaan ibu wajib diisi.',
            'mother_occupation.max' => 'Pekerjaan ibu maksimal 100 karakter.',
            'mother_income.required' => 'Penghasilan ibu wajib diisi.',
            'mother_income.max' => 'Penghasilan ibu maksimal 50 karakter.',
            'mother_phone.required' => 'Nomor telepon ibu wajib diisi.',
            'mother_phone.min' => 'Nomor telepon ibu minimal 10 digit.',
            'mother_phone.max' => 'Nomor telepon ibu maksimal 15 digit.',
            'guardian_name.max' => 'Nama wali maksimal 255 karakter.',
            'guardian_relation.max' => 'Hubungan dengan siswa maksimal 50 karakter.',
            'guardian_phone.min' => 'Nomor telepon wali minimal 10 digit.',
            'guardian_phone.max' => 'Nomor telepon wali maksimal 15 digit.',
        ];
    }
}

