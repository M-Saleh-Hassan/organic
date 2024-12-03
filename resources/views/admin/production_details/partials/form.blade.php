<div class="form-group">
    <label for="type">Type</label>
    <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
        <option value="">Select Type</option>
        <option value="past" {{ old('type', $detail->type ?? '') == 'past' ? 'selected' : '' }}>Past</option>
        <option value="current" {{ old('type', $detail->type ?? '') == 'current' ? 'selected' : '' }}>Current</option>
    </select>
    @error('type')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="text">Text</label>
    <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror">{{ old('text', $detail->text ?? '') }}</textarea>
    @error('text')
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
    <a href="{{ route('admin.productions.details.index', $production ?? $detail->production) }}" class="btn btn-secondary">Cancel</a>
</div>
