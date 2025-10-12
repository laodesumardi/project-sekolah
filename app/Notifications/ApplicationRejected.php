<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationRejected extends Notification implements ShouldQueue
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
        $mailMessage = (new MailMessage)
            ->subject('Hasil Seleksi PPDB - ' . $this->registration->registration_number)
            ->greeting('Kepada Yth. Orang Tua/Wali')
            ->line('Berdasarkan hasil seleksi Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran ' . $this->registration->academicYear->year . ', kami menginformasikan bahwa:')
            ->line('')
            ->line('**Nomor Pendaftaran:** ' . $this->registration->registration_number)
            ->line('**Nama:** ' . $this->registration->full_name)
            ->line('**Jalur Pendaftaran:** ' . $this->registration->path_label)
            ->line('**Status:** Tidak Diterima')
            ->line('**Tanggal Pengumuman:** ' . now()->format('d F Y, H:i'));

        if ($this->registration->admin_notes) {
            $mailMessage->line('')
                ->line('**Alasan:**')
                ->line($this->registration->admin_notes);
        }

        $mailMessage->line('')
            ->line('**Kami mengucapkan terima kasih atas partisipasi Anda dalam PPDB SMP Negeri 01 Namrole.**')
            ->line('')
            ->line('**Alternatif yang Dapat Dipertimbangkan:**')
            ->line('• Mendaftar di sekolah lain yang sesuai')
            ->line('• Mengikuti PPDB gelombang berikutnya (jika ada)')
            ->line('• Konsultasi dengan pihak sekolah untuk informasi lebih lanjut')
            ->line('')
            ->line('**Informasi Tambahan:**')
            ->line('• Hasil seleksi ini bersifat final')
            ->line('• Jika ada pertanyaan, dapat menghubungi panitia PPDB')
            ->line('• Kami berharap Anda dapat menemukan sekolah yang tepat')
            ->line('')
            ->action('Cek Status Pendaftaran', route('ppdb.status'))
            ->line('')
            ->line('Terima kasih atas kepercayaan Anda kepada SMP Negeri 01 Namrole.')
            ->salutation('Hormat kami, Panitia PPDB SMP Negeri 01 Namrole');

        return $mailMessage;
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
            'status' => 'rejected',
            'message' => 'Pendaftaran PPDB tidak diterima',
            'admin_notes' => $this->registration->admin_notes,
        ];
    }
}

