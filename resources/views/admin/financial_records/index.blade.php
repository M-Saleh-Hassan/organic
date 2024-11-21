@extends('adminlte::page')

@section('title', 'Financial Records')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Financial Records for Financial #{{ $financial->id }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.financials.index') }}">Financials</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Records</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.financials.records.create', $financial) }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Record
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
                        <th>Month</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                        <tr>
                            <td>{{ $record->id }}</td>
                            <td>{{ $record->month }}</td>
                            <td>{{ $record->date }}</td>
                            <td>${{ number_format($record->amount, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.records.edit', $record) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.records.destroy', $record) }}" method="POST"
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
                {{ $records->links() }}
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
