@extends('adminlte::page')

@section('title', 'Media Videos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Videos for Media #{{ $medium->id }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Media</a></li>
                <li class="breadcrumb-item active" aria-current="page">Videos</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="{{ route('admin.media.videos.create', $medium) }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add Video
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
                @foreach ($videos as $video)
                <tr>
                    <td>{{ $video->id }}</td>
                    <td><a href="{{ asset('storage/' . $video->file_path) }}" target="_blank">View Video</a></td>
                    <td>{{ $video->date }}</td>
                    <td>
                        <a href="{{ route('admin.media.videos.edit', [$medium, $video]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.media.videos.destroy', [$medium, $video]) }}" method="POST" style="display:inline;">
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
            {{ $videos->links() }}
        </div>
    </div>
</div>
@stop
