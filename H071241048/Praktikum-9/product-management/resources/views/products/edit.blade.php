@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white rounded-top-3 py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-edit me-2"></i>Edit Produk
                    </h3>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                           value="{{ old('name', $product->name) }}" placeholder="Masukkan nama produk" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Nama produk harus unik dan deskriptif</div>
                                </div>

                                <div class="mb-4">
                                    <label for="price" class="form-label fw-bold">Harga <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" step="0.01" name="price" id="price" class="form-control form-control-lg @error('price') is-invalid @enderror"
                                               value="{{ old('price', $product->price) }}" placeholder="0.00" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="category_id" class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-select form-select-lg @error('category_id') is-invalid @enderror">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="description" class="form-label fw-bold">Deskripsi Produk</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                              rows="4" placeholder="Deskripsikan produk secara lengkap...">{{ old('description', $product->productDetail->description ?? '') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Deskripsi produk akan membantu pelanggan memahami produk Anda</div>
                                </div>

                                <div class="mb-4">
                                    <label for="weight" class="form-label fw-bold">Berat (kg) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="weight" id="weight" class="form-control @error('weight') is-invalid @enderror"
                                           value="{{ old('weight', $product->productDetail->weight ?? '') }}" placeholder="0.00" required>
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="size" class="form-label fw-bold">Ukuran</label>
                                    <input type="text" name="size" id="size" class="form-control @error('size') is-invalid @enderror"
                                           value="{{ old('size', $product->productDetail->size ?? '') }}" placeholder="Contoh: 10x15x20 cm">
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 justify-content-end pt-4 border-top">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i>Perbarui Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection