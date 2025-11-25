@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Fish Catalog</h1>
        <a href="{{ route('fishes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Fish
        </a>
    </div>
    
    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('fishes.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="rarity" class="form-label">Filter by Rarity</label>
                        <select name="rarity" id="rarity" class="form-select">
                            <option value="">All Rarities</option>
                            @foreach($rarityOptions as $option)
                                <option value="{{ $option }}" {{ $rarity == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-5">
                        <label for="search" class="form-label">Search by Name</label>
                        <input type="text" name="search" id="search" class="form-control" 
                               placeholder="Search fish by name..." value="{{ $search }}">
                    </div>
                    
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-primary me-2">
                            <i class="bi bi-search"></i> Apply Filters
                        </button>
                        <a href="{{ route('fishes.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Fish Table -->
    <div class="card">
        <div class="card-body">
            @if($fishes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc']) }}" 
                                       class="text-decoration-none">
                                        Name 
                                        @if(request('sort') === 'name')
                                            <i class="bi bi-arrow-{{ request('direction', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th> 
                                <th>Rarity</th>
                                <th>Weight Range</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'sell_price_per_kg', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc']) }}" 
                                       class="text-decoration-none">
                                        Price/kg 
                                        @if(request('sort') === 'sell_price_per_kg')
                                            <i class="bi bi-arrow-{{ request('direction', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'catch_probability', 'direction' => request('direction', 'asc') === 'asc' ? 'desc' : 'asc']) }}" 
                                       class="text-decoration-none">
                                        Catch Prob. 
                                        @if(request('sort') === 'catch_probability')
                                            <i class="bi bi-arrow-{{ request('direction', 'asc') === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fishes as $fish)
                                <tr>
                                    <td>
                                        <strong>{{ $fish->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="{{ $fish->rarityClass }} fw-bold">
                                            <i class="bi bi-star-fill"></i> {{ $fish->rarity }}
                                        </span>
                                    </td>
                                    <td>{{ $fish->formatted_weight }}</td>
                                    <td>{{ $fish->formatted_sell_price }} coins</td>
                                    <td>{{ $fish->formattedCatchProbability }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('fishes.show', $fish) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               title="View details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('fishes.edit', $fish) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="#" 
                                               class="btn btn-sm btn-outline-danger" 
                                               title="Delete"
                                               onclick="event.preventDefault(); 
                                                        if(confirm('Are you sure you want to delete this fish: {{ $fish->name }}?')) {
                                                            document.getElementById('delete-form-{{ $fish->id }}').submit();
                                                        }">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            
                                            <!-- Hidden form for delete action -->
                                            <form id="delete-form-{{ $fish->id }}" 
                                                  action="{{ route('fishes.destroy', $fish) }}" 
                                                  method="POST" 
                                                  class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $fishes->withQueryString()->links('vendor.pagination.bootstrap-4') }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-fish" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">No fishes found</h4>
                    <p class="text-muted">Try adjusting your search or filter criteria, or <a href="{{ route('fishes.create') }}">add a new fish</a>.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection