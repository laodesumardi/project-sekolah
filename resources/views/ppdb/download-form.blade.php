<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran PPDB - {{ $registration->registration_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1e40af;
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            color: #374151;
            margin: 10px 0 0 0;
            font-size: 18px;
            font-weight: normal;
        }
        .registration-info {
            background: #eff6ff;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        .registration-number {
            font-size: 28px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
        }
        .registration-date {
            color: #6b7280;
            font-size: 14px;
        }
        .form-section {
            margin-bottom: 25px;
        }
        .section-title {
            background: #3b82f6;
            color: white;
            padding: 10px 15px;
            margin: 0 0 15px 0;
            border-radius: 5px;
            font-weight: bold;
        }
        .form-row {
            display: flex;
            margin-bottom: 15px;
            gap: 20px;
        }
        .form-group {
            flex: 1;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            color: #374151;
            margin-bottom: 5px;
        }
        .form-group .value {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            background: #f9fafb;
            min-height: 20px;
        }
        .form-group.full-width {
            flex: 100%;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        @media print {
            body { background: white; }
            .form-container { box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Header -->
        <div class="header">
            <h1>FORM PENDAFTARAN PPDB</h1>
            <h2>SMP Negeri 01 Namrole - Tahun Ajaran {{ $registration->academicYear->year }}</h2>
        </div>

        <!-- Registration Info -->
        <div class="registration-info">
            <div class="registration-number">{{ $registration->registration_number }}</div>
            <div class="registration-date">
                Tanggal Pendaftaran: {{ $registration->created_at->format('d F Y, H:i') }} WIT
            </div>
            <div style="margin-top: 10px;">
                <span class="status-badge status-pending">Status: Menunggu Verifikasi</span>
            </div>
        </div>

        <!-- Data Siswa -->
        <div class="form-section">
            <div class="section-title">DATA SISWA</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="value">{{ $registration->full_name }}</div>
                </div>
                <div class="form-group">
                    <label>NISN</label>
                    <div class="value">{{ $registration->nisn }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <div class="value">{{ $registration->birth_place }}</div>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="value">{{ $registration->birth_date->format('d F Y') }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="value">{{ $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                </div>
                <div class="form-group">
                    <label>Agama</label>
                    <div class="value">{{ $registration->religion }}</div>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="form-section">
            <div class="section-title">DATA ORANG TUA</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Ayah</label>
                    <div class="value">{{ $registration->father_name }}</div>
                </div>
                <div class="form-group">
                    <label>Nama Ibu</label>
                    <div class="value">{{ $registration->mother_name }}</div>
                </div>
            </div>
            @if($registration->father_occupation || $registration->mother_occupation)
            <div class="form-row">
                <div class="form-group">
                    <label>Pekerjaan Ayah</label>
                    <div class="value">{{ $registration->father_occupation ?? '-' }}</div>
                </div>
                <div class="form-group">
                    <label>Pekerjaan Ibu</label>
                    <div class="value">{{ $registration->mother_occupation ?? '-' }}</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Kontak & Alamat -->
        <div class="form-section">
            <div class="section-title">KONTAK & ALAMAT</div>
            <div class="form-row">
                <div class="form-group">
                    <label>No. Telepon/HP</label>
                    <div class="value">{{ $registration->phone }}</div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <div class="value">{{ $registration->email }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group full-width">
                    <label>Alamat Lengkap</label>
                    <div class="value">{{ $registration->address }}</div>
                </div>
            </div>
        </div>

        <!-- Data Prestasi (jika ada) -->
        @if($registration->achievement_name)
        <div class="form-section">
            <div class="section-title">DATA PRESTASI</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Prestasi</label>
                    <div class="value">{{ $registration->achievement_name }}</div>
                </div>
                <div class="form-group">
                    <label>Tingkat Prestasi</label>
                    <div class="value">{{ $registration->achievement_level ?? '-' }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Tahun Prestasi</label>
                    <div class="value">{{ $registration->achievement_year ?? '-' }}</div>
                </div>
                <div class="form-group">
                    <label>Peringkat</label>
                    <div class="value">{{ $registration->achievement_rank ?? '-' }}</div>
                </div>
            </div>
        </div>
        @endif


        <!-- Footer -->
        <div class="footer">
            <p><strong>Form ini adalah bukti pendaftaran PPDB SMP Negeri 01 Namrole</strong></p>
            <p>Simpan form ini untuk keperluan tracking status pendaftaran</p>
            <p>Website: <strong>smpn01namrole.sch.id</strong> | Email: <strong>ppdb@smpn01namrole.sch.id</strong></p>
            <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIT</p>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 1000);
        }
    </script>
</body>
</html>
