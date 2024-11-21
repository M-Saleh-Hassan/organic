<div class="form-group">
    <label for="user_id">User</label>
    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
        <option value="">Select a User</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $land->user_id ?? '') == $user->id ? 'selected' : '' }}>
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
    <label for="land_number">Land Number</label>
    <input type="text" name="land_number" id="land_number" value="{{ old('land_number', $land->land_number ?? '') }}"
           class="form-control @error('land_number') is-invalid @enderror">
    @error('land_number')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="size">Size (sqm)</label>
    <input type="number" step="0.01" name="size" id="size" value="{{ old('size', $land->size ?? '') }}"
           class="form-control @error('size') is-invalid @enderror">
    @error('size')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="number_of_pits">Number of Pits</label>
    <input type="number" name="number_of_pits" id="number_of_pits" value="{{ old('number_of_pits', $land->number_of_pits ?? '') }}"
           class="form-control @error('number_of_pits') is-invalid @enderror">
    @error('number_of_pits')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="number_of_palms">Number of Palms</label>
    <input type="number" name="number_of_palms" id="number_of_palms" value="{{ old('number_of_palms', $land->number_of_palms ?? '') }}"
           class="form-control @error('number_of_palms') is-invalid @enderror">
    @error('number_of_palms')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="cultivation_count">Cultivations</label>
    <input type="text" name="cultivation_count" id="cultivation_count" value="{{ old('cultivation_count', $land->cultivation_count ?? '') }}"
           class="form-control @error('cultivation_count') is-invalid @enderror">
    @error('cultivation_count')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <label for="missing_count">Missing Count</label>
    <input type="number" step="0.01" name="missing_count" id="missing_count" value="{{ old('missing_count', $land->missing_count ?? '') }}"
           class="form-control @error('missing_count') is-invalid @enderror">
    @error('missing_count')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success">{{ $submitText }}</button>
    <a href="{{ route('admin.lands.index') }}" class="btn btn-secondary">Cancel</a>
</div>
