@extends('adminlte::page')

@section('title', 'Edit Production Detail')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Edit Production Detail</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.productions.index') }}">Productions</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.productions.details.index', $detail->production_id) }}">Details</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.productions.details.update', [$detail->production_id, $detail]) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.production_details.partials.form', ['submitText' => 'Update'])
        </form>
    </div>
</div>
@stop
