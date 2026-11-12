@extends('layouts.admin')

@section('page_title', 'Room Types Management')

@section('content')

<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h5><i class="fas fa-th-large"></i> Room Types List</h5>
        <a href="#" class="btn btn-primary"><i class="fas fa-plus"></i> Add Room Type</a>
    </div>
    
    @if($roomTypes->count() > 0)
        <div style="overflow-x: auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Base Price</th>
                        <th>Max Occupancy</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomTypes as $roomType)
                        <tr>
                            <td><strong>{{ $roomType->name }}</strong></td>
                            <td>₹{{ number_format($roomType->base_price) }}</td>
                            <td>{{ $roomType->max_occupancy }} guests</td>
                            <td>
                                <span class="badge" style="background-color: {{ $roomType->is_active ? '#28a745' : '#e74c3c' }};">
                                    {{ $roomType->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary" style="padding: 4px 8px; font-size: 11px;">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $roomTypes->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 40px; color: #999;">
            <p>No room types found</p>
        </div>
    @endif
</div>

@endsection
