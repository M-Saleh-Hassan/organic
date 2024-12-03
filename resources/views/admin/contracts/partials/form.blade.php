<div class="form-group">
    <label for="user_id">User</label>
    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
        <option value="">Select User</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}"
                {{ old('user_id', $contract->user_id ?? '') == $user->id ? 'selected' : '' }}>
                {{ $user->full_name }}
            </option>
        @endforeach
    </select>
    @error('user_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="land_id">Land</label>
    <select name="land_id" id="land_id" class="form-control @error('land_id') is-invalid @enderror">
        <option value="">Select Land</option>
        @foreach ($lands as $land)
            <option value="{{ $land->id }}"
                {{ old('land_id', $contract->land_id ?? '') == $land->id ? 'selected' : '' }}>
                {{ $land->land_number }}
            </option>
        @endforeach
    </select>
    @error('land_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="sponsorship_contract">Sponsorship Contract</label>
    <input type="file" name="sponsorship_contract" id="sponsorship_contract"
        class="form-control @error('sponsorship_contract') is-invalid @enderror">
    @if (isset($contract) && $contract->sponsorship_contract_path)
        <small class="form-text text-muted">
            Current File: <a href="{{ asset($contract->sponsorship_contract_path) }}" target="_blank">View File</a>
        </small>
    @endif
    @error('sponsorship_contract')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="participation_contract">Participation Contract</label>
    <input type="file" name="participation_contract" id="participation_contract"
        class="form-control @error('participation_contract') is-invalid @enderror">
    @if (isset($contract) && $contract->participation_contract_path)
        <small class="form-text text-muted">
            Current File: <a href="{{ asset($contract->participation_contract_path) }}" target="_blank">View File</a>
        </small>
    @endif
    @error('participation_contract')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="personal_id">Personal ID</label>
    <input type="file" name="personal_id" id="personal_id"
        class="form-control @error('personal_id') is-invalid @enderror">
    @if (isset($contract) && $contract->personal_id_path)
        <small class="form-text text-muted">
            Current File: <a href="{{ asset($contract->personal_id_path) }}" target="_blank">View File</a>
        </small>
    @endif
    @error('personal_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success">{{ $submitText }}</button>
    <a href="{{ route('admin.contracts.index') }}" class="btn btn-secondary">Cancel</a>
</div>
