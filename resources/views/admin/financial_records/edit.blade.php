@extends('adminlte::page')

@section('title', 'Edit Financial Record')

@section('content_header')
    <h1>Edit Financial Record</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.financials.index') }}">Financials</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.financials.records.index', $financial ?? $record->financial_id) }}">Records</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ isset($record) ? 'Edit' : 'Add' }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.records.update', $record) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.financial_records.partials.form', ['submitText' => 'Update'])
            </form>
        </div>
    </div>
@stop
