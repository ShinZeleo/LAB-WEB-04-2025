@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-warehouse text-primary me-2"></i>{{ $warehouse->name }}
                </h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus gudang ini? Semua stok dalam gudang ini akan terpengaruh.')">
                            <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title mb-3">Detail Gudang</h4>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1"><strong>Nama:</strong></p>
                                    <p class="text-muted">{{ $warehouse->name }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1"><strong>Lokasi:</strong></p>
                                    <p class="text-muted">{{ $warehouse->location ?: 'Tidak ada lokasi' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Statistik</h5>
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <p class="display-6 text-primary mb-1">{{ $warehouse->products->count() }}</p>
                                            <p class="text-muted small mb-0">Produk</p>
                                        </div>
                                        <div class="col-6">
                                            <p class="display-6 text-success mb-1">{{ $warehouse->products->sum('pivot.quantity') }}</p>
                                            <p class="text-muted small mb-0">Total Stok</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products in this warehouse -->
    @if($warehouse->products->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Produk dalam Gudang Ini</h4>
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
                                @foreach($warehouse->products as $product)
                                <tr>
                                    <td>
                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            {{ $product->category ? $product->category->name : 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success fs-5">{{ $product->pivot->quantity }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection