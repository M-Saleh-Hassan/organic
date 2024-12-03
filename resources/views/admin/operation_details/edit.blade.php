@extends('adminlte::page')

@section('title', 'Edit Operation Detail')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Edit Operation Detail</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.operations.index') }}">Operations</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Detail</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.operations.details.update', [$detail->operation_id, $detail]) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.operation_details.partials.form', ['submitText' => 'Update'])
        </form>
    </div>
</div>
@stop
