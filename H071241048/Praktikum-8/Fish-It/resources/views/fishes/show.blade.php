@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <div>
                        <h4 class="mb-0">
                            <i class="bi bi-fish"></i> {{ $fish->name }}
                            <span class="ms-2">
                                <i class="bi bi-star-fill text-warning"></i> {{ $fish->rarity }}
                            </span>
                        </h4>
                    </div>
                    <div>
                        <a href="{{ route('fishes.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="me-3 text-primary">
                                    <i class="bi bi-weight-hanging fs-4"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold text-muted">Weight Range</label>
                                    <p class="mb-0 fs-5">{{ $fish->formatted_weight }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="me-3 text-success">
                                    <i class="bi bi-currency-coin fs-4"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold text-muted">Sell Price per kg</label>
                                    <p class="mb-0 fs-5">{{ $fish->formatted_sell_price }} coins</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="me-3 text-info">
                                    <i class="bi bi-cash-stack fs-4"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold text-muted">Max Value (at max weight)</label>
                                    <p class="mb-0 fs-5">{{ number_format($fish->max_value) }} coins</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="me-3 text-secondary">
                                    <i class="bi bi-dice-5 fs-4"></i>
                                </div>
                                <div>
                                    <label class="form-label fw-bold text-muted">Catch Probability</label>
                                    <p class="mb-0 fs-5">{{ $fish->formattedCatchProbability }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-start">
                            <div class="me-3 text-muted">
                                <i class="bi bi-card-text fs-4"></i>
                            </div>
                            <div>
                                <label class="form-label fw-bold text-muted">Description</label>
                                @if($fish->description)
                                    <p class="mb-0">{{ $fish->description }}</p>
                                @else
                                    <p class="text-muted mb-0 fst-italic">No description provided.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center text-muted">
                                <i class="bi bi-calendar-plus me-2"></i>
                                <span>Created: {{ $fish->created_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center text-muted">
                                <i class="bi bi-calendar-check me-2"></i>
                                <span>Updated: {{ $fish->updated_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Description</label>
                        @if($fish->description)
                            <p class="mb-0">{{ $fish->description }}</p>
                        @else
                            <p class="text-muted mb-0">No description provided.</p>
                        @endif
                    </div>
                    

                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('fishes.edit', $fish) }}" class="btn btn-warning me-md-2">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('fishes.index') }}" class="btn btn-outline-secondary me-md-2">
                            <i class="bi bi-list-ul"></i> All Fishes
                        </a>
                        <a href="#" class="btn btn-danger" 
                           onclick="event.preventDefault(); 
                                    if(confirm('Are you sure you want to delete this fish: {{ $fish->name }}?')) {
                                        document.getElementById('delete-form').submit();
                                    }">
                            <i class="bi bi-trash"></i> Delete
                        </a>
                        
                        <!-- Hidden form for delete action -->
                        <form id="delete-form" 
                              action="{{ route('fishes.destroy', $fish) }}" 
                              method="POST" 
                              class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection