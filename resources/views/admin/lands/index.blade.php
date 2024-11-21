@extends('adminlte::page')

@section('title', 'Lands')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Lands</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lands</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.lands.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Land
        </a>
    </div>
</div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Land Number</th>
                        <th>Size</th>
                        <th>Number of Pits</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lands as $land)
                        <tr>
                            <td>{{ $land->id }}</td>
                            <td>{{ $land->user->full_name }}</td>
                            <td>{{ $land->land_number }}</td>
                            <td>{{ $land->size }} sqm</td>
                            <td>{{ $land->number_of_pits }}</td>
                            <td>
                                <a href="{{ route('admin.lands.edit', $land) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.lands.destroy', $land) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $lands->links() }}
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        window.onload = function() {
            // Select the specific SVG element with the exact class
            const svgElements = document.querySelectorAll('svg.w-5.h-5');

            // Remove the element if it exists
            svgElements.forEach(function(svg) {
                svg.remove(); // Remove each SVG
            });

        };
    </script>
@stop
