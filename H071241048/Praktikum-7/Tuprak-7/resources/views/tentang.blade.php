@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang Kota Mojokerto</h1>
        <p class="text-xl text-gray-600">Kota Onde-Onde dan Jejak Sejarah Majapahit</p>
    </div>

    <div class="max-w-5xl mx-auto">
        <!-- Onde-Onde Section -->
        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-2xl shadow-lg p-8 mb-8 border-l-4 border-yellow-500">
            <div class="flex items-center mb-4">
                <div class="text-yellow-600 text-4xl mr-3">
                    <i class="fas fa-cookie-bite"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Julukan "Kota Onde-Onde"</h2>
            </div>
            <p class="text-lg text-gray-700 leading-relaxed">Mojokerto sangat identik dengan julukan "Kota Onde-Onde". Kudapan manis berbentuk bulat dengan taburan biji wijen ini merupakan oleh-oleh khas yang wajib dicari saat berkunjung. Onde-onde legendaris Mojokerto (seperti Onde-Onde Bo Liem) memiliki tekstur yang kenyal dengan isian <span class="font-bold text-yellow-600"><strong>kacang hijau</strong></span> yang legit. Selain menjadi ikon kuliner yang populer, onde-onde juga melambangkan kehidupan masyarakat Mojokerto yang sederhana namun kaya cita rasa. Hampir di setiap sudut kota, pengunjung dapat menemukan produsen onde-onde rumahan hingga toko oleh-oleh modern yang terus melestarikan resep turun-temurun ini.</p>
        </div>
        
        <!-- History Section -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-lg p-8 mb-8 border-l-4 border-blue-500">
            <div class="flex items-center mb-4">
                <div class="text-blue-600 text-4xl mr-3">
                    <i class="fas fa-landmark"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Pusat Sejarah Majapahit</h2>
            </div>
            <p class="text-lg text-gray-700 leading-relaxed">Meskipun sebagian besar situs utamanya berada di wilayah kabupaten, Kota Mojokerto adalah gerbang utama menuju jejak sejarah Kerajaan Majapahit. Kawasan <span class="font-bold text-blue-600"><strong>Trowulan</strong></span>, yang diyakini sebagai ibu kota kerajaan, menyimpan banyak peninggalan bersejarah. Situs arkeologi seperti <span class="font-bold text-blue-600"><strong>Gapura Bajang Ratu</strong></span>, <span class="font-bold text-blue-600"><strong>Candi Tikus</strong></span>, dan <span class="font-bold text-blue-600"><strong>Museum Majapahit</strong></span> menjadi bukti kejayaan Majapahit sebagai kerajaan maritim besar di Nusantara. Tidak hanya itu, berbagai artefak, relief, hingga struktur kuno masih terus diteliti sampai hari ini, menjadikan Mojokerto sebagai salah satu pusat pembelajaran sejarah penting di Indonesia.</p>
        </div>
        
        <!-- Geography Section -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl shadow-lg p-8 mb-8 border-l-4 border-purple-500">
            <div class="flex items-center mb-4">
                <div class="text-purple-600 text-4xl mr-3">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Geografi dan Administrasi</h2>
            </div>
            <p class="text-lg text-gray-700 leading-relaxed">Kota Mojokerto merupakan salah satu kota terkecil di Indonesia dengan luas wilayah hanya sekitar <span class="font-bold text-purple-600"><strong>20,21 km²</strong></span>. Secara geografis, Kota Mojokerto adalah sebuah <span class="font-bold text-purple-600"><strong>enklave</strong></span>, yang berarti seluruh wilayahnya dikelilingi oleh Kabupaten Mojokerto. Secara administratif, kota ini terbagi menjadi 3 kecamatan: <span class="font-semibold text-purple-600">Prajurit Kulon</span>, <span class="font-semibold text-purple-600">Magersari</span>, dan <span class="font-semibold text-purple-600">Kranggan</span>.</p>
        </div>
        
        <!-- Economy Section -->
        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-2xl shadow-lg p-8 mb-8 border-l-4 border-indigo-500">
            <div class="flex items-center mb-4">
                <div class="text-indigo-600 text-4xl mr-3">
                    <i class="fas fa-industry"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Perekonomian</h2>
            </div>
            <p class="text-lg text-gray-700 leading-relaxed">Sebagai pusat pemerintahan dan aktivitas perkotaan, perekonomian Kota Mojokerto ditopang oleh sektor <span class="font-bold text-indigo-600"><strong>perdagangan dan jasa</strong></span>. Selain itu, sektor industri pengolahan juga memberikan kontribusi yang signifikan. Posisinya yang strategis di dekat Surabaya menjadikannya area komersial yang penting bagi wilayah sekitarnya.</p>
        </div>
        
        <!-- Tourism Section -->
        <div class="bg-gradient-to-r from-teal-50 to-cyan-50 rounded-2xl shadow-lg p-8 border-l-4 border-teal-500">
            <div class="flex items-center mb-4">
                <div class="text-teal-600 text-4xl mr-3">
                    <i class="fas fa-mountain"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Potensi Wisata</h2>
            </div>
            <p class="text-lg text-gray-700 leading-relaxed">Selain wisata sejarah Majapahit di Trowulan, Kota Mojokerto menjadi titik awal yang ideal untuk menjelajahi berbagai destinasi di sekitarnya. Di dalam kota, wisatawan dapat menikmati wisata kuliner malam, mencicipi jajanan khas, atau sekadar bersantai di area <span class="font-bold text-teal-600"><strong>Alun-Alun Kota</strong></span>. Di wilayah kabupaten sekitarnya, terdapat wisata alam populer seperti kawasan <span class="font-bold text-teal-600"><strong>Pacet dan Trawas</strong></span> yang menawarkan udara sejuk, pemandian air panas, penginapan bernuansa alam, dan air terjun. Ada pula wisata religi seperti <span class="font-bold text-teal-600"><strong>Patung Buddha Tidur</strong></span> di Maha Vihara Mojopahit yang menjadi salah satu ikon kebanggaan Mojokerto.</p>
        </div>
    </div>
</div>
@endsection