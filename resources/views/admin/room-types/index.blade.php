@extends('admin.layouts.app')

@section('title', 'Manage Room Types')
@section('page-title', 'Manage Room Types')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0"><i class="fas fa-layer-group me-2"></i> All Room Types</h5>
        <button class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Room Type
        </button>
    </div>

    @if($roomTypes->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Base Price</th>
                        <th>Max Occupancy</th>
                        <th>Size</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomTypes as $roomType)
                    <tr>
                        <td><strong>{{ $roomType->name }}</strong></td>
                        <td>₹{{ number_format($roomType->base_price) }}</td>
                        <td>{{ $roomType->max_occupancy }} guests</td>
                        <td>{{ $roomType->size_sqft }} sq ft</td>
                        <td>{{ $roomType->created_at->format('M d, Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $roomTypes->links() }}
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="fas fa-layer-group fa-3x mb-3"></i>
            <p>No room types found. Add your first room type to get started.</p>
            <button class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i> Add First Room Type
            </button>
        </div>
    @endif
</div>
@endsection
