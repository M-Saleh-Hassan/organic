@extends('adminlte::page')

@section('title', 'Edit Financial Record')

@section('content_header')
    <h1>Edit Financial Record</h1>
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
