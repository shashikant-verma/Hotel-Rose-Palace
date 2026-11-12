@extends('admin.layouts.app')

@section('title', 'Manage Room Types')
@section('page-title', 'Manage Room Types')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0"><i class="fas fa-layer-group me-2"></i> All Room Types</h5>
        <a href="{{ route('admin.room-types.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Room Type
        </a>
    </div>

    @if($roomTypes->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Base Price</th>
                        <th>Max Occupancy</th>
                        <th>Rooms</th>
                        <th>Amenities</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomTypes as $roomType)
                    <tr>
                        <td>
                            <strong>{{ $roomType->name }}</strong><br>
                            <small class="text-muted">{{ Str::limit($roomType->description, 50) }}</small>
                        </td>
                        <td>₹{{ number_format($roomType->base_price) }}</td>
                        <td>{{ $roomType->max_occupancy }} guests</td>
                        <td>
                            <span class="badge bg-info">{{ $roomType->rooms_count }} rooms</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $roomType->amenities_count }} amenities</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.room-types.toggle-status', $roomType) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-{{ $roomType->is_active ? 'success' : 'danger' }}">
                                    <i class="fas fa-{{ $roomType->is_active ? 'check' : 'times' }}"></i>
                                    {{ $roomType->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.room-types.edit', $roomType) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.room-types.destroy', $roomType) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this room type?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
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
            <a href="{{ route('admin.room-types.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i> Add First Room Type
            </a>
        </div>
    @endif
</div>
@endsection
