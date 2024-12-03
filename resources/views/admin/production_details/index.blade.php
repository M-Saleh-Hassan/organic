@extends('adminlte::page')

@section('title', 'Production Details')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Production Details for Production #{{ $production->id }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.productions.index') }}">Productions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.productions.details.create', $production) }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Detail
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
                    <th>Type</th>
                    <th>Text</th>
                    <th>Order</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $detail)
                <tr>
                    <td>{{ $detail->id }}</td>
                    <td>{{ ucfirst($detail->type) }}</td>
                    <td>{{ $detail->text }}</td>
                    <td>{{ $detail->order }}</td>
                    <td>
                        <a href="{{ route('admin.productions.details.edit', [$production, $detail]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.productions.details.destroy', [$production, $detail]) }}" method="POST" style="display:inline;">
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
            {{ $details->links() }}
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
