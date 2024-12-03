<div class="form-group">
    <label for="user_id">User</label>
    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
        <option value="">Select a User</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ isset($financial) && $financial->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->full_name }}
            </option>
        @endforeach
    </select>
    @error('user_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="land_id">Land</label>
    <select name="land_id" id="land_id" class="form-control @error('land_id') is-invalid @enderror">
        <option value="">Select a Land</option>
        @foreach ($lands as $land)
            <option value="{{ $land->id }}" {{ isset($financial) && $financial->land_id == $land->id ? 'selected' : '' }}>
                {{ $land->land_number }}
            </option>
        @endforeach
    </select>
    @error('land_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="file_path">File</label>
    <input type="file" name="file_path" id="file_path" class="form-control @error('file_path') is-invalid @enderror" accept=".xls,.xlsx">
    @if (isset($financial) && $financial->file_path)
        <small class="form-text text-muted">
            Current File: <a href="{{ asset($financial->file_path) }}" target="_blank">View File</a>
        </small>
    @endif
    @error('file_path')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success">{{ $submitText }}</button>
    <a href="{{ route('admin.financials.index') }}" class="btn btn-secondary">Cancel</a>
</div>
