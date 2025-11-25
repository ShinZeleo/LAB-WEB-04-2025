@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white rounded-top-3 py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Gudang Baru
                    </h3>
                </div>

                <div class="card-body p-5">
                    <form action="{{ route('warehouses.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Nama Gudang <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="Masukkan nama gudang" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Nama gudang harus unik dan deskriptif</div>
                        </div>

                        <div class="mb-4">
                            <label for="location" class="form-label fw-bold">Lokasi Gudang</label>
                            <input type="text" name="location" id="location" class="form-control form-control-lg @error('location') is-invalid @enderror"
                                   value="{{ old('location') }}" placeholder="Contoh: Jl. Makassar No. 123">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Lokasi gudang akan membantu dalam identifikasi</div>
                        </div>

                        <div class="d-flex gap-3 justify-content-end pt-4 border-top">
                            <a href="{{ route('warehouses.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-arrow-left me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i>Simpan Gudang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection