<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $registration;

    /**
     * Create a new notification instance.
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🎉 SELAMAT! Anda Diterima di SMP Negeri 01 Namrole')
            ->greeting('Selamat!')
            ->line('Kami dengan senang hati mengumumkan bahwa pendaftaran PPDB Anda telah **DITERIMA**.')
            ->line('')
            ->line('**Detail Penerimaan:**')
            ->line('**Nomor Pendaftaran:** ' . $this->registration->registration_number)
            ->line('**Nama:** ' . $this->registration->full_name)
            ->line('**Jalur Pendaftaran:** ' . $this->registration->path_label)
            ->line('**Tanggal Pengumuman:** ' . now()->format('d F Y, H:i'))
            ->line('')
            ->line('**🎯 LANGKAH SELANJUTNYA:**')
            ->line('')
            ->line('**1. KONFIRMASI PENERIMAAN**')
            ->line('   • Segera konfirmasi penerimaan melalui telepon atau email')
            ->line('   • Batas waktu: 3 hari setelah pengumuman ini')
            ->line('   • Telepon: (021) 1234-5678')
            ->line('   • Email: ppdb@smpn01namrole.sch.id')
            ->line('')
            ->line('**2. PEMBAYARAN**')
            ->line('   • Biaya pendaftaran: Rp ' . number_format($this->registration->registrationSetting->registration_fee, 0, ',', '.'))
            ->line('   • Informasi rekening akan diberikan setelah konfirmasi')
            ->line('   • Simpan bukti pembayaran untuk daftar ulang')
            ->line('')
            ->line('**3. DAFTAR ULANG**')
            ->line('   • Bawa dokumen asli untuk verifikasi')
            ->line('   • Jadwal daftar ulang akan diinformasikan kemudian')
            ->line('   • Pastikan semua dokumen lengkap dan valid')
            ->line('')
            ->line('**4. MASA ORIENTASI SISWA (MOS)**')
            ->line('   • Ikuti MOS sesuai jadwal yang ditentukan')
            ->line('   • Informasi MOS akan disampaikan kemudian')
            ->line('')
            ->line('**⚠️ PENTING:**')
            ->line('• Jika tidak konfirmasi dalam 3 hari, penerimaan dianggap batal')
            ->line('• Semua dokumen asli harus dibawa saat daftar ulang')
            ->line('• Periksa email secara berkala untuk informasi terbaru')
            ->line('')
            ->action('Download Surat Penerimaan', route('ppdb.confirmation', $this->registration->registration_number))
            ->line('')
            ->line('**Selamat bergabung di SMP Negeri 01 Namrole!**')
            ->line('Kami berharap Anda dapat mengikuti proses selanjutnya dengan baik.')
            ->salutation('Hormat kami, Panitia PPDB SMP Negeri 01 Namrole');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'registration_number' => $this->registration->registration_number,
            'full_name' => $this->registration->full_name,
            'status' => 'accepted',
            'message' => 'Pendaftaran PPDB diterima',
        ];
    }
}

