@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Galeri Wisata Mojokerto</h1>
        <p class="text-xl text-gray-600">Kumpulan foto-foto indah destinasi wisata, budaya, dan kuliner khas Mojokerto</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <x-card 
            image="/images/gallery/onde_onde.jpg"
            title="Onde-Onde Khas Mojokerto"
        />

        <x-card 
            image="/images/gallery/budha.jpg"
            title="Patung Buddha Tidur"
        />
        
        <x-card 
            image="/images/gallery/wringin.jpg"
            title="Candi Wringin Lawang"
        />
        
        <x-card 
            image="/images/gallery/candi-bajang.webp"
            title="Candi Bajang Ratu"
        />
        
        <x-card 
            image="/images/gallery/museum.webp"
            title="Museum Majapahit"
        />

        <x-card 
            image="/images/gallery/Pacet.jpg"
            title="Pemandangan Alam Pacet"
        />

        <x-card 
            image="/images/gallery/dlundung.webp"
            title="Air Terjun Dlundung"
        />

        <x-card 
            image="/images/gallery/masjid.jpg"
            title="Masjid Agung Al-Fattah"
        />
        
        <x-card 
            image="/images/gallery/alun.jpeg"
            title="Alun-Alun Kota Mojokerto"
        />
        
        <x-card 
            image="/images/gallery/tikus.jpeg"
            title="Situs Candi Tikus"
            
        />

        <x-card 
            image="/images/gallery/wader.jpg"
            title="Sajian Sambal Wader"
        />
        
        <x-card 
            image="/images/gallery/ranu.webp"
            title="Pemandangan Ranu Manduro"
        />
        
    </div>
</div>
@endsection