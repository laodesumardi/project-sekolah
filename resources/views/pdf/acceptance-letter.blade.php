<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Penerimaan - {{ $registration->registration_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
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
        .letter-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .date {
            text-align: right;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            margin-bottom: 15px;
        }
        .paragraph {
            margin-bottom: 15px;
            text-align: justify;
        }
        .highlight {
            background-color: #ffffcc;
            padding: 2px 4px;
            font-weight: bold;
        }
        .student-info {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #333;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        .info-value {
            flex: 1;
        }
        .signature-section {
            margin-top: 40px;
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
        .congratulations {
            background-color: #e8f5e8;
            border: 2px solid #4caf50;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            border-radius: 8px;
        }
        .congratulations h2 {
            color: #2e7d32;
            margin: 0 0 10px 0;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">SMP NEGERI 01 NAMROLE</div>
        <div class="letter-title">SURAT PENERIMAAN PESERTA DIDIK BARU</div>
        <div class="qr-code">
            <!-- QR Code will be generated here -->
            <div style="width: 80px; height: 80px; background: #f0f0f0; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; font-size: 10px;">
                QR Code
            </div>
        </div>
    </div>

    <div class="date">
        Namrole, {{ now()->format('d F Y') }}
    </div>

    <div class="content">
        <div class="greeting">
            Kepada Yth.<br>
            Orang Tua/Wali dari<br>
            <strong>{{ $registration->full_name }}</strong>
        </div>

        <div class="paragraph">
            Dengan hormat,
        </div>

        <div class="paragraph">
            Berdasarkan hasil seleksi Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran {{ $registration->academicYear->year }}, dengan ini kami mengumumkan bahwa:
        </div>

        <div class="congratulations">
            <h2>🎉 SELAMAT! 🎉</h2>
            <p><strong>{{ $registration->full_name }}</strong></p>
            <p><strong>DITERIMA</strong> sebagai siswa baru SMP Negeri 01 Namrole</p>
            <p>Jalur: <strong>{{ $registration->path_label }}</strong></p>
        </div>

        <div class="student-info">
            <h3 style="margin-top: 0; margin-bottom: 15px;">Data Siswa yang Diterima:</h3>
            <div class="info-row">
                <div class="info-label">Nama Lengkap:</div>
                <div class="info-value">{{ $registration->full_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NIK:</div>
                <div class="info-value">{{ $registration->nik }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NISN:</div>
                <div class="info-value">{{ $registration->nisn }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tempat, Tanggal Lahir:</div>
                <div class="info-value">{{ $registration->birth_place }}, {{ $registration->birth_date->format('d F Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Asal Sekolah:</div>
                <div class="info-value">{{ $registration->previous_school }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Jalur Pendaftaran:</div>
                <div class="info-value">{{ $registration->path_label }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nomor Pendaftaran:</div>
                <div class="info-value">{{ $registration->registration_number }}</div>
            </div>
        </div>

        <div class="paragraph">
            <strong>Langkah Selanjutnya:</strong>
        </div>

        <div class="paragraph">
            1. <strong>Konfirmasi Penerimaan:</strong> Orang tua/wali diharapkan segera melakukan konfirmasi penerimaan dengan menghubungi panitia PPDB melalui telepon (021) 1234-5678 atau email ppdb@smpn01namrole.sch.id selambat-lambatnya 3 (tiga) hari setelah surat ini diterima.
        </div>

        <div class="paragraph">
            2. <strong>Pembayaran:</strong> Setelah konfirmasi, orang tua/wali diharapkan melakukan pembayaran biaya pendaftaran sebesar <span class="highlight">Rp {{ number_format($registration->registrationSetting->registration_fee, 0, ',', '.') }}</span> ke rekening yang akan diinformasikan kemudian.
        </div>

        <div class="paragraph">
            3. <strong>Daftar Ulang:</strong> Setelah pembayaran dikonfirmasi, orang tua/wali diharapkan melakukan daftar ulang dengan membawa dokumen asli untuk verifikasi.
        </div>

        <div class="paragraph">
            4. <strong>Masa Orientasi Siswa (MOS):strong> Siswa baru diharapkan mengikuti MOS yang akan dilaksanakan pada tanggal yang akan diinformasikan kemudian.
        </div>

        <div class="paragraph">
            <strong>Catatan Penting:</strong>
        </div>

        <div class="paragraph">
            • Surat ini berlaku sebagai bukti resmi penerimaan siswa baru.<br>
            • Jika tidak melakukan konfirmasi dalam waktu yang ditentukan, maka penerimaan dianggap batal.<br>
            • Semua dokumen asli harus dibawa saat daftar ulang untuk verifikasi.<br>
            • Informasi lebih lanjut akan disampaikan melalui telepon atau email.
        </div>

        <div class="paragraph">
            Demikian surat ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
        </div>

        <div class="paragraph">
            Hormat kami,<br>
            <strong>Panitia PPDB SMP Negeri 01 Namrole</strong>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Ketua Panitia PPDB</div>
            <div style="margin-top: 20px;">(_________________)</div>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Kepala Sekolah</div>
            <div style="margin-top: 20px;">(_________________)</div>
        </div>
    </div>

    <div class="footer">
        <p>Surat ini dicetak pada {{ now()->format('d F Y, H:i') }}</p>
        <p>Untuk informasi lebih lanjut, hubungi: {{ $homepageSetting->contact_phone ?? '(021) 1234-5678' }} atau email: {{ $homepageSetting->contact_email ?? 'ppdb@smpn01namrole.sch.id' }}</p>
        <p><strong>Selamat bergabung di SMP Negeri 01 Namrole!</strong></p>
    </div>
</body>
</html>

