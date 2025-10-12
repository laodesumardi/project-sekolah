<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulir Pendaftaran PPDB - {{ $registration->registration_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 10px;
        }
        .school-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .registration-number {
            font-size: 14px;
            color: #666;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 8px;
            margin-bottom: 10px;
            border-left: 4px solid #333;
        }
        .form-row {
            display: flex;
            margin-bottom: 8px;
        }
        .form-group {
            flex: 1;
            margin-right: 15px;
        }
        .form-group:last-child {
            margin-right: 0;
        }
        .label {
            font-weight: bold;
            margin-bottom: 3px;
        }
        .value {
            border-bottom: 1px solid #333;
            padding: 2px 0;
            min-height: 18px;
        }
        .photo-placeholder {
            width: 100px;
            height: 130px;
            border: 2px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            text-align: center;
        }
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            height: 50px;
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .qr-code {
            width: 80px;
            height: 80px;
            float: right;
            margin-top: -20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">SMP NEGERI 01 NAMROLE</div>
        <div class="form-title">FORMULIR PENDAFTARAN PPDB TAHUN AJARAN {{ $registration->academicYear->year }}</div>
        <div class="registration-number">Nomor Pendaftaran: {{ $registration->registration_number }}</div>
        <div class="qr-code">
            <!-- QR Code will be generated here -->
            <div style="width: 80px; height: 80px; background: #f0f0f0; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; font-size: 10px;">
                QR Code
            </div>
        </div>
    </div>

    <!-- Data Pribadi Siswa -->
    <div class="section">
        <div class="section-title">A. DATA PRIBADI SISWA</div>
        
        <div class="form-row">
            <div class="form-group" style="flex: 2;">
                <div class="label">Nama Lengkap (Sesuai Ijazah)</div>
                <div class="value">{{ $registration->full_name }}</div>
            </div>
            <div class="form-group" style="flex: 1;">
                <div class="label">Jenis Kelamin</div>
                <div class="value">{{ $registration->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
            </div>
            <div class="form-group" style="flex: 1;">
                <div class="photo-placeholder">
                    Foto 3x4<br>
                    Latar Belakang<br>
                    Merah
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <div class="label">NIK</div>
                <div class="value">{{ $registration->nik }}</div>
            </div>
            <div class="form-group">
                <div class="label">NISN</div>
                <div class="value">{{ $registration->nisn }}</div>
            </div>
            <div class="form-group">
                <div class="label">Tempat, Tanggal Lahir</div>
                <div class="value">{{ $registration->birth_place }}, {{ $registration->birth_date->format('d F Y') }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <div class="label">Agama</div>
                <div class="value">{{ $registration->religion }}</div>
            </div>
            <div class="form-group">
                <div class="label">Anak Ke-</div>
                <div class="value">{{ $registration->child_number }}</div>
            </div>
            <div class="form-group">
                <div class="label">Jumlah Saudara Kandung</div>
                <div class="value">{{ $registration->siblings_count }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group" style="flex: 2;">
                <div class="label">Alamat Lengkap</div>
                <div class="value">{{ $registration->full_address }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <div class="label">No. Telepon/HP</div>
                <div class="value">{{ $registration->phone }}</div>
            </div>
            <div class="form-group">
                <div class="label">Email</div>
                <div class="value">{{ $registration->email }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <div class="label">Tinggi Badan</div>
                <div class="value">{{ $registration->height ? $registration->height . ' cm' : '-' }}</div>
            </div>
            <div class="form-group">
                <div class="label">Berat Badan</div>
                <div class="value">{{ $registration->weight ? $registration->weight . ' kg' : '-' }}</div>
            </div>
            <div class="form-group">
                <div class="label">Golongan Darah</div>
                <div class="value">{{ $registration->blood_type ?: '-' }}</div>
            </div>
        </div>

        @if($registration->medical_history)
        <div class="form-row">
            <div class="form-group" style="flex: 2;">
                <div class="label">Riwayat Penyakit</div>
                <div class="value">{{ $registration->medical_history }}</div>
            </div>
        </div>
        @endif
    </div>

    <!-- Data Orang Tua -->
    <div class="section">
        <div class="section-title">B. DATA ORANG TUA/WALI</div>
        
        <div style="margin-bottom: 15px;">
            <strong>Data Ayah:</strong>
        </div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">Nama Lengkap</div>
                <div class="value">{{ $registration->father_name }}</div>
            </div>
            <div class="form-group">
                <div class="label">NIK</div>
                <div class="value">{{ $registration->father_nik }}</div>
            </div>
            <div class="form-group">
                <div class="label">Tahun Lahir</div>
                <div class="value">{{ $registration->father_birth_year }}</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">Pendidikan Terakhir</div>
                <div class="value">{{ $registration->father_education }}</div>
            </div>
            <div class="form-group">
                <div class="label">Pekerjaan</div>
                <div class="value">{{ $registration->father_occupation }}</div>
            </div>
            <div class="form-group">
                <div class="label">Penghasilan</div>
                <div class="value">{{ $registration->father_income }}</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">No. Telepon</div>
                <div class="value">{{ $registration->father_phone }}</div>
            </div>
        </div>

        <div style="margin: 15px 0;">
            <strong>Data Ibu:</strong>
        </div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">Nama Lengkap</div>
                <div class="value">{{ $registration->mother_name }}</div>
            </div>
            <div class="form-group">
                <div class="label">NIK</div>
                <div class="value">{{ $registration->mother_nik }}</div>
            </div>
            <div class="form-group">
                <div class="label">Tahun Lahir</div>
                <div class="value">{{ $registration->mother_birth_year }}</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">Pendidikan Terakhir</div>
                <div class="value">{{ $registration->mother_education }}</div>
            </div>
            <div class="form-group">
                <div class="label">Pekerjaan</div>
                <div class="value">{{ $registration->mother_occupation }}</div>
            </div>
            <div class="form-group">
                <div class="label">Penghasilan</div>
                <div class="value">{{ $registration->mother_income }}</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">No. Telepon</div>
                <div class="value">{{ $registration->mother_phone }}</div>
            </div>
        </div>

        @if($registration->guardian_name)
        <div style="margin: 15px 0;">
            <strong>Data Wali:</strong>
        </div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">Nama Lengkap</div>
                <div class="value">{{ $registration->guardian_name }}</div>
            </div>
            <div class="form-group">
                <div class="label">Hubungan</div>
                <div class="value">{{ $registration->guardian_relation }}</div>
            </div>
            <div class="form-group">
                <div class="label">No. Telepon</div>
                <div class="value">{{ $registration->guardian_phone }}</div>
            </div>
        </div>
        @endif
    </div>

    <!-- Data Pendidikan -->
    <div class="section">
        <div class="section-title">C. DATA PENDIDIKAN SEBELUMNYA</div>
        
        <div class="form-row">
            <div class="form-group" style="flex: 2;">
                <div class="label">Asal Sekolah (SD/MI)</div>
                <div class="value">{{ $registration->previous_school }}</div>
            </div>
            <div class="form-group">
                <div class="label">NPSN</div>
                <div class="value">{{ $registration->school_npsn }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group" style="flex: 2;">
                <div class="label">Alamat Sekolah</div>
                <div class="value">{{ $registration->school_address }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <div class="label">Tahun Lulus</div>
                <div class="value">{{ $registration->graduation_year }}</div>
            </div>
            <div class="form-group">
                <div class="label">No. Ijazah</div>
                <div class="value">{{ $registration->certificate_number }}</div>
            </div>
            <div class="form-group">
                <div class="label">Nilai Rata-rata</div>
                <div class="value">{{ $registration->average_score }}</div>
            </div>
        </div>

        @if($registration->achievements)
        <div class="form-row">
            <div class="form-group" style="flex: 2;">
                <div class="label">Prestasi yang Pernah Diraih</div>
                <div class="value">{{ $registration->achievements }}</div>
            </div>
        </div>
        @endif
    </div>

    <!-- Jalur Pendaftaran -->
    <div class="section">
        <div class="section-title">D. JALUR PENDAFTARAN</div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">Jalur yang Dipilih</div>
                <div class="value">{{ $registration->path_label }}</div>
            </div>
        </div>
    </div>

    <!-- Dokumen -->
    <div class="section">
        <div class="section-title">E. DOKUMEN YANG DIUPLOAD</div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">✓ Foto 3x4</div>
                <div class="value">Sudah diupload</div>
            </div>
            <div class="form-group">
                <div class="label">✓ Scan Ijazah/SKHUN</div>
                <div class="value">Sudah diupload</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">✓ Scan Kartu Keluarga</div>
                <div class="value">Sudah diupload</div>
            </div>
            <div class="form-group">
                <div class="label">✓ Scan Akta Kelahiran</div>
                <div class="value">Sudah diupload</div>
            </div>
        </div>
        @if($registration->documents->where('document_type', 'achievement')->count() > 0)
        <div class="form-row">
            <div class="form-group">
                <div class="label">✓ Sertifikat Prestasi</div>
                <div class="value">Sudah diupload ({{ $registration->documents->where('document_type', 'achievement')->count() }} file)</div>
            </div>
        </div>
        @endif
    </div>

    <!-- Status -->
    <div class="section">
        <div class="section-title">F. STATUS PENDAFTARAN</div>
        <div class="form-row">
            <div class="form-group">
                <div class="label">Status</div>
                <div class="value">{{ $registration->status_label }}</div>
            </div>
            <div class="form-group">
                <div class="label">Tanggal Pendaftaran</div>
                <div class="value">{{ $registration->created_at->format('d F Y, H:i') }}</div>
            </div>
        </div>
        @if($registration->verified_at)
        <div class="form-row">
            <div class="form-group">
                <div class="label">Tanggal Verifikasi</div>
                <div class="value">{{ $registration->verified_at->format('d F Y, H:i') }}</div>
            </div>
            <div class="form-group">
                <div class="label">Diverifikasi Oleh</div>
                <div class="value">{{ $registration->verifier->name ?? 'Admin' }}</div>
            </div>
        </div>
        @endif
        @if($registration->admin_notes)
        <div class="form-row">
            <div class="form-group" style="flex: 2;">
                <div class="label">Catatan Admin</div>
                <div class="value">{{ $registration->admin_notes }}</div>
            </div>
        </div>
        @endif
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Orang Tua/Wali</div>
            <div style="margin-top: 20px;">({{ $registration->father_name }})</div>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Panitia PPDB</div>
            <div style="margin-top: 20px;">(_________________)</div>
        </div>
    </div>

    <div class="footer">
        <p>Formulir ini dicetak pada {{ now()->format('d F Y, H:i') }}</p>
        <p>Untuk informasi lebih lanjut, hubungi: (021) 1234-5678 atau email: ppdb@smpn01namrole.sch.id</p>
    </div>
</body>
</html>

