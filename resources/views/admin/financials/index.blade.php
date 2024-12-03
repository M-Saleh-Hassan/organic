@extends('adminlte::page')

@section('title', 'Financials')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Financial Records</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Financials</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.financials.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Financial Record
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
                        <th>Land</th>
                        <th>File</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($financials as $financial)
                        <tr>
                            <td>{{ $financial->id }}</td>
                            <td>{{ $financial->user->full_name }}</td>
                            <td>{{ $financial->land->land_number }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $financial->file_path) }}" target="_blank">View File</a>
                            </td>
                            <td>
                                <!-- Link to Financial Records -->
                                <a href="{{ route('admin.financials.records.index', $financial) }}"
                                    class="btn btn-info btn-sm">
                                    <i class="fas fa-list"></i> Records
                                </a>
                                <a href="{{ route('admin.financials.edit', $financial) }}"
                                    class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('admin.financials.destroy', $financial) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $financials->links() }}
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

@section('footer')
    
@stop
