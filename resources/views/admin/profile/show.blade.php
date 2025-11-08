@extends('layouts.admin')

@section('title', 'My Profile - Admin Panel')

@section('page-title', 'My Profile')

@section('content')
<div class="row">
    <!-- Left Column - Profile Info & Avatar -->
    <div class="col-lg-4">
        <!-- Avatar Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" 
                             class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #3498db;">
                    @else
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 150px; height: 150px; border: 4px solid #3498db;">
                            <i class="fas fa-user fa-4x text-white"></i>
                        </div>
                    @endif
                </div>

                <h4 class="mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-3">
                    <i class="fas fa-shield-alt me-1"></i>
                    {{ ucfirst($user->role) }}
                </p>

                <!-- Avatar Upload Form -->
                <form action="{{ route('admin.profile.update-avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    <div class="mb-3">
                        <label for="avatar" class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-camera me-2"></i>Change Avatar
                        </label>
                        <input type="file" class="d-none" id="avatar" name="avatar" accept="image/*" onchange="document.getElementById('avatarForm').submit();">
                    </div>
                </form>

                @if($user->avatar)
                    <form action="{{ route('admin.profile.remove-avatar') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger w-100" 
                                onclick="return confirm('Are you sure you want to remove your avatar?')">
                            <i class="fas fa-trash-alt me-2"></i>Remove Avatar
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Account Info Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Account Information
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Member Since</label>
                    <p class="mb-0 fw-bold">{{ $user->created_at->format('F d, Y') }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Last Login</label>
                    <p class="mb-0 fw-bold">
                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                    </p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Account Status</label>
                    <p class="mb-0">
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Active
                        </span>
                    </p>
                </div>
                <div>
                    <label class="text-muted small">Email Verified</label>
                    <p class="mb-0">
                        @if($user->email_verified_at)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Verified
                            </span>
                        @else
                            <span class="badge bg-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>Not Verified
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Forms -->
    <div class="col-lg-8">
        <!-- Personal Information Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit me-2 text-primary"></i>Personal Information
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   placeholder="+63 XXX XXX XXXX">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <input type="text" class="form-control" id="role" 
                                   value="{{ ucfirst($user->role) }}" readonly disabled>
                            <small class="text-muted">Contact another administrator to change your role.</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-lock me-2 text-primary"></i>Change Password
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update-password') }}" method="POST" id="passwordForm">
                    @csrf
                    @method('PUT')

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Password Requirements:</strong>
                        <ul class="mb-0 mt-2">
                            <li>At least 8 characters long</li>
                            <li>Must contain letters and numbers</li>
                            <li>Special characters recommended</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        
                        <!-- Password Strength Indicator -->
                        <div class="mt-2">
                            <div class="progress" style="height: 5px;">
                                <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small id="passwordStrengthText" class="text-muted"></small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small id="passwordMatch" class="text-muted"></small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning" id="changePasswordBtn">
                            <i class="fas fa-key me-2"></i>Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Activity Log Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2 text-primary"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="alert alert-light">
                    <i class="fas fa-info-circle me-2"></i>
                    Activity logging will be displayed here in future updates.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent

<script>
    console.log('>>> Admin Profile page scripts loading...');

    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = event.currentTarget.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Password strength checker
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('passwordStrengthBar');
    const strengthText = document.getElementById('passwordStrengthText');
    
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
            if (password.match(/[0-9]/)) strength += 25;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength <= 25) {
                strengthBar.className = 'progress-bar bg-danger';
                strengthText.textContent = 'Weak password';
                strengthText.className = 'text-danger small';
            } else if (strength <= 50) {
                strengthBar.className = 'progress-bar bg-warning';
                strengthText.textContent = 'Fair password';
                strengthText.className = 'text-warning small';
            } else if (strength <= 75) {
                strengthBar.className = 'progress-bar bg-info';
                strengthText.textContent = 'Good password';
                strengthText.className = 'text-info small';
            } else {
                strengthBar.className = 'progress-bar bg-success';
                strengthText.textContent = 'Strong password';
                strengthText.className = 'text-success small';
            }
        });
    }

    // Password confirmation match checker
    const confirmPassword = document.getElementById('password_confirmation');
    const passwordMatch = document.getElementById('passwordMatch');
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    
    if (confirmPassword && passwordInput) {
        confirmPassword.addEventListener('input', function() {
            if (this.value === '') {
                passwordMatch.textContent = '';
                return;
            }
            
            if (this.value === passwordInput.value) {
                passwordMatch.textContent = '✓ Passwords match';
                passwordMatch.className = 'text-success small';
                changePasswordBtn.disabled = false;
            } else {
                passwordMatch.textContent = '✗ Passwords do not match';
                passwordMatch.className = 'text-danger small';
                changePasswordBtn.disabled = true;
            }
        });
    }

    // Auto-hide success alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-success');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>

<style>
    .card {
        border: none;
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3498db, #2980b9);
        border: none;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #2980b9, #3498db);
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #f39c12, #e67e22);
        border: none;
        color: white;
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #e67e22, #f39c12);
        color: white;
    }
</style>
@endsection
