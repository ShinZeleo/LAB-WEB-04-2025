@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Daftar Gudang</h2>
                <a href="{{ route('warehouses.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah Gudang
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="row mb-4">
        <div class="col-md-6">
            <form method="GET" action="{{ route('warehouses.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-lg" placeholder="Cari gudang..." 
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

    <!-- Warehouses Grid -->
    <div class="row g-4">
        @forelse($warehouses as $warehouse)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 warehouse-card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-0 fw-bold">
                                <i class="fas fa-warehouse text-primary me-2"></i>{{ $warehouse->name }}
                            </h5>
                            <p class="text-muted mb-0">
                                <i class="fas fa-map-marker-alt me-1"></i>{{ $warehouse->location ?: 'Lokasi tidak tersedia' }}
                            </p>
                        </div>
                        <span class="badge bg-info">
                            {{ $warehouse->products->count() }} produk
                        </span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">
                            <i class="fas fa-boxes me-1"></i>Total stok: {{ $warehouse->products->sum('pivot.quantity') }}
                        </span>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('warehouses.show', $warehouse) }}" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="fas fa-eye me-1"></i>Lihat
                        </a>
                        <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-outline-warning btn-sm flex-fill">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" class="d-inline flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus gudang ini? Semua stok dalam gudang ini akan terpengaruh.')">
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
                    <i class="fas fa-warehouse fa-5x text-muted"></i>
                </div>
                <h4 class="text-muted">Tidak Ada Gudang</h4>
                <p class="text-muted">Belum ada gudang yang terdaftar. Silakan tambah gudang baru.</p>
                <a href="{{ route('warehouses.create') }}" class="btn btn-primary btn-lg">
                    Tambah Gudang Pertama
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($warehouses->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $warehouses->links() }}
    </div>
    @endif
</div>

<style>
    .warehouse-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .warehouse-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .warehouse-card .card-body {
        transition: all 0.3s ease;
    }
    
    .warehouse-card:hover .card-body {
        background: linear-gradient(to bottom, #ffffff, #f8f9ff);
    }
</style>
@endsection