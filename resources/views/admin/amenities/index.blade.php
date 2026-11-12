@extends('admin.layouts.app')

@section('title', 'Manage Amenities')
@section('page-title', 'Manage Amenities')

@section('content')
<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0"><i class="fas fa-list-check me-2"></i> All Amenities</h5>
        <a href="{{ route('admin.amenities.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Amenity
        </a>
    </div>

    @if($amenities->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($amenities as $amenity)
                    <tr>
                        <td><i class="{{ $amenity->icon_class }} fa-lg"></i></td>
                        <td><strong>{{ $amenity->name }}</strong></td>
                        <td><span class="badge bg-info">{{ ucfirst($amenity->category) }}</span></td>
                        <td>{{ Str::limit($amenity->description, 50) }}</td>
                        <td>
                            <form action="{{ route('admin.amenities.toggle-status', $amenity) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-{{ $amenity->is_active ? 'success' : 'danger' }}">
                                    <i class="fas fa-{{ $amenity->is_active ? 'check' : 'times' }}"></i>
                                    {{ $amenity->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.amenities.edit', $amenity) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.amenities.destroy', $amenity) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this amenity?');">
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
            {{ $amenities->links() }}
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="fas fa-list-check fa-3x mb-3"></i>
            <p>No amenities found. Add your first amenity to get started.</p>
            <a href="{{ route('admin.amenities.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus me-2"></i> Add First Amenity
            </a>
        </div>
    @endif
</div>
@endsection
