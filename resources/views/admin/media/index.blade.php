@extends('adminlte::page')

@section('title', 'Media')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Media</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Media</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.media.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Media
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($media as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->user->full_name }}</td>
                    <td>{{ $item->land->land_number }}</td>
                    <td>
                        <a href="{{ route('admin.media.images.index', $item) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-image"></i> Images
                        </a>
                        <a href="{{ route('admin.media.videos.index', $item) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-video"></i> Videos
                        </a>
                        <a href="{{ route('admin.media.edit', $item) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.media.destroy', $item) }}" method="POST" style="display:inline;">
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
            {{ $media->links() }}
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
