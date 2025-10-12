<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationStepThreeRequest extends FormRequest
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
            'previous_school' => ['required', 'string', 'max:255'],
            'school_npsn' => ['required', 'string', 'size:8'],
            'school_address' => ['required', 'string', 'max:500'],
            'graduation_year' => ['required', 'integer', 'min:2020', 'max:' . date('Y')],
            'certificate_number' => ['required', 'string', 'max:100'],
            'average_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'achievements' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'previous_school.required' => 'Asal sekolah wajib diisi.',
            'previous_school.max' => 'Asal sekolah maksimal 255 karakter.',
            'school_npsn.required' => 'NPSN sekolah wajib diisi.',
            'school_npsn.size' => 'NPSN sekolah harus 8 digit.',
            'school_address.required' => 'Alamat sekolah wajib diisi.',
            'school_address.max' => 'Alamat sekolah maksimal 500 karakter.',
            'graduation_year.required' => 'Tahun lulus wajib diisi.',
            'graduation_year.integer' => 'Tahun lulus harus berupa angka.',
            'graduation_year.min' => 'Tahun lulus minimal 2020.',
            'graduation_year.max' => 'Tahun lulus maksimal ' . date('Y') . '.',
            'certificate_number.required' => 'Nomor ijazah wajib diisi.',
            'certificate_number.max' => 'Nomor ijazah maksimal 100 karakter.',
            'average_score.required' => 'Nilai rata-rata wajib diisi.',
            'average_score.numeric' => 'Nilai rata-rata harus berupa angka.',
            'average_score.min' => 'Nilai rata-rata minimal 0.',
            'average_score.max' => 'Nilai rata-rata maksimal 100.',
            'achievements.max' => 'Prestasi maksimal 1000 karakter.',
        ];
    }
}

