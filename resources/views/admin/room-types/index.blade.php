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
                            @if($roomType->rooms_count > 0)
                            <button type="button" class="btn btn-sm btn-outline-warning" onclick="showForceDeleteModal({{ $roomType->id }}, '{{ $roomType->name }}', {{ $roomType->rooms_count }})">
                                <i class="fas fa-trash"></i> Force
                            </button>
                            @else
                            <form action="{{ route('admin.room-types.destroy', $roomType) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this room type?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
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

{{-- Force Delete Modal --}}
<div class="modal fade" id="forceDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i> Force Delete Room Type</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Room Type:</strong> <span id="forceDeleteName"></span></p>
                <p class="text-danger"><strong>⚠️ Warning:</strong> This will delete the room type and <strong id="forceDeleteCount"></strong> associated room(s) along with their data.</p>
                <p>This action cannot be undone!</p>
                <p>Type the room type name to confirm:</p>
                <input type="text" id="forceDeleteConfirmInput" class="form-control" placeholder="Type room type name to confirm">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="forceDeleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="force_delete" value="true">
                    <button type="submit" class="btn btn-danger" id="forceDeleteBtn" disabled>
                        <i class="fas fa-trash me-2"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showForceDeleteModal(roomTypeId, roomTypeName, roomCount) {
    const modal = new bootstrap.Modal(document.getElementById('forceDeleteModal'));
    document.getElementById('forceDeleteName').textContent = roomTypeName;
    document.getElementById('forceDeleteCount').textContent = roomCount;
    document.getElementById('forceDeleteForm').action = `/admin/room-types/${roomTypeId}`;
    document.getElementById('forceDeleteConfirmInput').value = '';
    document.getElementById('forceDeleteBtn').disabled = true;
    
    // Enable button only when name is typed correctly
    document.getElementById('forceDeleteConfirmInput').addEventListener('input', function() {
        document.getElementById('forceDeleteBtn').disabled = this.value !== roomTypeName;
    });
    
    modal.show();
}
</script>
@endsection
