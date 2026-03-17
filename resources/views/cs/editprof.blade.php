@extends('cs.layout.app')

@section('title', 'Edit Profile')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body { font-family: 'Inter', sans-serif; background-color: #f0f2f5; color: #333; }

    /* Glassmorphism Container */
    .glass-container {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        padding: 2.5rem;
        margin-top: 20px;
    }

    /* Section Headings */
    .page-title {
        color: #6f42c1; /* Ungu */
        font-weight: 800;
        font-size: 1.6rem;
        border-left: 6px solid #ffc107; /* Kuning */
        padding-left: 15px;
        margin-bottom: 30px;
        letter-spacing: -0.5px;
    }

    .sub-title {
        font-weight: 700;
        color: #4a4a4a;
        font-size: 1.1rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    /* Profile Photo Styling */
    .photo-preview-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin-bottom: 20px;
    }

    .profile-img-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 20px;
        border: 4px solid white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    /* Modern Form Controls */
    .info-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #8e9aaf;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #e0e6ed;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
    }

    .form-control:focus {
        border-color: #6f42c1;
        box-shadow: 0 0 0 4px rgba(111, 66, 193, 0.1);
    }

    /* Buttons */
    .btn-modern {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-save-profile {
        background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(111, 66, 193, 0.2);
    }

    .btn-save-profile:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(111, 66, 193, 0.3);
        color: #ffc107; /* Aksen Kuning */
    }

    .btn-change-password {
        background: #ffc107;
        color: #2d3436;
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.2);
    }

    .btn-change-password:hover {
        background: #e5ac00;
        transform: translateY(-2px);
    }

    /* Input Group Icons */
    .input-group-text {
        background: transparent;
        border-left: none;
        color: #6f42c1;
        cursor: pointer;
        border-radius: 0 12px 12px 0 !important;
    }

    .input-group .form-control {
        border-right: none;
        border-radius: 12px 0 0 12px !important;
    }

    hr {
        margin: 40px 0;
        opacity: 0.1;
    }
</style>

<div class="container py-4">
    <div class="glass-container">
        <h4 class="page-title"><i class="fas fa-user-edit me-2"></i>Edit My Profile</h4>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-6 pe-lg-5">
                <h5 class="sub-title"><i class="fas fa-id-card me-2 text-primary"></i>Personal Information</h5>
                <form action="{{ route('cs.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="info-label">Profile Picture</label>
                        <div class="photo-preview-wrapper">
                            <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('images/default-avatar.png') }}"
                                 class="profile-img-preview" id="previewImg">
                        </div>
                        <input type="file" name="profile_photo" class="form-control" onchange="previewFile(this)">
                    </div>

                    <div class="mb-3">
                        <label class="info-label">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ $user->username }}" placeholder="Enter username">
                    </div>

                    <div class="mb-4">
                        <label class="info-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" placeholder="Enter email">
                    </div>

                    <button class="btn btn-modern btn-save-profile w-100">
                        <i class="fas fa-save me-2"></i> Save Profile Details
                    </button>
                </form>
            </div>

            <div class="col-lg-1 d-none d-lg-block">
                <div class="vr h-100 opacity-10"></div>
            </div>

            <div class="col-lg-5">
                <h5 class="sub-title"><i class="fas fa-shield-alt me-2 text-warning"></i>Security Setting</h5>
                <form action="{{ route('ce.profile.password') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="info-label">Current Password</label>
                        <div class="input-group">
                            <input type="password" name="old_password" id="old_password" class="form-control" required>
                            <span class="input-group-text border" onclick="togglePassword('old_password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="info-label">New Password</label>
                        <div class="input-group">
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                            <span class="input-group-text border" onclick="togglePassword('new_password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="info-label">Confirm New Password</label>
                        <div class="input-group">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                            <span class="input-group-text border" onclick="togglePassword('new_password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <button class="btn btn-modern btn-change-password w-100">
                        <i class="fas fa-key me-2"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
function togglePassword(inputId, el) {
    const input = document.getElementById(inputId);
    const icon = el.querySelector('i');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Live Image Preview (Bonus biar makin modern)
function previewFile(input){
    var file = $("input[name=profile_photo]").get(0).files[0];
    if(file){
        var reader = new FileReader();
        reader.onload = function(){
            $("#previewImg").attr("src", reader.result);
        }
        reader.readAsDataURL(file);
    }
}
</script>

@endsection