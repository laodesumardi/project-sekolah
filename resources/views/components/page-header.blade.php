<div class="relative overflow-hidden page-header-background py-16" 
     style="background-image: url('{{ $homepageSetting && $homepageSetting->about_page_background_image ? $homepageSetting->about_page_background_image_url : asset('images/placeholders/placeholder-about-background.jpg') }}');">
    <!-- Background dengan gambar dari admin panel dan overlay gelap -->
    <div class="absolute inset-0 page-header-overlay"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">{{ $title }}</h1>
        @if($subtitle)
            <p class="text-xl text-primary-100">{{ $subtitle }}</p>
        @endif
    </div>
</div>