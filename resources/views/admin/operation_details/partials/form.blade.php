<div class="form-group">
    <label for="type">Type</label>
    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
        <option value="">Select Type</option>
        <option value="past" {{ old('type', $detail->type ?? '') == 'past' ? 'selected' : '' }}>Past</option>
        <option value="current" {{ old('type', $detail->type ?? '') == 'current' ? 'selected' : '' }}>Current</option>
        <option value="future" {{ old('type', $detail->type ?? '') == 'future' ? 'selected' : '' }}>Future</option>
    </select>
    @error('type')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $detail->description ?? '') }}</textarea>
    @error('description')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="order">Order</label>
    <input type="number" name="order" id="order" value="{{ old('order', $detail->order ?? 0) }}"
           class="form-control @error('order') is-invalid @enderror">
    @error('order')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success">{{ $submitText }}</button>
    <a href="{{ route('admin.operations.details.index', $operation ?? $detail->operation) }}" class="btn btn-secondary">Cancel</a>
</div>
