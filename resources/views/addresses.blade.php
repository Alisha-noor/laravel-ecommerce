@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>My Addresses</h2>
        @foreach ($addresses as $address)
            <div class="card mb-2 p-3">
                <p>{{ $address->address }}</p>
                <p>{{ $address->city }}, {{ $address->state }} {{ $address->zip }}</p>
                @if ($address->isdefault)
                    <span class="badge bg-success">Default</span>
                @endif
            </div>
        @endforeach
    </div>
@endsection
