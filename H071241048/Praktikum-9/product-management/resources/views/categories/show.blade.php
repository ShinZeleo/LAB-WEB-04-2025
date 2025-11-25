@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-tag text-primary me-2"></i>{{ $category->name }}
                </h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua produk dalam kategori ini akan terpengaruh.')">
                            <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title mb-3">Deskripsi Kategori</h4>
                            <p class="card-text">
                                {{ $category->description ?: 'Tidak ada deskripsi' }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Statistik</h5>
                                    <p class="display-4 text-primary">{{ $category->products->count() }}</p>
                                    <p class="card-text">Produk dalam Kategori</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products in this category -->
    @if($category->products->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Produk dalam Kategori Ini</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($category->products as $product)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">
                                        <strong>Harga:</strong> Rp {{ number_format($product->price, 2, ',', '.') }}
                                    </p>
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">Lihat Produk</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection