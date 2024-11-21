@extends('adminlte::page')

@section('title', 'Add Financial Record')

@section('content_header')
    <h1>Add Financial Record</h1>
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
