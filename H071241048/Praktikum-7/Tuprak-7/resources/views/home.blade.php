@extends('layouts.master')

@section('content')
<div class="relative hero-section">
    <!-- <div class="absolute inset-0 bg-gradient-to-br from-purple-900 via-indigo-800 to-purple-900"></div> -->
    <div class="relative container mx-auto px-4 text-center py-20">
        <h1 class="text-5xl font-bold mb-4 text-white drop-shadow-2xl">Selamat Datang di Mojokerto</h1>
        <p class="text-xl mb-6 text-white max-w-2xl mx-auto drop-shadow">Jelajahi keindahan sejarah, alam, dan kuliner Kota Mojokerto</p>
        <a href="{{ url('/destinasi') }}" class="inline-block bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-bold py-4 px-10 rounded-full text-lg transition duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
            Jelajahi Destinasi
        </a>
    </div>
</div>

<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold mb-4">Mojokerto - Kota Onde-Onde, Jantung Sejarah Majapahit</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Jelajahi kota yang menyimpan jejak emas Kerajaan Majapahit dan cita rasa kuliner legendaris.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="bg-white rounded-xl shadow-lg p-8 text-center transform transition duration-500 hover:scale-105">
            <div class="text-blue-600 text-5xl mb-4">
                <i class="fas fa-landmark"></i>
            </div>
            <h3 class="text-2xl font-bold mb-4">Budaya & Sejarah</h3>
            <p class="text-gray-600">Temukan kekayaan budaya Jawa Timur dan warisan sejarah kerajaan Majapahit yang luar biasa di Mojokerto.</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-8 text-center transform transition duration-500 hover:scale-105">
            <div class="text-green-600 text-5xl mb-4">
                <i class="fas fa-utensils"></i>
            </div>
            <h3 class="text-2xl font-bold mb-4">Kuliner Khas</h3>
            <p class="text-gray-600">Rasakan kelezatan makanan khas Mojokerto, dari Onde-Onde legendaris hingga Sambal Wader yang nikmat.</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-8 text-center transform transition duration-500 hover:scale-105">
            <div class="text-indigo-600 text-5xl mb-4">
                <i class="fas fa-camera"></i>
            </div>
            <h3 class="text-2xl font-bold mb-4">Destinasi Wisata</h3>
            <p class="text-gray-600">Jelajahi situs sejarah Trowulan hingga kesejukan alam pegunungan di Pacet dan Trawas.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <h3 class="text-3xl font-bold mb-6">Kenapa Harus ke Mojokerto?</h3>
            <p class="text-gray-700 text-lg mb-4">Mojokerto adalah destinasi unik yang menyajikan paduan sempurna antara <strong>wisata sejarah Majapahit</strong>, <strong>pesona alam pegunungan</strong> (Pacet & Trawas), dan <strong>kelezatan kuliner khasnya</strong>. Kota ini adalah gerbang utama untuk napak tilas kejayaan terbesar di Nusantara.</p>
            <p class="text-gray-700 text-lg">Masyarakatnya yang ramah, situs sejarah yang megah, dan keindahan alamnya membuat Mojokerto menjadi pilihan tepat untuk liburan yang berkesan.</p>
        </div>
        <div class="bg-gray-200 rounded-xl overflow-hidden shadow-xl">
            <div class="aspect-w-16 aspect-h-9">
                <iframe 
                    class="w-full h-64 md:h-96" 
                    src="https://www.youtube.com/embed/Gek7DuN5t7U?si=mAhtFAQLkBkM1nVu"
                    title="Mojokerto Tourism Video" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection