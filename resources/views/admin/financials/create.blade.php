@extends('adminlte::page')

@section('title', 'Add Financial Record')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Add Financial Record</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.financials.index') }}">Financials</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add</li>
                </ol>
            </nav>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.financials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.financials.partials.form', ['submitText' => 'Save'])
            </form>
        </div>
    </div>
@stop
