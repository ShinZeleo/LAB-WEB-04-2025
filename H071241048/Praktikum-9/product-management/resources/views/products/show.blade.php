@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Product Details</h4>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <strong>Name:</strong>
                        <p>{{ $product->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Category:</strong>
                        <p>{{ $product->category ? $product->category->name : 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Price:</strong>
                        <p>Rp {{ number_format($product->price, 2, ',', '.') }}</p>
                    </div>
                    
                    <hr>
                    
                    <h5>Product Details</h5>
                    
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p>{{ $product->productDetail->description ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Weight:</strong>
                        <p>{{ $product->productDetail->weight ?? 'N/A' }} kg</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Size:</strong>
                        <p>{{ $product->productDetail->size ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Created At:</strong>
                        <p>{{ $product->created_at->format('d M Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Updated At:</strong>
                        <p>{{ $product->updated_at->format('d M Y H:i') }}</p>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
                        <div>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection