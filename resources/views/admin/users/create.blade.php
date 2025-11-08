@extends('layouts.admin')

@section('title', 'Create New User - Admin Panel')

@section('page-title', 'Create New User')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus"></i> Create New User Account
        </h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Users
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle"></i> Validation Errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> User Account Information
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <!-- Basic Information -->
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-user"></i> Basic Information
                            </h5>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required
                                       placeholder="Enter full name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required
                                       placeholder="Enter email address">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    This email will be used for login and notifications.
                                </small>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    Phone Number <span class="text-muted">(Optional)</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       placeholder="Enter phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Account Details -->
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-lock"></i> Account Security
                            </h5>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required
                                       minlength="8"
                                       placeholder="Enter password (min. 8 characters)">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Password must be at least 8 characters long.
                                </small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required
                                       minlength="8"
                                       placeholder="Re-enter password">
                            </div>
                        </div>

                        <!-- Role & Status -->
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">
                                <i class="fas fa-user-tag"></i> Role & Status
                            </h5>

                            <!-- Role -->
                            <div class="mb-3">
                                <label for="role" class="form-label">
                                    User Role <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('role') is-invalid @enderror" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="">Select a role...</option>
                                    <option value="pwd" {{ old('role') == 'pwd' ? 'selected' : '' }}>
                                        PWD (Person with Disability)
                                    </option>
                                    <option value="employer" {{ old('role') == 'employer' ? 'selected' : '' }}>
                                        Employer
                                    </option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                        Administrator
                                    </option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    <strong>PWD:</strong> Access to job applications and training enrollments<br>
                                    <strong>Employer:</strong> Can post jobs and manage applications<br>
                                    <strong>Admin:</strong> Full system access and management capabilities
                                </small>
                            </div>

                            <!-- Active Status -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="is_active" 
                                           name="is_active" 
                                           value="1"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        <strong>Active Account</strong>
                                        <span class="text-muted d-block">User can login and access the system</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Email will be automatically verified</li>
                                <li>User will be able to login immediately after creation</li>
                                <li>User can change their password after first login</li>
                                <li>You can deactivate or delete the account anytime from the user management page</li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Create User Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent

    <script>
        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strengthText = document.getElementById('passwordStrength');
        
        if (!strengthText) {
            const newDiv = document.createElement('div');
            newDiv.id = 'passwordStrength';
            newDiv.className = 'form-text';
            this.parentNode.appendChild(newDiv);
        }
        
        let strength = 'Weak';
        let color = 'text-danger';
        
        if (password.length >= 8) {
            strength = 'Fair';
            color = 'text-warning';
        }
        if (password.length >= 12 && /[A-Z]/.test(password) && /[0-9]/.test(password)) {
            strength = 'Good';
            color = 'text-info';
        }
        if (password.length >= 16 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
            strength = 'Strong';
            color = 'text-success';
        }
        
        document.getElementById('passwordStrength').innerHTML = `<strong class="${color}">Password Strength: ${strength}</strong>`;
    });

    // Confirm password match validation
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        
        if (confirmPassword && password !== confirmPassword) {
            this.setCustomValidity('Passwords do not match');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
</script>
@endsection
