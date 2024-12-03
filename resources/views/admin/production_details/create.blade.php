@extends('adminlte::page')

@section('title', 'Add Production Detail')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1>Add Production Detail</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.productions.index') }}">Productions</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.productions.details.index', $production) }}">Details</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add</li>
            </ol>
        </nav>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.productions.details.store', $production) }}" method="POST">
            @csrf
            @include('admin.production_details.partials.form', ['submitText' => 'Save'])
        </form>
    </div>
</div>
@stop
