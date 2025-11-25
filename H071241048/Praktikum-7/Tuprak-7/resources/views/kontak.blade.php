@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Hubungi Kami</h1>
        <p class="text-xl text-gray-600">Silakan hubungi kami untuk informasi lebih lanjut tentang destinasi wisata di Mojokerto</p>
    </div>

    <div class="max-w-2xl mx-auto mb-16">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 text-white p-6">
                <h4 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-envelope mr-3"></i> Formulir Kontak
                </h4>
            </div>
            <div class="p-8">
                <form>
                    <div class="mb-6">
                        <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="nama" placeholder="Masukkan nama Anda">
                    </div>
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Alamat Email</label>
                        <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="email" placeholder="Masukkan email Anda">
                    </div>
                    <div class="mb-6">
                        <label for="telepon" class="block text-gray-700 font-medium mb-2">Nomor Telepon</label>
                        <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="telepon" placeholder="Masukkan nomor telepon Anda">
                    </div>
                    <div class="mb-6">
                        <label for="subjek" class="block text-gray-700 font-medium mb-2">Subjek Pesan</label>
                        <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="subjek" placeholder="Masukkan subjek pesan">
                    </div>
                    <div class="mb-6">
                        <label for="pesan" class="block text-gray-700 font-medium mb-2">Pesan</label>
                        <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" id="pesan" rows="5" placeholder="Tulis pesan Anda di sini..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold py-3 px-4 rounded-lg hover:from-blue-700 hover:to-indigo-800 transition duration-300">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <div class="text-blue-600 text-5xl mb-4 mx-auto w-16">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <h5 class="text-xl font-bold mb-4">Alamat Kantor</h5>
            <p class="text-gray-600">Jl. Gajah Mada No. 100, Mojokerto 61316, Indonesia</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <div class="text-green-600 text-5xl mb-4 mx-auto w-16">
                <i class="fas fa-phone"></i>
            </div>
            <h5 class="text-xl font-bold mb-4">Kontak Telepon</h5>
            <p class="text-gray-600">(0321) 123456<br>+62 812-3456-7890</p>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <div class="text-indigo-600 text-5xl mb-4 mx-auto w-16">
                <i class="fas fa-envelope"></i>
            </div>
            <h5 class="text-xl font-bold mb-4">Alamat Email</h5>
            <p class="text-gray-600">info@mojokertotourism.com<br>contact@wisatamojokerto.id</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gray-100 p-4 border-b">
            <h5 class="text-xl font-bold flex items-center">
                <i class="fas fa-map-marked-alt mr-3 text-blue-600"></i> Lokasi Kantor Kami
            </h5>
        </div>
        <div class="p-4">
            <div class="w-full aspect-video md:aspect-[3/1] rounded-xl overflow-hidden shadow-xl">
                <iframe
                class="w-full h-full"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31644.075114402613!2d112.41703631976378!3d-7.46497334015697!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e780c1033217e65%3A0x7c737397751b3fde!2sKota%20Mojokerto%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1729863415849!5m2!1sid!2sid"
                style="border:0;"
                allowfullscreen
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection