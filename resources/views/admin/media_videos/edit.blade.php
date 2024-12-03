@extends('adminlte::page')

@section('title', 'Edit Media Video')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Edit Video for Media #{{ $video->media_id }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Media</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.media.videos.index', $video->media_id) }}">Videos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.media.videos.update', [$video->media_id, $video]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.media_videos.partials.form', ['submitText' => 'Update'])
        </form>
    </div>
</div>
@stop
