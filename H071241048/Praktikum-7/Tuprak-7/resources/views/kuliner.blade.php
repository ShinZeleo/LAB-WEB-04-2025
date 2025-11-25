@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Kuliner Khas Mojokerto</h1>
        <p class="text-xl text-gray-600">Nikmati kelezatan makanan tradisional yang menjadi ciri khas Kota Mojokerto dan sekitarnya</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <x-card 
            image="/images/kuliner/onde-onde.jpg"
            title="Onde-Onde"
            description="Ikon utama kuliner Mojokerto. Bola-bola kenyal dari tepung ketan bertabur wijen, dengan isian kacang hijau yang legit. Merupakan oleh-oleh wajib."
        />

        <x-card 
            image="/images/kuliner/sambal_wader.png"
            title="Sambal Wader"
            description="Sajian khas berupa ikan wader (ikan air tawar kecil) yang digoreng garing sempurna, disajikan dengan sambal terasi pedas dan lalapan segar."
        />

        <x-card 
            image="/images/kuliner/sate_keong.webp"
            title="Sate Keong"
            description="Kuliner unik yang banyak ditemukan di area Trowulan. Daging keong sawah yang dimasak bumbu, ditusuk, lalu disajikan dengan bumbu pedas manis."
        />

        <x-card 
            image="/images/kuliner/bubur_sruntul.jpeg"
            title="Bubur Sruntul"
            description="Jajanan pasar tradisional yang legendaris. Terdiri dari bubur sumsum, bola-bola ketan (sruntul), dan disiram kuah gula merah serta santan."
        />

        <x-card 
            image="/images/kuliner/keciput.webp"
            title="Keciput Wijen"
            description="Kue kering renyah berbentuk bola-bola kecil yang dibalut biji wijen. Populer sebagai oleh-oleh, camilan ini memiliki cita rasa manis gurih yang khas."
        />

        <x-card 
            image="/images/kuliner/rambak.jpg"
            title="Kerupuk Rambak"
            description="Oleh-oleh populer, terutama dari daerah Bangsal. Kerupuk ini terbuat dari kulit sapi atau kerbau asli, terkenal dengan teksturnya yang super renyah dan gurih saat digoreng."
        />

    </div>
</div>
@endsection