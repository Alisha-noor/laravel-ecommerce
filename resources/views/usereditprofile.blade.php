@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg rounded-3 border-0">
                    <div class="card-header text-center" style="background:#b56576; color:#fff;">
                        <h4 class="mb-0 fw-bold">Edit Profile</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Avatar Upload -->
                            <div class="text-center mb-4">
                                <label for="avatarInput" class="avatar-edit-label">
                                    @if($user->avatar ?? false)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" class="profile-avatar-edit" id="avatarPreview">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=b56576&color=fff&size=120"
                                             class="profile-avatar-edit" id="avatarPreview">
                                    @endif
                                    <div class="avatar-overlay">Change</div>
                                </label>
                                <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;">
                            </div>

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-custom px-4">💾 Save Changes</button>
                                <a href="{{ route('userprofile') }}" class="btn btn-outline-custom px-4">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
        <style>
            /* Avatar Edit */
            .avatar-edit-label {
                position: relative;
                display: inline-block;
                cursor: pointer;
            }

            .profile-avatar-edit {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                border: 4px solid #fff;
                object-fit: cover;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                transition: transform 0.3s ease;
            }

            .profile-avatar-edit:hover {
                transform: scale(1.05);
            }

            .avatar-overlay {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(0,0,0,0.6);
                color: #fff;
                font-size: 0.9rem;
                text-align: center;
                padding: 5px;
                border-radius: 0 0 50% 50%;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .avatar-edit-label:hover .avatar-overlay {
                opacity: 1;
            }

            /* Custom Buttons */
            .btn-custom {
                background-color: #b56576;
                color: #fff;
                border-radius: 6px;
                transition: 0.3s ease;
            }

            .btn-custom:hover {
                background-color: #9d4d62;
                color: #fff;
            }

            .btn-outline-custom {
                border: 2px solid #b56576;
                color: #b56576;
                border-radius: 6px;
                transition: 0.3s ease;
            }

            .btn-outline-custom:hover {
                background-color: #b56576;
                color: #fff;
            }
        </style>
    
        <script>
            // Preview new avatar instantly before upload
            document.getElementById('avatarInput').addEventListener('change', function(event) {
                const [file] = event.target.files;
                if (file) {
                    document.getElementById('avatarPreview').src = URL.createObjectURL(file);
                }
            });
        </script>
@endsection
