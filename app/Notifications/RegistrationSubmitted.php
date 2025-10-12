<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationSubmitted extends Notification implements ShouldQueue
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
            ->subject('Konfirmasi Pendaftaran PPDB - ' . $this->registration->registration_number)
            ->greeting('Selamat!')
            ->line('Pendaftaran PPDB Anda telah berhasil dikirim.')
            ->line('**Nomor Pendaftaran:** ' . $this->registration->registration_number)
            ->line('**Nama:** ' . $this->registration->full_name)
            ->line('**Jalur Pendaftaran:** ' . $this->registration->path_label)
            ->line('**Tanggal Pendaftaran:** ' . $this->registration->created_at->format('d F Y, H:i'))
            ->line('**Status:** Menunggu Verifikasi')
            ->line('')
            ->line('**Langkah Selanjutnya:**')
            ->line('1. Simpan nomor pendaftaran untuk tracking status')
            ->line('2. Tunggu proses verifikasi dokumen (1-3 hari kerja)')
            ->line('3. Periksa email secara berkala untuk notifikasi')
            ->line('4. Gunakan fitur "Cek Status" untuk memantau perkembangan')
            ->line('')
            ->line('**Informasi Penting:**')
            ->line('• Pastikan semua dokumen yang diupload sudah benar')
            ->line('• Hubungi admin jika ada kendala teknis')
            ->line('• Pengumuman hasil akan disampaikan sesuai jadwal')
            ->line('')
            ->action('Cek Status Pendaftaran', route('ppdb.status'))
            ->line('Terima kasih telah mendaftar di SMP Negeri 01 Namrole!')
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
            'status' => $this->registration->status,
            'message' => 'Pendaftaran PPDB berhasil dikirim',
        ];
    }
}

