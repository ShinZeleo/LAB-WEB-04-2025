@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Daftar Produk</h2>
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah Produk
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('products.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-lg" placeholder="Cari produk..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Products Grid -->
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 product-card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0 fw-bold">{{ $product->name }}</h5>
                        <span class="badge bg-primary bg-opacity-10 text-primary">
                            {{ $product->category ? $product->category->name : 'N/A' }}
                        </span>
                    </div>
                    
                    <p class="card-text text-muted mb-2">
                        <small>{{ Str::limit($product->productDetail->description ?? 'Tidak ada deskripsi', 60) }}</small>
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h5 text-success fw-bold">Rp {{ number_format($product->price, 2, ',', '.') }}</span>
                        @if($product->productDetail)
                            <small class="text-muted">
                                <i class="fas fa-weight-hanging me-1"></i>{{ $product->productDetail->weight }} kg
                            </small>
                        @endif
                    </div>

                    @if($product->productDetail && $product->productDetail->size)
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-ruler-combined me-1"></i>Ukuran: {{ $product->productDetail->size }}
                            </small>
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-eye me-1"></i>Lihat
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-warning btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100" 
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-box-open fa-5x text-muted"></i>
                </div>
                <h4 class="text-muted">Tidak Ada Produk</h4>
                <p class="text-muted">Belum ada produk yang terdaftar. Silakan tambah produk baru.</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
                    Tambah Produk Pertama
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
    </div>
    @endif
</div>

<style>
    .product-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .product-card .card-body {
        transition: all 0.3s ease;
    }
    
    .product-card:hover .card-body {
        background: linear-gradient(to bottom, #ffffff, #f8f9ff);
    }
</style>
@endsection