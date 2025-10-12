<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReminder extends Notification implements ShouldQueue
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
            ->subject('⏰ Peringatan: Batas Waktu Pembayaran PPDB Mendekati')
            ->greeting('Kepada Yth. Orang Tua/Wali')
            ->line('Kami mengingatkan bahwa batas waktu pembayaran biaya pendaftaran PPDB akan segera berakhir.')
            ->line('')
            ->line('**Detail Pembayaran:**')
            ->line('**Nomor Pendaftaran:** ' . $this->registration->registration_number)
            ->line('**Nama:** ' . $this->registration->full_name)
            ->line('**Biaya Pendaftaran:** Rp ' . number_format($this->registration->registrationSetting->registration_fee, 0, ',', '.'))
            ->line('**Status:** Menunggu Pembayaran')
            ->line('')
            ->line('**⚠️ PENTING:**')
            ->line('• Segera lakukan pembayaran sebelum batas waktu')
            ->line('• Jika tidak membayar dalam waktu yang ditentukan, penerimaan dianggap batal')
            ->line('• Simpan bukti pembayaran untuk verifikasi')
            ->line('')
            ->line('**Cara Pembayaran:**')
            ->line('1. Transfer ke rekening yang telah diinformasikan')
            ->line('2. Upload bukti pembayaran melalui sistem')
            ->line('3. Tunggu konfirmasi dari admin')
            ->line('4. Lakukan daftar ulang setelah pembayaran dikonfirmasi')
            ->line('')
            ->line('**Informasi Rekening:**')
            ->line('• Bank: [Nama Bank]')
            ->line('• Nomor Rekening: [Nomor Rekening]')
            ->line('• Atas Nama: SMP Negeri 01 Namrole')
            ->line('• Keterangan: PPDB - ' . $this->registration->registration_number)
            ->line('')
            ->line('**Jika Sudah Membayar:**')
            ->line('• Pastikan bukti pembayaran sudah diupload')
            ->line('• Tunggu konfirmasi dari admin (1-2 hari kerja)')
            ->line('• Periksa status pembayaran secara berkala')
            ->line('')
            ->action('Upload Bukti Pembayaran', route('ppdb.status'))
            ->line('')
            ->line('**Hubungi Kami:**')
            ->line('• Telepon: (021) 1234-5678')
            ->line('• Email: ppdb@smpn01namrole.sch.id')
            ->line('• Jam Kerja: Senin - Jumat, 08:00 - 16:00')
            ->line('')
            ->line('Terima kasih atas perhatiannya.')
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
            'amount' => $this->registration->registrationSetting->registration_fee,
            'message' => 'Peringatan batas waktu pembayaran',
        ];
    }
}

