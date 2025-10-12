<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationStepOneRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'digits:16', 'unique:registrations,nik'],
            'nisn' => ['required', 'digits:10', 'unique:registrations,nisn'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today', 'after:2005-01-01'],
            'gender' => ['required', 'in:L,P'],
            'religion' => ['required', 'string', 'max:50'],
            'child_number' => ['required', 'integer', 'min:1', 'max:20'],
            'siblings_count' => ['required', 'integer', 'min:0', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'rt' => ['required', 'string', 'max:3'],
            'rw' => ['required', 'string', 'max:3'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:5'],
            'phone' => ['required', 'string', 'min:10', 'max:15'],
            'email' => ['required', 'email', 'unique:registrations,email'],
            'height' => ['nullable', 'integer', 'min:50', 'max:250'],
            'weight' => ['nullable', 'integer', 'min:10', 'max:200'],
            'blood_type' => ['nullable', 'string', 'max:5'],
            'medical_history' => ['nullable', 'string', 'max:1000'],
            'photo' => ['required', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'full_name.max' => 'Nama lengkap maksimal 255 karakter.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.digits' => 'NISN harus 10 digit.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'birth_date.after' => 'Tanggal lahir harus setelah 1 Januari 2005.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'religion.required' => 'Agama wajib diisi.',
            'child_number.required' => 'Anak ke-berapa wajib diisi.',
            'child_number.min' => 'Anak ke-berapa minimal 1.',
            'child_number.max' => 'Anak ke-berapa maksimal 20.',
            'siblings_count.required' => 'Jumlah saudara kandung wajib diisi.',
            'siblings_count.min' => 'Jumlah saudara kandung minimal 0.',
            'siblings_count.max' => 'Jumlah saudara kandung maksimal 20.',
            'address.required' => 'Alamat lengkap wajib diisi.',
            'address.max' => 'Alamat lengkap maksimal 500 karakter.',
            'rt.required' => 'RT wajib diisi.',
            'rw.required' => 'RW wajib diisi.',
            'kelurahan.required' => 'Kelurahan wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'city.required' => 'Kota/Kabupaten wajib diisi.',
            'province.required' => 'Provinsi wajib diisi.',
            'postal_code.required' => 'Kode pos wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.min' => 'Nomor telepon minimal 10 digit.',
            'phone.max' => 'Nomor telepon maksimal 15 digit.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'height.integer' => 'Tinggi badan harus berupa angka.',
            'height.min' => 'Tinggi badan minimal 50 cm.',
            'height.max' => 'Tinggi badan maksimal 250 cm.',
            'weight.integer' => 'Berat badan harus berupa angka.',
            'weight.min' => 'Berat badan minimal 10 kg.',
            'weight.max' => 'Berat badan maksimal 200 kg.',
            'blood_type.max' => 'Golongan darah maksimal 5 karakter.',
            'medical_history.max' => 'Riwayat penyakit maksimal 1000 karakter.',
            'photo.required' => 'Foto siswa wajib diupload.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran file maksimal 2MB.',
            'photo.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
        ];
    }
}

