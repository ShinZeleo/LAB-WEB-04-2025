@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Destinasi Wisata Mojokerto</h1>
        <p class="text-xl text-gray-600">Temukan tempat-tempat menakjubkan yang wajib dikunjungi di Mojokerto dan sekitarnya</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        
        <x-card 
            image="/images/destinasi/museum_majapahit.jpg"
            title="Museum Majapahit"
            description="Berlokasi di Trowulan, museum ini menyimpan ribuan artefak dan peninggalan Kerajaan Majapahit. Tempat terbaik untuk belajar sejarah."
        />

        <x-card 
            image="/images/destinasi/maha_vihara.jpg"
            title="Maha Vihara Mojopahit"
            description="Vihara besar yang sangat terkenal dengan Patung Buddha Tidur raksasa berwarna emas, salah satu yang terbesar di Indonesia."
        />

        <x-card 
            image="/images/destinasi/candi_bajang_ratu.jpg"
            title="Candi Bajang Ratu"
            description="Gapura (gerbang) peninggalan Majapahit yang sangat megah dan indah. Diyakini sebagai pintu masuk ke sebuah bangunan suci."
        />

        <x-card 
            image="/images/destinasi/candi_tikus.jpg"
            title="Candi Tikus"
            description="Situs petirtaan (pemandian) kuno yang unik dari era Majapahit, dengan arsitektur yang presisi dan penuh detail."
        />
        
        <x-card 
            image="/images/destinasi/candi_wringin.jpg"
            title="Candi Wringin Lawang"
            description="Gapura agung peninggalan Majapahit yang diyakini sebagai gerbang masuk ke salah satu kompleks penting kerajaan. Sangat fotogenik."
        />

        <x-card 
            image="/images/destinasi/padusan.jpg"
            title="Air Panas Padusan"
            description="Berlokasi di Pacet, destinasi ini menawarkan kolam air panas alami dari gunung. Sangat populer untuk relaksasi."
        />

        <x-card 
            image="/images/destinasi/dlundung.jpg"
            title="Air Terjun Dlundung"
            description="Wisata air terjun populer di Trawas dengan suasana sejuk dan asri. Sangat cocok untuk rekreasi keluarga dan berkemah."
        />

        <x-card 
            image="/images/destinasi/Candi_jolotundo.jpg"
            title="Candi Jolotundo"
            description="Situs petirtaan di lereng Gunung Penanggungan. Dikenal memiliki sumber air yang sangat jernih dan dipercaya berkhasiat."
        />

        <x-card 
            image="/images/destinasi/alun-alun.webp"
            title="Alun-Alun Mojokerto"
            description="Jantung Kota Mojokerto. Ruang terbuka publik yang ramai, pusat aktivitas warga, dan memiliki tugu ikonik."
        />

        <x-card 
            image="/images/destinasi/Ranu_Manduro.jpg"
            title="Ranu Manduro"
            description="Area padang rumput luas bekas tambang yang viral. Menawarkan pemandangan ala 'New Zealand' dengan latar Gunung Penanggungan."
        />

        <x-card 
            image="/images/destinasi/candi_brahu.jpg"
            title="Candi Brahu"
            description="Salah satu candi Buddha peninggalan Majapahit di Trowulan. Diyakini sebagai tempat pembakaran abu jenazah raja-raja Brawijaya."
        />

        <x-card 
            image="/images/destinasi/gubug_wayang.webp"
            title="Museum Gubug Wayang"
            description="Museum yang didedikasikan untuk pelestarian budaya, dikenal memiliki ribuan koleksi wayang dari Nusantara dan mancanegara, serta artefak seperti boneka Si Unyil, topeng, dan gamelan."
        />
        
    </div>
</div>
@endsection