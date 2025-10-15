@props(['section' => 'hero', 'title' => '', 'subtitle' => '', 'content' => ''])

@php
    $homepageSetting = \App\Models\HomepageSetting::getActive();
    $backgroundImage = '';
    
    // Get background image based on section
    switch($section) {
        case 'hero':
            $backgroundImage = $homepageSetting && $homepageSetting->hero_background_image ? $homepageSetting->hero_background_image_url : asset('images/placeholders/placeholder-hero-background.jpg');
            break;
        case 'about':
            $backgroundImage = $homepageSetting && $homepageSetting->about_page_background_image ? $homepageSetting->about_page_background_image_url : asset('images/placeholders/placeholder-about-background.jpg');
            break;
        case 'curriculum':
            $backgroundImage = $homepageSetting && $homepageSetting->curriculum_page_background_image ? $homepageSetting->curriculum_page_background_image_url : asset('images/placeholders/placeholder-curriculum-background.jpg');
            break;
        case 'extracurricular':
            $backgroundImage = $homepageSetting && $homepageSetting->extracurricular_page_background_image ? $homepageSetting->extracurricular_page_background_image_url : asset('images/placeholders/placeholder-extracurricular-background.jpg');
            break;
        case 'gallery':
            $backgroundImage = $homepageSetting && $homepageSetting->gallery_page_background_image ? $homepageSetting->gallery_page_background_image_url : asset('images/placeholders/placeholder-gallery-background.jpg');
            break;
        case 'news':
            $backgroundImage = $homepageSetting && $homepageSetting->news_page_background_image ? $homepageSetting->news_page_background_image_url : asset('images/placeholders/placeholder-news-background.jpg');
            break;
        case 'ppdb':
            $backgroundImage = $homepageSetting && $homepageSetting->ppdb_page_background_image ? $homepageSetting->ppdb_page_background_image_url : asset('images/placeholders/placeholder-ppdb-background.jpg');
            break;
        default:
            $backgroundImage = $homepageSetting && $homepageSetting->hero_background_image ? $homepageSetting->hero_background_image_url : asset('images/placeholders/placeholder-hero-background.jpg');
            break;
    }
@endphp

<section class="relative overflow-hidden background-section" 
         style="background-image: url('{{ $backgroundImage }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">
    <!-- Background dengan gambar dari admin panel dan overlay gelap -->
    <div class="absolute inset-0 background-section-overlay"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'2\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 {{ $section === 'news' ? 'py-20 lg:py-24' : 'py-16' }} text-center">
        <div class="text-white">
            @if($title)
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    {{ $title }}
                </h1>
            @endif
            
            @if($subtitle)
                <p class="text-xl text-primary-100">
                    {{ $subtitle }}
                </p>
            @endif
            
            @if($content)
                <div class="max-w-4xl mx-auto">
                    {!! $content !!}
                </div>
            @endif
            
            @if($slot->isNotEmpty())
                <div class="max-w-4xl mx-auto">
                    {{ $slot }}
                </div>
            @endif
        </div>
    </div>
</section>
