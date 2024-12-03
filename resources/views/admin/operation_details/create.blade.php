@extends('adminlte::page')

@section('title', 'Add Operation Detail')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Add Operation Detail</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.operations.index') }}">Operations</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Detail</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.operations.details.store', $operation) }}" method="POST">
            @csrf
            @include('admin.operation_details.partials.form', ['submitText' => 'Save'])
        </form>
    </div>
</div>
@stop
