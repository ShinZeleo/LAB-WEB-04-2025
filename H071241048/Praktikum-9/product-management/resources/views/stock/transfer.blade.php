@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white rounded-top-3 py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-exchange-alt me-2"></i>Transfer Stok
                    </h3>
                </div>

                <div class="card-body p-5">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('stock.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="warehouse_id" class="form-label fw-bold">Gudang <span class="text-danger">*</span></label>
                                    <select name="warehouse_id" id="warehouse_id" class="form-select form-select-lg @error('warehouse_id') is-invalid @enderror" required>
                                        <option value="">Pilih Gudang</option>
                                        @foreach($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="product_id" class="form-label fw-bold">Produk <span class="text-danger">*</span></label>
                                    <select name="product_id" id="product_id" class="form-select form-select-lg @error('product_id') is-invalid @enderror" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="quantity_delta" class="form-label fw-bold">Jumlah Perubahan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-calculator"></i>
                                </span>
                                <input type="number" name="quantity_delta" id="quantity_delta" class="form-control form-control-lg @error('quantity_delta') is-invalid @enderror"
                                       value="{{ old('quantity_delta') }}" required>
                            </div>
                            <div class="form-text">
                                Gunakan angka positif untuk menambah stok, angka negatif untuk mengurangi stok
                            </div>
                            @error('quantity_delta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-3 justify-content-end pt-4 border-top">
                            <a href="{{ route('stock.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-exchange-alt me-2"></i>Transfer Stok
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection