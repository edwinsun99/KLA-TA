@extends('master.layout.app')

@section('title', 'Manage Users')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-purple: #6366f1;
        --secondary-purple: #818cf8;
        --accent-yellow: #fbbf24;
        --bg-glass: rgba(255, 255, 255, 0.7);
        --border-glass: rgba(255, 255, 255, 0.4);
    }

    body {
        background: linear-gradient(135deg, #f0f4ff 0%, #e5e7eb 100%);
        font-family: 'Inter', sans-serif;
        color: #1f2937;
        min-height: 100vh;
    }

    h4 { 
        font-weight: 700; 
        letter-spacing: -0.02em;
        color: #4338ca;
    }

    /* Glassmorphism Card Style */
    .card-glass {
        background: var(--bg-glass);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--border-glass);
        border-radius: 24px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-purple), var(--secondary-purple));
        border: none;
        border-radius: 12px;
        padding: 10px 22px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        color: white;
    }

    /* Table Design */
    .table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table thead th {
        border: none;
        color: #6b7280;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 15px;
    }

    .table tbody tr {
        background: white;
        transition: all 0.2s ease;
    }

    .table tbody tr td {
        border: none;
        padding: 18px 15px;
    }

    .table tbody tr td:first-child { border-radius: 14px 0 0 14px; }
    .table tbody tr td:last-child { border-radius: 0 14px 14px 0; }

    .table tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    }

    /* Badge Design - Warna Berbeda Per Role */
    .badge-role {
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.72rem;
        display: inline-block;
    }
    
    .bg-master { background-color: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe; } /* Ungu */
    .bg-ce { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }     /* Kuning */
    .bg-cm { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }     /* Hijau */
    .bg-cs { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }     /* Biru Muda */

    /* Fix Modal Crop Issues */
    .modal-dialog-centered {
        display: flex;
        align-items: center;
        min-height: calc(100% - 1rem);
    }

    .modal-content-glass {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 28px;
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }

    .modal-header { padding: 1.8rem 2rem 1rem !important; }
    .modal-body { padding: 1rem 2rem 1.5rem !important; }
    .modal-footer { padding: 1rem 2rem 2rem !important; gap: 12px; }

    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 12px 16px;
        background-color: #f9fafb;
        transition: all 0.2s;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: var(--primary-purple);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .input-group-text-custom {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-left: none;
        border-radius: 0 12px 12px 0;
        cursor: pointer;
    }
</style>

<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h4 class="mb-1">Manage Users</h4>
            <p class="text-muted mb-0">Kelola akun pengguna dan role dalam sistem.</p>
        </div>
    
        <button class="btn btn-primary-custom shadow-sm" data-bs-toggle="modal" data-bs-target="#addRoleModal">
            <i class="bi bi-plus-lg me-2"></i> Add New User
        </button>
    </div>

    <div class="card card-glass border-0">
        <div class="card-body p-4">
            @if ($users->count())
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="80">No</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Cabang</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                            <tr>
                                <td class="text-muted fw-medium">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; border: 1px solid #eee; background: white !important;">
                                            <span class="text-primary fw-bold">{{ strtoupper(substr($user->username, 0, 1)) }}</span>
                                        </div>
                                        <span class="fw-bold">{{ $user->username }}</span>
                                    </div>
                                </td>
                                <td class="text-secondary">{{ $user->email }}</td>
                                <td>
                                    @php
                                        // Penentuan class warna berdasarkan role
                                        $roleClass = 'bg-light';
                                        if($user->role == 'MASTER') $roleClass = 'bg-master';
                                        elseif($user->role == 'CE') $roleClass = 'bg-ce';
                                        elseif($user->role == 'CM') $roleClass = 'bg-cm';
                                        elseif($user->role == 'CS') $roleClass = 'bg-cs';
                                    @endphp
                                    <span class="badge-role {{ $roleClass }}">
                                        {{ $user->role }}
                                    </span>

                                    <td>
    @if($user->branch)
        {{ $user->branch->name }}
    @else
        Pusat
    @endif
</td>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" 
                                            class="btn btn-sm btn-light rounded-3 text-primary border"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editRoleModal{{ $user->id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>

                                        <form action="{{ route('roles.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-light rounded-3 text-danger border"
                                                    onclick="return confirm('Yakin ingin menghapus role ini?')">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076505.png" width="80" class="mb-3 opacity-25">
                    <h6 class="text-muted">No roles found in the database.</h6>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-glass">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="e.g. johndoe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="name@company.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Security Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="addPw" class="form-control" required>
                            <span class="input-group-text input-group-text-custom togglePassword" data-target="addPw">
                                <i class="bi bi-eye text-muted"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Assign Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            <option value="CS">Customer Service</option>
                            <option value="CE">Customer Engineer</option>
                        </select>
                    </div>

                      <div class="mb-3">
    <label class="form-label small fw-bold text-secondary text-uppercase">Branch</label>
    <select name="branch_id" class="form-select" required>
        <option value="">-- Pilih Cabang --</option>
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}">
                {{ $branch->name }}
            </option>
        @endforeach
    </select>
</div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom px-4">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($users as $user)
<div class="modal fade" id="editRoleModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-glass">
            <form action="{{ route('roles.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Update Username</label>
                        <input type="text" name="new_username" class="form-control" value="{{ $user->username }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Old Password</label>
                        <div class="input-group">
                            <input type="password" name="old_password" id="oldPw{{ $user->id }}" class="form-control">
                            <span class="input-group-text input-group-text-custom togglePassword" data-target="oldPw{{ $user->id }}">
                                <i class="bi bi-eye text-muted"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-secondary text-uppercase">New Password (optional)</label>
                        <div class="input-group">
                            <input type="password" name="new_password" id="newPw{{ $user->id }}" class="form-control">
                            <span class="input-group-text input-group-text-custom togglePassword" data-target="newPw{{ $user->id }}">
                                <i class="bi bi-eye text-muted"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom px-4">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".togglePassword").forEach(btn => {
        btn.addEventListener("click", function () {
            const targetId = this.getAttribute("data-target");
            const target = document.getElementById(targetId);
            const icon = this.querySelector("i");
            
            if (target.type === "password") {
                target.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                target.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        });
    });
});
</script>

@endsection