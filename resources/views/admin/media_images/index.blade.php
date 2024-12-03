@extends('adminlte::page')

@section('title', 'Media Images')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Images for Media #{{ $medium->id }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Media</a></li>
                <li class="breadcrumb-item active" aria-current="page">Images</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.media.images.create', $medium) }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Image
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
                    <th>File</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $image)
                <tr>
                    <td>{{ $image->id }}</td>
                    <td><a href="{{ asset('storage/' . $image->file_path) }}" target="_blank">View Image</a></td>
                    <td>{{ $image->date }}</td>
                    <td>
                        <a href="{{ route('admin.media.images.edit', [$medium, $image]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.media.images.destroy', [$medium, $image]) }}" method="POST" style="display:inline;">
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
            {{ $images->links() }}
        </div>
    </div>
</div>
@stop
