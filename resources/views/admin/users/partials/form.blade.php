<div class="form-group">
    <label for="full_name">Full Name</label>
    <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $user->full_name ?? '') }}" class="form-control @error('full_name') is-invalid @enderror">
    @error('full_name')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" class="form-control @error('email') is-invalid @enderror">
    @error('email')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="phone_number">Phone Number</label>
    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number ?? '') }}" class="form-control @error('phone_number') is-invalid @enderror">
    @error('phone_number')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="id_type">ID Type</label>
    <select name="id_type" id="id_type" class="form-control @error('id_type') is-invalid @enderror">
        <option value="">Select ID Type</option>
        <option value="national_id" {{ old('id_type', $user->id_type ?? '') == 'national_id' ? 'selected' : '' }}>National ID</option>
        <option value="passport" {{ old('id_type', $user->id_type ?? '') == 'passport' ? 'selected' : '' }}>Passport</option>
    </select>
    @error('id_type')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


<div class="form-group">
    <label for="id_number">ID Number</label>
    <input type="text" name="id_number" id="id_number" value="{{ old('id_number', $user->id_number ?? '') }}" class="form-control @error('id_number') is-invalid @enderror">
    @error('id_number')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
    @error('password')
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
    @enderror
</div>

<div class="form-group">
    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
</div>

<div class="form-group">
    <button type="submit" class="btn btn-success">{{ $submitText }}</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
</div>
