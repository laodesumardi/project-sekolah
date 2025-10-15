@props(['section' => 'default'])

@php
    $homepageSetting = \App\Models\HomepageSetting::getActive();
    $images = [];
    
    // Define images for different sections
    switch($section) {
        case 'hero':
            $images[] = [
                'url' => $homepageSetting && $homepageSetting->hero_background_image ? $homepageSetting->hero_background_image_url : asset('images/placeholders/placeholder-hero-background.jpg'),
                'alt' => 'Background Hero',
                'title' => 'Background Hero Section'
            ];
            break;
            
        case 'about':
            $images[] = [
                'url' => $homepageSetting && $homepageSetting->about_page_background_image ? $homepageSetting->about_page_background_image_url : asset('images/placeholders/placeholder-about-background.jpg'),
                'alt' => 'Background Tentang Kami',
                'title' => 'Background Tentang Kami'
            ];
            break;
            
        case 'school':
            $images[] = [
                'url' => $homepageSetting && $homepageSetting->school_image ? $homepageSetting->school_image_url : asset('images/placeholder-school.jpg'),
                'alt' => 'Gambar Sekolah',
                'title' => 'Gambar Sekolah'
            ];
            break;
            
        case 'principal':
            $images[] = [
                'url' => $homepageSetting && $homepageSetting->principal_photo ? $homepageSetting->principal_photo_url : asset('images/placeholder-principal.jpg'),
                'alt' => 'Foto Kepala Sekolah',
                'title' => 'Foto Kepala Sekolah'
            ];
            break;
            
        case 'accreditation':
            $images[] = [
                'url' => $homepageSetting && $homepageSetting->accreditation_certificate ? $homepageSetting->accreditation_certificate_url : asset('images/placeholder-certificate.jpg'),
                'alt' => 'Sertifikat Akreditasi',
                'title' => 'Sertifikat Akreditasi'
            ];
            break;
            
        case 'organization':
            $images[] = [
                'url' => $homepageSetting && $homepageSetting->organization_structure_image ? $homepageSetting->organization_structure_image_url : asset('images/placeholder-organization-chart.jpg'),
                'alt' => 'Struktur Organisasi',
                'title' => 'Struktur Organisasi'
            ];
            break;
            
        case 'library':
            $images[] = [
                'url' => $homepageSetting && $homepageSetting->library_structure_image ? $homepageSetting->library_structure_image_url : asset('images/STRUKTUR ORGANISASI PERPUSTAKAAN.png'),
                'alt' => 'Struktur Perpustakaan',
                'title' => 'Struktur Perpustakaan'
            ];
            break;
            
        case 'all':
        default:
            // Show all available images
            if($homepageSetting) {
                if($homepageSetting->hero_background_image) {
                    $images[] = [
                        'url' => $homepageSetting->hero_background_image_url,
                        'alt' => 'Background Hero',
                        'title' => 'Background Hero Section'
                    ];
                }
                if($homepageSetting->about_page_background_image) {
                    $images[] = [
                        'url' => $homepageSetting->about_page_background_image_url,
                        'alt' => 'Background Tentang Kami',
                        'title' => 'Background Tentang Kami'
                    ];
                }
                if($homepageSetting->school_image) {
                    $images[] = [
                        'url' => $homepageSetting->school_image_url,
                        'alt' => 'Gambar Sekolah',
                        'title' => 'Gambar Sekolah'
                    ];
                }
                if($homepageSetting->principal_photo) {
                    $images[] = [
                        'url' => $homepageSetting->principal_photo_url,
                        'alt' => 'Foto Kepala Sekolah',
                        'title' => 'Foto Kepala Sekolah'
                    ];
                }
                if($homepageSetting->accreditation_certificate) {
                    $images[] = [
                        'url' => $homepageSetting->accreditation_certificate_url,
                        'alt' => 'Sertifikat Akreditasi',
                        'title' => 'Sertifikat Akreditasi'
                    ];
                }
                if($homepageSetting->organization_structure_image) {
                    $images[] = [
                        'url' => $homepageSetting->organization_structure_image_url,
                        'alt' => 'Struktur Organisasi',
                        'title' => 'Struktur Organisasi'
                    ];
                }
                if($homepageSetting->library_structure_image) {
                    $images[] = [
                        'url' => $homepageSetting->library_structure_image_url,
                        'alt' => 'Struktur Perpustakaan',
                        'title' => 'Struktur Perpustakaan'
                    ];
                }
            }
            break;
    }
@endphp

@if(count($images) > 0)
<div class="section-images-container">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($images as $image)
        <div class="section-image-card group">
            <div class="relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <img src="{{ $image['url'] }}" 
                     alt="{{ $image['alt'] }}" 
                     class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                
                <!-- Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                    <div class="text-center text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                        </svg>
                        <p class="text-sm font-medium">Lihat Detail</p>
                    </div>
                </div>
                
                <!-- Image Info -->
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                    <h3 class="text-white font-semibold text-sm">{{ $image['title'] }}</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<div class="text-center py-12">
    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
    </div>
    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Gambar</h3>
    <p class="text-gray-600">Gambar section akan ditampilkan di sini setelah diupload dari admin panel.</p>
    <a href="{{ route('admin.homepage-settings.edit') }}" class="inline-flex items-center mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Upload Gambar
    </a>
</div>
@endif
