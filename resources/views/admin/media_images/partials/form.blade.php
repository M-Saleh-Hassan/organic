<div class="form-group">
    <label for="file_path">File</label>
    <input type="file" name="file_path" id="file_path" class="form-control @error('file_path') is-invalid @enderror">
    @if (isset($image) && $image->file_path)
        <small class="form-text text-muted">
            Current File: <a href="{{ asset('storage/' . $image->file_path) }}" target="_blank">View File</a>
        </small>
    @endif
    @error('file_path')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="date">Date</label>
    <input type="date" name="date" id="date" value="{{ old('date', $image->date ?? '') }}" class="form-control @error('date') is-invalid @enderror">
    @error('date')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success">{{ $submitText }}</button>
    <a href="{{ route('admin.media.images.index', $medium ?? $image->media) }}" class="btn btn-secondary">Cancel</a>
</div>
