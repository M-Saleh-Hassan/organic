<div class="form-group">
    <label for="month">Month</label>
    <input type="text" name="month" id="month" value="{{ old('month', $record->month ?? '') }}"
           class="form-control @error('month') is-invalid @enderror">
    @error('month')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="date">Date</label>
    <input type="date" name="date" id="date" value="{{ old('date', $record->date ?? '') }}"
           class="form-control @error('date') is-invalid @enderror">
    @error('date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="amount">Amount</label>
    <input type="number" name="amount" id="amount" value="{{ old('amount', $record->amount ?? '') }}" step="0.01"
           class="form-control @error('amount') is-invalid @enderror">
    @error('amount')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success">{{ $submitText }}</button>
    <a href="{{ route('admin.financials.records.index', $financial ?? $record->financial_id) }}" class="btn btn-secondary">Cancel</a>
</div>
