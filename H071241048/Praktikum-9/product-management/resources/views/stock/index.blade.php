@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Manajemen Stok</h2>
                <a href="{{ route('stock.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-exchange-alt me-2"></i>Transfer Stok
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-6">
            <label for="warehouse_id" class="form-label fw-bold">Pilih Gudang</label>
            <select name="warehouse_id" id="warehouse_id" class="form-select form-select-lg" onchange="location = this.value;">
                <option value="{{ route('stock.index') }}" {{ !$warehouseId ? 'selected' : '' }}>Semua Gudang</option>
                @foreach($warehouses as $warehouse)
                    <option value="{{ route('stock.index', ['warehouse_id' => $warehouse->id]) }}" {{ $warehouseId == $warehouse->id ? 'selected' : '' }}>
                        {{ $warehouse->name }} - {{ $warehouse->location ?? 'Lokasi tidak tersedia' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @if($warehouseId)
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-light py-3">
                <h4 class="mb-0">
                    <i class="fas fa-warehouse me-2 text-primary"></i>Stok di {{ $warehouses->firstWhere('id', $warehouseId)->name }}
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok Tersedia</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stocks as $stock)
                            <tr>
                                <td>
                                    <h6 class="mb-0">{{ $stock->name }}</h6>
                                    <small class="text-muted">{{ Str::limit($stock->productDetail->description ?? '', 30) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        {{ $stock->category ? $stock->category->name : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success fs-5">{{ $stock->pivot->quantity }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('products.show', $stock) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-box-open fa-3x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">Tidak ada stok produk di gudang ini.</h5>
                                    <p class="text-muted">Silakan tambah produk atau transfer stok ke gudang ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-warehouse fa-5x text-muted"></i>
            </div>
            <h4 class="text-muted mb-3">Pilih Gudang untuk Melihat Stok</h4>
            <p class="text-muted mb-4">Silakan pilih gudang dari dropdown di atas untuk melihat informasi stok produk.</p>

            @if($warehouses->count() > 0)
            <div class="row justify-content-center">
                @foreach($warehouses as $warehouse)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <h6 class="card-title fw-bold">{{ $warehouse->name }}</h6>
                            <p class="card-text text-muted small mb-2">{{ $warehouse->location ?? 'Lokasi tidak tersedia' }}</p>
                            <a href="{{ route('stock.index', ['warehouse_id' => $warehouse->id]) }}" class="btn btn-primary">
                                Lihat Stok
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <hr class="my-5">
            <h4 class="mb-4">Ringkasan Stok Keseluruhan</h4>
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Total Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stocks as $stock)
                                <tr>
                                    <td>{{ $stock->name }}</td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            {{ $stock->category ? $stock->category->name : 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $totalStock = $stock->warehouses->sum('pivot.quantity');
                                        @endphp
                                        <span class="badge bg-info bg-opacity-10 text-info fs-5">{{ $totalStock }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Tidak ada produk dengan stok.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>Belum ada gudang yang terdaftar. Silakan tambah gudang terlebih dahulu.
            </div>
            @endif
        </div>
    @endif
</div>
@endsection