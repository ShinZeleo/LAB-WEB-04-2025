@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Edit Fish: {{ $fish->name }}
                    </h4>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('fishes.update', $fish) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Fish Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $fish->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="rarity" class="form-label">Rarity</label>
                            <select class="form-select @error('rarity') is-invalid @enderror" 
                                    id="rarity" name="rarity" required>
                                <option value="">Select Rarity</option>
                                @foreach($rarityOptions as $option)
                                    <option value="{{ $option }}" {{ old('rarity', $fish->rarity) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rarity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label for="base_weight_min" class="form-label">Base Weight Min (kg)</label>
                                <input type="number" step="0.01" class="form-control @error('base_weight_min') is-invalid @enderror" 
                                       id="base_weight_min" name="base_weight_min" 
                                       value="{{ old('base_weight_min', $fish->base_weight_min) }}" required>
                                @error('base_weight_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="base_weight_max" class="form-label">Base Weight Max (kg)</label>
                                <input type="number" step="0.01" class="form-control @error('base_weight_max') is-invalid @enderror" 
                                       id="base_weight_max" name="base_weight_max" 
                                       value="{{ old('base_weight_max', $fish->base_weight_max) }}" required>
                                @error('base_weight_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="sell_price_per_kg" class="form-label">Sell Price per kg (Coins)</label>
                            <input type="number" class="form-control @error('sell_price_per_kg') is-invalid @enderror" 
                                   id="sell_price_per_kg" name="sell_price_per_kg" 
                                   value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}" required>
                            @error('sell_price_per_kg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="catch_probability" class="form-label">Catch Probability (%)</label>
                            <input type="number" step="0.01" min="0.01" max="100.00" 
                                   class="form-control @error('catch_probability') is-invalid @enderror" 
                                   id="catch_probability" name="catch_probability" 
                                   value="{{ old('catch_probability', $fish->catch_probability) }}" required>
                            @error('catch_probability')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Value must be between 0.01 and 100.00</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $fish->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Optional description of the fish</div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('fishes.show', $fish) }}" class="btn btn-secondary me-md-2">
                                <i class="bi bi-eye"></i> View Detail
                            </a>
                            <a href="{{ route('fishes.index') }}" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Fish
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 