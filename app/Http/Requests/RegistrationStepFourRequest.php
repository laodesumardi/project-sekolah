<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationStepFourRequest extends FormRequest
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
            'documents' => ['required', 'array', 'min:4'],
            'documents.photo' => ['required', 'file', 'max:1024', 'mimes:jpg,jpeg,png'],
            'documents.ijazah' => ['required', 'file', 'max:2048', 'mimes:pdf,jpg,jpeg,png'],
            'documents.kk' => ['required', 'file', 'max:2048', 'mimes:pdf,jpg,jpeg,png'],
            'documents.akta' => ['required', 'file', 'max:2048', 'mimes:pdf,jpg,jpeg,png'],
            'documents.achievement' => ['nullable', 'array'],
            'documents.achievement.*' => ['file', 'max:3072', 'mimes:pdf,jpg,jpeg,png'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'documents.required' => 'Dokumen wajib diupload.',
            'documents.array' => 'Dokumen harus berupa array.',
            'documents.min' => 'Minimal 4 dokumen wajib diupload.',
            'documents.photo.required' => 'Foto 3x4 wajib diupload.',
            'documents.photo.file' => 'Foto 3x4 harus berupa file.',
            'documents.photo.max' => 'Ukuran foto 3x4 maksimal 1MB.',
            'documents.photo.mimes' => 'Format foto 3x4 harus JPG, JPEG, atau PNG.',
            'documents.ijazah.required' => 'Scan ijazah/SKHUN wajib diupload.',
            'documents.ijazah.file' => 'Scan ijazah/SKHUN harus berupa file.',
            'documents.ijazah.max' => 'Ukuran scan ijazah/SKHUN maksimal 2MB.',
            'documents.ijazah.mimes' => 'Format scan ijazah/SKHUN harus PDF, JPG, JPEG, atau PNG.',
            'documents.kk.required' => 'Scan kartu keluarga wajib diupload.',
            'documents.kk.file' => 'Scan kartu keluarga harus berupa file.',
            'documents.kk.max' => 'Ukuran scan kartu keluarga maksimal 2MB.',
            'documents.kk.mimes' => 'Format scan kartu keluarga harus PDF, JPG, JPEG, atau PNG.',
            'documents.akta.required' => 'Scan akta kelahiran wajib diupload.',
            'documents.akta.file' => 'Scan akta kelahiran harus berupa file.',
            'documents.akta.max' => 'Ukuran scan akta kelahiran maksimal 2MB.',
            'documents.akta.mimes' => 'Format scan akta kelahiran harus PDF, JPG, JPEG, atau PNG.',
            'documents.achievement.array' => 'Sertifikat prestasi harus berupa array.',
            'documents.achievement.*.file' => 'Sertifikat prestasi harus berupa file.',
            'documents.achievement.*.max' => 'Ukuran sertifikat prestasi maksimal 3MB.',
            'documents.achievement.*.mimes' => 'Format sertifikat prestasi harus PDF, JPG, JPEG, atau PNG.',
        ];
    }
}

