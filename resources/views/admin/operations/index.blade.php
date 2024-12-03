@extends('adminlte::page')

@section('title', 'Operations')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Operations</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Operations</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.operations.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Operation
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Land</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operations as $operation)
                        <tr>
                            <td>{{ $operation->id }}</td>
                            <td>{{ $operation->user->full_name }}</td>
                            <td>{{ $operation->land->land_number }}</td>
                            <td>{{ $operation->description }}</td>
                            <td>
                                <a href="{{ route('admin.operations.details.index', $operation) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-list"></i> Details
                                </a>
                                <a href="{{ route('admin.operations.edit', $operation) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.operations.destroy', $operation) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $operations->links() }}
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
