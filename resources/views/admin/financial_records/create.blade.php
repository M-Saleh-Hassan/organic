@extends('adminlte::page')

@section('title', 'Add Financial Record')

@section('content_header')
    <h1>Add Financial Record</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.financials.index') }}">Financials</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.financials.records.index', $financial ?? $record->financial_id) }}">Records</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ isset($record) ? 'Edit' : 'Add' }}</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.financials.records.store', $financial) }}" method="POST">
                @csrf
                @include('admin.financial_records.partials.form', ['submitText' => 'Save'])
            </form>
        </div>
    </div>
@stop

@section('footer')
    <form id="logout-form" action="{{ route('admin/logout') }}" method="POST" style="display: none;">

        @csrf
    </form>
@stop
