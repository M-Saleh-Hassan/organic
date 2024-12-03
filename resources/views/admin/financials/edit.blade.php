@extends('adminlte::page')

@section('title', 'Edit Financial Record')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1>Edit Financial Record</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.financials.index') }}">Financials</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.financials.update', $financial) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.financials.partials.form', ['submitText' => 'Update'])
            </form>
        </div>
    </div>
@stop

@section('footer')
@stop
