@extends('adminlte::page')

@section('title', 'Edit Production')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Edit Production</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.productions.index') }}">Productions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.productions.update', $production) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.productions.partials.form', ['submitText' => 'Update'])
        </form>
    </div>
</div>
@stop
