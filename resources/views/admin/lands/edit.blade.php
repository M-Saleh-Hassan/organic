@extends('adminlte::page')

@section('title', 'Edit Land')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Edit Land</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.lands.index') }}">Lands</a></li>
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
        <form action="{{ route('admin.lands.update', $land) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.lands.partials.form', ['submitText' => 'Update'])
        </form>
    </div>
</div>
@stop

@section('footer')

    <form id="logout-form" action="{{ route('admin/logout') }}" method="POST" style="display: none;">
        @csrf

    </form>
@stop
