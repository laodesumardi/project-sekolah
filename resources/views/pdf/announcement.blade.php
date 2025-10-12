<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengumuman Hasil PPDB - {{ $academicYear->year }}</title>
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
        .announcement-title {
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
        .statistics {
            background-color: #f9f9f9;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #333;
        }
        .stat-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .stat-label {
            font-weight: bold;
        }
        .stat-value {
            color: #333;
        }
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .results-table th,
        .results-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        .results-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .results-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .accepted {
            background-color: #e8f5e8 !important;
            color: #2e7d32;
            font-weight: bold;
        }
        .reserved {
            background-color: #fff3e0 !important;
            color: #f57c00;
            font-weight: bold;
        }
        .rejected {
            background-color: #ffebee !important;
            color: #c62828;
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
        .page-break {
            page-break-before: always;
        }
        .summary-box {
            background-color: #e3f2fd;
            border: 2px solid #2196f3;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .summary-box h3 {
            margin-top: 0;
            color: #1976d2;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">SMP NEGERI 01 NAMROLE</div>
        <div class="announcement-title">PENGUMUMAN HASIL SELEKSI PPDB TAHUN AJARAN {{ $academicYear->year }}</div>
    </div>

    <div class="date">
        Namrole, {{ now()->format('d F Y') }}
    </div>

    <div class="content">
        <div class="greeting">
            Kepada Yth.<br>
            Orang Tua/Wali Calon Siswa<br>
            SMP Negeri 01 Namrole
        </div>

        <div class="paragraph">
            Dengan hormat,
        </div>

        <div class="paragraph">
            Berdasarkan hasil seleksi Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran {{ $academicYear->year }}, dengan ini kami mengumumkan hasil seleksi sebagai berikut:
        </div>

        <div class="summary-box">
            <h3>📊 RINGKASAN HASIL SELEKSI</h3>
            <div class="stat-row">
                <div class="stat-label">Total Pendaftar:</div>
                <div class="stat-value">{{ number_format($statistics['total']) }} orang</div>
            </div>
            <div class="stat-row">
                <div class="stat-label">Diterima:</div>
                <div class="stat-value">{{ number_format($statistics['accepted']) }} orang</div>
            </div>
            <div class="stat-row">
                <div class="stat-label">Cadangan:</div>
                <div class="stat-value">{{ number_format($statistics['reserved']) }} orang</div>
            </div>
            <div class="stat-row">
                <div class="stat-label">Tidak Diterima:</div>
                <div class="stat-value">{{ number_format($statistics['rejected']) }} orang</div>
            </div>
        </div>

        <div class="paragraph">
            <strong>Daftar Lengkap Hasil Seleksi:</strong>
        </div>

        <table class="results-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">No. Pendaftaran</th>
                    <th style="width: 25%;">Nama Lengkap</th>
                    <th style="width: 20%;">Asal Sekolah</th>
                    <th style="width: 15%;">Jalur</th>
                    <th style="width: 20%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrations as $index => $registration)
                <tr class="@if($registration->status === 'accepted') accepted @elseif($registration->status === 'reserved') reserved @elseif($registration->status === 'rejected') rejected @endif">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $registration->registration_number }}</td>
                    <td>{{ $registration->full_name }}</td>
                    <td>{{ $registration->previous_school }}</td>
                    <td>{{ $registration->path_label }}</td>
                    <td>
                        @if($registration->status === 'accepted')
                            ✅ DITERIMA
                        @elseif($registration->status === 'reserved')
                            ⏳ CADANGAN
                        @elseif($registration->status === 'rejected')
                            ❌ TIDAK DITERIMA
                        @else
                            {{ $registration->status_label }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="paragraph">
            <strong>Keterangan Status:</strong>
        </div>

        <div class="paragraph">
            • <strong>DITERIMA:</strong> Calon siswa dinyatakan diterima dan berhak mengikuti proses selanjutnya.<br>
            • <strong>CADANGAN:</strong> Calon siswa masuk dalam daftar cadangan dan akan dipanggil jika ada kuota kosong.<br>
            • <strong>TIDAK DITERIMA:</strong> Calon siswa tidak memenuhi kriteria seleksi.
        </div>

        <div class="paragraph">
            <strong>Langkah Selanjutnya untuk Siswa yang DITERIMA:</strong>
        </div>

        <div class="paragraph">
            1. <strong>Konfirmasi Penerimaan:</strong> Orang tua/wali siswa yang diterima diharapkan segera melakukan konfirmasi penerimaan dengan menghubungi panitia PPDB melalui telepon (021) 1234-5678 atau email ppdb@smpn01namrole.sch.id selambat-lambatnya 3 (tiga) hari setelah pengumuman ini.
        </div>

        <div class="paragraph">
            2. <strong>Pembayaran:</strong> Setelah konfirmasi, orang tua/wali diharapkan melakukan pembayaran biaya pendaftaran sesuai dengan ketentuan yang berlaku.
        </div>

        <div class="paragraph">
            3. <strong>Daftar Ulang:</strong> Setelah pembayaran dikonfirmasi, orang tua/wali diharapkan melakukan daftar ulang dengan membawa dokumen asli untuk verifikasi.
        </div>

        <div class="paragraph">
            4. <strong>Masa Orientasi Siswa (MOS):</strong> Siswa baru diharapkan mengikuti MOS yang akan dilaksanakan pada tanggal yang akan diinformasikan kemudian.
        </div>

        <div class="paragraph">
            <strong>Informasi untuk Siswa CADANGAN:</strong>
        </div>

        <div class="paragraph">
            Siswa yang masuk dalam daftar cadangan akan dipanggil secara berurutan jika ada kuota kosong. Informasi lebih lanjut akan disampaikan melalui telepon atau email.
        </div>

        <div class="paragraph">
            <strong>Catatan Penting:</strong>
        </div>

        <div class="paragraph">
            • Pengumuman ini bersifat final dan tidak dapat diganggu gugat.<br>
            • Jika tidak melakukan konfirmasi dalam waktu yang ditentukan, maka penerimaan dianggap batal.<br>
            • Semua dokumen asli harus dibawa saat daftar ulang untuk verifikasi.<br>
            • Informasi lebih lanjut akan disampaikan melalui telepon atau email.
        </div>

        <div class="paragraph">
            Demikian pengumuman ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
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
        <p>Pengumuman ini dicetak pada {{ now()->format('d F Y, H:i') }}</p>
        <p>Untuk informasi lebih lanjut, hubungi: (021) 1234-5678 atau email: ppdb@smpn01namrole.sch.id</p>
        <p><strong>Selamat kepada siswa yang diterima!</strong></p>
    </div>
</body>
</html>

