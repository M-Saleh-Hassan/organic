@extends('adminlte::page')

@section('title', 'Add Contract')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Add Contract</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.contracts.index') }}">Contracts</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.contracts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.contracts.partials.form', ['submitText' => 'Save'])
            </form>
        </div>
    </div>
@stop
