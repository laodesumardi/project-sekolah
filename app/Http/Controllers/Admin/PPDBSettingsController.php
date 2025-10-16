<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PPDBSettingsController extends Controller
{
    /**
     * Display PPDB settings
     */
    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.ppdb-settings.index', compact('settings'));
    }

    /**
     * Update PPDB settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'registration_period_start' => 'required|date',
            'registration_period_end' => 'required|date|after:registration_period_start',
            'quota' => 'required|integer|min:1',
            'description' => 'nullable|string|max:1000',
            'requirements' => 'nullable|string|max:2000',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'contact_whatsapp' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:500',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $settings = [
                'registration_period_start' => $request->registration_period_start,
                'registration_period_end' => $request->registration_period_end,
                'quota' => $request->quota,
                'is_open' => $request->has('is_open') ? '1' : '0',
                'description' => $request->description,
                'requirements' => $request->requirements,
                'contact_phone' => $request->contact_phone,
                'contact_email' => $request->contact_email,
                'contact_whatsapp' => $request->contact_whatsapp,
                'contact_address' => $request->contact_address,
                'hero_title' => $request->hero_title,
                'hero_subtitle' => $request->hero_subtitle,
                'hero_description' => $request->hero_description,
                'updated_at' => now(),
            ];

            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                $oldBanner = $this->getSetting('banner_image');
                if ($oldBanner && Storage::disk('public')->exists($oldBanner)) {
                    Storage::disk('public')->delete($oldBanner);
                }
                
                $bannerPath = $request->file('banner_image')->store('ppdb/banners', 'public');
                $settings['banner_image'] = $bannerPath;
            }

            // Update settings in database
            $this->updateSettings($settings);

            DB::commit();

            return redirect()->route('admin.ppdb-settings.index')
                ->with('success', 'Pengaturan PPDB berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan saat memperbarui pengaturan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Toggle PPDB registration status
     */
    public function toggleStatus(Request $request)
    {
        try {
            $isOpen = $request->boolean('is_open');
            
            $this->updateSettings(['is_open' => $isOpen ? '1' : '0']);

            $message = $isOpen ? 'Pendaftaran PPDB dibuka' : 'Pendaftaran PPDB ditutup';

            return redirect()->route('admin.ppdb-settings.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('admin.ppdb-settings.index')
                ->with('error', 'Terjadi kesalahan saat mengubah status pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Get all PPDB settings
     */
    private function getSettings()
    {
        return [
            'registration_period_start' => $this->getSetting('registration_period_start', date('Y-m-d')),
            'registration_period_end' => $this->getSetting('registration_period_end', date('Y-m-d', strtotime('+3 months'))),
            'quota' => $this->getSetting('quota', 200),
            'is_open' => $this->getSetting('is_open', '1') === '1',
            'description' => $this->getSetting('description', 'Penerimaan Peserta Didik Baru SMP Negeri 01 Namrole Tahun Ajaran 2024/2025'),
            'requirements' => $this->getSetting('requirements', '• Usia maksimal 15 tahun pada 1 Juli 2024\n• Memiliki ijazah SD/MI atau sederajat\n• Foto berwarna 3x4 (2 lembar)\n• Fotokopi akta kelahiran'),
            'contact_phone' => $this->getSetting('contact_phone', '(021) 1234-5678'),
            'contact_email' => $this->getSetting('contact_email', 'ppdb@smpn01namrole.sch.id'),
            'contact_whatsapp' => $this->getSetting('contact_whatsapp', '0812-3456-7890'),
            'contact_address' => $this->getSetting('contact_address', 'Jl. Pendidikan No. 1, Namrole'),
            'banner_image' => $this->getSetting('banner_image'),
            'hero_title' => $this->getSetting('hero_title', 'PPDB 2024'),
            'hero_subtitle' => $this->getSetting('hero_subtitle', 'Penerimaan Peserta Didik Baru'),
            'hero_description' => $this->getSetting('hero_description', 'Bergabunglah dengan keluarga besar SMP Negeri 01 Namrole'),
        ];
    }

    /**
     * Get a specific setting
     */
    private function getSetting($key, $default = null)
    {
        $setting = DB::table('ppdb_settings')->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Update settings
     */
    private function updateSettings($settings)
    {
        foreach ($settings as $key => $value) {
            DB::table('ppdb_settings')->updateOrInsert(
                ['key' => $key],
                [
                    'value' => $value,
                    'updated_at' => now(),
                    'created_at' => now()
                ]
            );
        }
    }
}