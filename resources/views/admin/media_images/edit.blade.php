@extends('adminlte::page')

@section('title', 'Edit Media Image')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Edit Image for Media #{{ $image->media_id }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.media.index') }}">Media</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.media.images.index', $image->media_id) }}">Images</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.media.images.update', [$image->media_id, $image]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.media_images.partials.form', ['submitText' => 'Update'])
        </form>
    </div>
</div>
@stop
