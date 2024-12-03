<div class="form-group">
    <label for="user_id">User</label>
    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
        <option value="">Select User</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $production->user_id ?? '') == $user->id ? 'selected' : '' }}>
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
            <option value="{{ $land->id }}" {{ old('land_id', $production->land_id ?? '') == $land->id ? 'selected' : '' }}>
                {{ $land->land_number }}
            </option>
        @endforeach
    </select>
    @error('land_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $production->description ?? '') }}</textarea>
    @error('description')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success">{{ $submitText }}</button>
    <a href="{{ route('admin.productions.index') }}" class="btn btn-secondary">Cancel</a>
</div>
