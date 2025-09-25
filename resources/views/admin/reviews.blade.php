@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Product Reviews</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>User</th>
                    <th class="email-col" style="width: 250px;">Email</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Status</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>{{ $review->product->name ?? 'N/A' }}</td>
                        <td>{{ $review->name }}</td>
                        <td class="email-col"style="width: 250px;" >{{ $review->email }}</td>
                        <td>{{ $review->rating }} ★</td>
                        <td>{{ $review->review }}</td>
                        <td>
                            <span class="badge bg-{{ $review->status == 'approved' ? 'success' : 'warning' }}">
                                {{ ucfirst($review->status) }}
                            </span>
                        </td>
                        <td>{{ $review->created_at->format('d M Y') }}</td>
                        <td class="d-flex gap-2">
                            @if ($review->status == 'pending')
                                <form action="{{ route('admin.review.approve', $review->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button class="btn btn-sm btn-success">Approve</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.review.delete', $review->id) }}" method="POST"
                                onsubmit="return confirm('Delete this review?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No reviews found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
