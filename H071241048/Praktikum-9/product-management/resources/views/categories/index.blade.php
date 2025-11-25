@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Daftar Kategori</h2>
                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah Kategori
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('categories.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-lg" placeholder="Cari kategori..." 
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

    <!-- Categories Grid -->
    <div class="row g-4">
        @forelse($categories as $category)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 category-card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="card-title mb-0 fw-bold">
                            <i class="fas fa-tags text-primary me-2"></i>{{ $category->name }}
                        </h5>
                        <span class="badge bg-secondary">
                            {{ $category->products->count() }} produk
                        </span>
                    </div>
                    
                    <p class="card-text text-muted mb-3">
                        {{ Str::limit($category->description ?? 'Tidak ada deskripsi', 80) }}
                    </p>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-eye me-1"></i>Lihat
                        </a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-warning btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua produk dalam kategori ini akan terpengaruh.')">
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
                    <i class="fas fa-tags fa-5x text-muted"></i>
                </div>
                <h4 class="text-muted">Tidak Ada Kategori</h4>
                <p class="text-muted">Belum ada kategori yang terdaftar. Silakan tambah kategori baru.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-lg">
                    Tambah Kategori Pertama
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $categories->links() }}
    </div>
    @endif
</div>

<style>
    .category-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .category-card .card-body {
        transition: all 0.3s ease;
    }
    
    .category-card:hover .card-body {
        background: linear-gradient(to bottom, #ffffff, #f8f9ff);
    }
</style>
@endsection