@extends('employer.layouts.employer')

@section('title', 'Welcome to PWD Job Portal')

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-gradient-primary text-white">
                <div class="card-body py-5">
                    <div class="text-center">
                        <i class="fas fa-building fa-4x mb-3 opacity-75"></i>
                        <h1 class="display-4 fw-bold mb-3">Welcome to PWD Job Portal!</h1>
                        <p class="lead mb-4">Thank you for registering as an employer. Let's get your account set up.</p>
                        <div class="d-inline-block bg-white text-dark px-4 py-2 rounded">
                            <strong>Account Status:</strong>
                            <span class="badge bg-warning text-dark ms-2">Setup Required</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Setup Progress -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-tasks text-primary"></i> Account Setup Progress</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Profile Completion</span>
                            <strong>{{ $profileCompletion ?? 0 }}%</strong>
                        </div>
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-{{ $profileCompletion >= 70 ? 'success' : 'warning' }}"
                                 role="progressbar"
                                 style="width: {{ $profileCompletion ?? 0 }}%"
                                 aria-valuenow="{{ $profileCompletion ?? 0 }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                                {{ $profileCompletion ?? 0 }}%
                            </div>
                        </div>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle"></i>
                            Complete at least 70% of your profile to apply for verification
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Setup Steps -->
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4"><i class="fas fa-list-ol text-primary"></i> Getting Started</h4>
        </div>

        <!-- Step 1: Complete Profile -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-left-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                             style="width: 50px; height: 50px; flex-shrink: 0;">
                            <strong>1</strong>
                        </div>
                        <h5 class="mb-0 ms-3">Complete Your Profile</h5>
                    </div>

                    <p class="text-muted mb-3">
                        Provide detailed information about your company including:
                    </p>

                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-{{ !empty($user->company_name) ? 'check-circle text-success' : 'circle text-muted' }}"></i>
                            Company Name
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-{{ !empty($user->company_size) ? 'check-circle text-success' : 'circle text-muted' }}"></i>
                            Company Size
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-{{ !empty($user->company_type) ? 'check-circle text-success' : 'circle text-muted' }}"></i>
                            Company Type
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-{{ !empty($user->website) ? 'check-circle text-success' : 'circle text-muted' }}"></i>
                            Company Website
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-{{ !empty($user->description) ? 'check-circle text-success' : 'circle text-muted' }}"></i>
                            Company Description
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-{{ !empty($user->phone) ? 'check-circle text-success' : 'circle text-muted' }}"></i>
                            Contact Phone
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-{{ !empty($user->address) ? 'check-circle text-success' : 'circle text-muted' }}"></i>
                            Business Address
                        </li>
                    </ul>

                    <div class="mt-3">
                        <a href="{{ route('employer.profile.edit') }}" class="btn btn-primary w-100">
                            <i class="fas fa-user-edit"></i>
                            {{ $profileCompletion >= 70 ? 'Review Profile' : 'Complete Profile' }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Apply for Verification -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-left-success">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle {{ $profileCompletion >= 70 ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center"
                             style="width: 50px; height: 50px; flex-shrink: 0;">
                            <strong>2</strong>
                        </div>
                        <h5 class="mb-0 ms-3">Get Verified</h5>
                    </div>

                    @if($profileCompletion >= 70)
                        <div class="alert alert-success py-2 mb-3">
                            <i class="fas fa-check-circle"></i>
                            <small>Profile complete! Ready to apply.</small>
                        </div>
                    @else
                        <div class="alert alert-warning py-2 mb-3">
                            <i class="fas fa-exclamation-triangle"></i>
                            <small>Complete your profile first</small>
                        </div>
                    @endif

                    <p class="text-muted mb-3">
                        Submit required documents for verification:
                    </p>

                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-file-alt text-primary"></i>
                            Business Registration Certificate
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-receipt text-info"></i>
                            Tax Clearance (recommended)
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-paperclip text-secondary"></i>
                            Additional documents (optional)
                        </li>
                    </ul>

                    <div class="mt-3">
                        @if($profileCompletion >= 70)
                            <a href="{{ route('employer.verification.apply') }}" class="btn btn-success w-100">
                                <i class="fas fa-shield-alt"></i> Apply for Verification
                            </a>
                        @else
                            <button class="btn btn-secondary w-100" disabled>
                                <i class="fas fa-lock"></i> Complete Profile First
                            </button>
                        @endif
                    </div>

                    <div class="mt-2">
                        <a href="{{ route('employer.verification.requirements') }}" class="btn btn-sm btn-outline-info w-100">
                            <i class="fas fa-info-circle"></i> View Requirements
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Post Jobs -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-left-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                             style="width: 50px; height: 50px; flex-shrink: 0;">
                            <strong>3</strong>
                        </div>
                        <h5 class="mb-0 ms-3">Post Job Opportunities</h5>
                    </div>

                    <div class="alert alert-info py-2 mb-3">
                        <i class="fas fa-info-circle"></i>
                        <small>Available after verification approval</small>
                    </div>

                    <p class="text-muted mb-3">
                        Once verified, you can:
                    </p>

                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Post unlimited job opportunities
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Receive applications from PWD candidates
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Manage applications efficiently
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Access analytics and insights
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success"></i>
                            Connect with qualified PWD talent
                        </li>
                    </ul>

                    <div class="mt-3">
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="fas fa-lock"></i> Requires Verification
                        </button>
                    </div>

                    <div class="mt-2">
                        <a href="{{ route('employer.job-drafts.create') }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-file-alt"></i> Create Draft (Preview)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Verification Matters -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-question-circle"></i> Why is Verification Required?</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex">
                                <div class="text-info me-3">
                                    <i class="fas fa-shield-alt fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Protect PWD Job Seekers</h6>
                                    <p class="text-muted small mb-0">
                                        Verification ensures only legitimate employers can post job opportunities,
                                        protecting PWD candidates from scams.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex">
                                <div class="text-success me-3">
                                    <i class="fas fa-check-double fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Build Trust</h6>
                                    <p class="text-muted small mb-0">
                                        Verified employers receive a badge that increases candidate trust
                                        and application rates.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex">
                                <div class="text-warning me-3">
                                    <i class="fas fa-handshake fa-2x"></i>
                                </div>
                                <div>
                                    <h6>Quality Assurance</h6>
                                    <p class="text-muted small mb-0">
                                        Our admin team reviews each application to ensure job opportunities
                                        are suitable and accessible for PWD candidates.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Help & Support -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-life-ring text-primary"></i> Need Help?</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6><i class="fas fa-book text-primary"></i> Resources</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="{{ route('employer.verification.requirements') }}" class="text-decoration-none">
                                        <i class="fas fa-arrow-right text-muted small"></i> Verification Requirements
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-arrow-right text-muted small"></i> Employer Guidelines
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-arrow-right text-muted small"></i> FAQ
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6><i class="fas fa-envelope text-primary"></i> Contact Support</h6>
                            <p class="text-muted small mb-2">
                                Have questions? Our team is here to help!
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-envelope text-muted"></i>
                                <a href="mailto:support@pwdjobportal.com">support@pwdjobportal.com</a>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-phone text-muted"></i>
                                <a href="tel:+1234567890">+1 (234) 567-890</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action Button -->
    <div class="row mt-4 mb-5">
        <div class="col-12 text-center">
            <a href="{{ route('employer.profile.edit') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-rocket"></i> Get Started - Complete Your Profile
            </a>
        </div>
    </div>
</div>

@section('styles')
<style>
    .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }
    .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }
    .border-left-warning {
        border-left: 4px solid #f6c23e !important;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>
@endsection
@endsection
