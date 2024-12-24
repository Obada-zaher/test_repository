@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center bg-white position-relative py-5">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <label for="image" class="position-relative" style="cursor: pointer;">
                            <img id="profileImage"
                            src="{{ $user->image ? asset('storage/' . $user->image) . '?' . time() : asset('images/noprofile.png') }}"
                                 alt="Profile Image"
                                 class="rounded-circle border border-3 shadow-sm"
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        </label>
                        <input type="file" id="image" name="image" class="d-none" accept="image/*" onchange="previewImage(event)">

                       <!-- زر تعيين الصورة وزر إزالة الصورة -->
                    <div class="mt-2 text-center d-flex justify-content-center align-items-center gap-2">
                        <!-- زر تعيين الصورة -->
                        <label for="image" class="btn btn-sm btn-outline-dark d-flex align-items-center justify-content-center p-2 rounded-circle" style="cursor: pointer;" title="Set Image">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="image" name="image" class="d-none" accept="image/*" onchange="previewImage(event)">

                        <!-- زر إزالة الصورة -->
                        <form method="POST" action="{{ route('profile.remove_image') }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center p-2 rounded-circle" title="Remove Image">
                                <i class="fas fa-eraser"></i>
                            </button>
                        </form>
                    </div>

                </div>

                <div class="card-body px-5">
                    @if(session('status') === 'profile-updated')
                        <div class="alert alert-success text-center">
                            Profile updated successfully.
                        </div>
                    @endif

                    <!-- الاسم الأول -->
                    <div class="mb-4">
                        <label for="first_name" class="form-label fw-bold">First Name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- الاسم الأخير -->
                    <div class="mb-4">
                        <label for="last_name" class="form-label fw-bold">Last Name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- البريد الإلكتروني -->
                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- اسم المستخدم -->
                    <div class="mb-4">
                        <label for="username" class="form-label fw-bold">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $user->username) }}">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- رقم الهاتف -->
                    <div class="mb-4">
                        <label for="phone" class="form-label fw-bold">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- زر الحفظ -->
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-dark px-4">Save Changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('profileImage');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
