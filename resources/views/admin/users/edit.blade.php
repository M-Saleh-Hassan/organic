@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Edit User</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.users.partials.form', ['submitText' => 'Update'])
        </form>
    </div>
</div>
@stop
