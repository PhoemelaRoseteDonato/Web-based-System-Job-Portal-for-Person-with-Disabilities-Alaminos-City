@extends('layouts.admin')

@section('title', 'Security Report - Admin Dashboard')

@section('page-title', 'Security Report')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Header with Export Options -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">
                        <i class="fas fa-shield-alt text-success me-2"></i>
                        Security Analysis Report
                    </h1>
                    <p class="text-muted mb-0">
                        <i class="fas fa-clock me-1"></i>
                        Generated: {{ now()->format('F d, Y h:i A') }}
                    </p>
                </div>
                <div class="btn-group">
                    <button class="btn btn-outline-success" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Print Report
                    </button>
                    <button class="btn btn-outline-primary" onclick="exportToCSV()">
                        <i class="fas fa-file-csv me-1"></i> Export CSV
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <!-- Security Overview Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-primary h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 small">Total Users</p>
                                    <h2 class="mb-0 text-primary">{{ $securityStats['total_users'] ?? 0 }}</h2>
                                    <small class="text-muted">
                                        <i class="fas fa-user-check text-success"></i> {{ $securityStats['active_users'] ?? 0 }} Active
                                    </small>
                                </div>
                                <div class="text-primary">
                                    <i class="fas fa-users fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-success h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 small">Strong Passwords</p>
                                    <h2 class="mb-0 text-success">{{ $securityStats['users_with_strong_passwords'] ?? 0 }}</h2>
                                    <small class="text-muted">
                                        @php
                                            $passwordPercentage = $securityStats['total_users'] > 0 
                                                ? round(($securityStats['users_with_strong_passwords'] / $securityStats['total_users']) * 100) 
                                                : 0;
                                        @endphp
                                        {{ $passwordPercentage }}% of all users
                                    </small>
                                </div>
                                <div class="text-success">
                                    <i class="fas fa-lock fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-info h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 small">2FA Enabled</p>
                                    <h2 class="mb-0 text-info">{{ $securityStats['users_with_2fa'] ?? 0 }}</h2>
                                    <small class="text-muted">
                                        @php
                                            $twoFAPercentage = $securityStats['total_users'] > 0 
                                                ? round(($securityStats['users_with_2fa'] / $securityStats['total_users']) * 100) 
                                                : 0;
                                        @endphp
                                        {{ $twoFAPercentage }}% adoption rate
                                    </small>
                                </div>
                                <div class="text-info">
                                    <i class="fas fa-mobile-alt fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card border-warning h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="text-muted mb-1 small">At-Risk Users</p>
                                    <h2 class="mb-0 text-warning">{{ $securityStats['high_risk_users'] ?? 0 }}</h2>
                                    <small class="text-danger">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $securityStats['locked_accounts'] ?? 0 }} Locked
                                    </small>
                                </div>
                                <div class="text-warning">
                                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Role Breakdown -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-universal-access text-primary me-2"></i>
                                PWD Users Security
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Total PWD Users:</span>
                                <strong class="text-primary">{{ $securityStats['pwd_users'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Strong Passwords:</span>
                                <strong class="text-success">{{ $roleSecurityBreakdown['pwd']['strong_passwords'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">With 2FA:</span>
                                <strong class="text-info">{{ $roleSecurityBreakdown['pwd']['with_2fa'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">At Risk:</span>
                                <strong class="text-warning">{{ $roleSecurityBreakdown['pwd']['at_risk'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-building text-info me-2"></i>
                                Employer Security
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Total Employers:</span>
                                <strong class="text-primary">{{ $securityStats['employer_users'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Strong Passwords:</span>
                                <strong class="text-success">{{ $roleSecurityBreakdown['employer']['strong_passwords'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">With 2FA:</span>
                                <strong class="text-info">{{ $roleSecurityBreakdown['employer']['with_2fa'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">At Risk:</span>
                                <strong class="text-warning">{{ $roleSecurityBreakdown['employer']['at_risk'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-user-shield text-success me-2"></i>
                                Admin Security
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Total Admins:</span>
                                <strong class="text-primary">{{ $securityStats['admin_users'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Strong Passwords:</span>
                                <strong class="text-success">{{ $roleSecurityBreakdown['admin']['strong_passwords'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">With 2FA:</span>
                                <strong class="text-info">{{ $roleSecurityBreakdown['admin']['with_2fa'] ?? 0 }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">At Risk:</span>
                                <strong class="text-warning">{{ $roleSecurityBreakdown['admin']['at_risk'] ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Health Score & Activity -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-heartbeat text-danger me-2"></i>
                                Overall Security Health
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            @php
                                $totalUsers = $securityStats['total_users'] ?? 1;
                                $strongPasswords = $securityStats['users_with_strong_passwords'] ?? 0;
                                $with2FA = $securityStats['users_with_2fa'] ?? 0;
                                $lockedAccounts = $securityStats['locked_accounts'] ?? 0;

                                $healthScore = round(
                                    (($strongPasswords / $totalUsers) * 40) +
                                    (($with2FA / $totalUsers) * 40) +
                                    ((($totalUsers - $lockedAccounts) / $totalUsers) * 20)
                                );
                                $healthClass = $healthScore >= 80 ? 'text-success' : ($healthScore >= 60 ? 'text-warning' : 'text-danger');
                                $healthIcon = $healthScore >= 80 ? 'fa-check-circle' : ($healthScore >= 60 ? 'fa-exclamation-circle' : 'fa-times-circle');
                            @endphp
                            <div class="mb-3">
                                <i class="fas {{ $healthIcon }} {{ $healthClass }}" style="font-size: 3rem;"></i>
                            </div>
                            <h1 class="{{ $healthClass }} mb-2">{{ $healthScore }}%</h1>
                            <p class="text-muted mb-0">System Security Score</p>
                            <hr>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar @if($healthScore >= 80) bg-success @elseif($healthScore >= 60) bg-warning @else bg-danger @endif" 
                                     role="progressbar" 
                                     style="width: {{ $healthScore }}%" 
                                     aria-valuenow="{{ $healthScore }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-line text-primary me-2"></i>
                                Login Activity
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <small class="text-muted d-block">Last 24 Hours</small>
                                    <h4 class="mb-0 text-primary">{{ $securityStats['recent_logins_24h'] ?? 0 }}</h4>
                                </div>
                                <i class="fas fa-clock fa-2x text-primary opacity-50"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <small class="text-muted d-block">Last 7 Days</small>
                                    <h4 class="mb-0 text-info">{{ $securityStats['recent_logins_7d'] ?? 0 }}</h4>
                                </div>
                                <i class="fas fa-calendar-week fa-2x text-info opacity-50"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block">Never Logged In</small>
                                    <h4 class="mb-0 text-warning">{{ $securityStats['never_logged_in'] ?? 0 }}</h4>
                                </div>
                                <i class="fas fa-user-clock fa-2x text-warning opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-danger">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-shield-alt me-2"></i>
                                Critical Issues
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-danger mb-2" role="alert">
                                <strong>{{ $securityStats['locked_accounts'] ?? 0 }}</strong> Locked Accounts
                            </div>
                            <div class="alert alert-warning mb-2" role="alert">
                                <strong>{{ $securityStats['expired_passwords'] ?? 0 }}</strong> Expired Passwords
                            </div>
                            <div class="alert alert-info mb-0" role="alert">
                                <strong>{{ $securityStats['inactive_users'] ?? 0 }}</strong> Inactive Users
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- At-Risk Users Table -->
            <div class="card border-warning mb-4">
                <div class="card-header bg-warning bg-opacity-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                High-Risk Users
                            </h5>
                            <small class="text-muted">Users requiring immediate security attention ({{ count($riskUsers) }} found)</small>
                        </div>
                        <span class="badge bg-warning text-dark fs-6">
                            {{ count($riskUsers) }} at risk
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($riskUsers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;" class="text-center">Risk</th>
                                        <th style="width: 20%;">User</th>
                                        <th style="width: 20%;">Email</th>
                                        <th style="width: 10%;">Role</th>
                                        <th style="width: 25%;">Security Issues</th>
                                        <th style="width: 10%;">Last Login</th>
                                        <th style="width: 10%;" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riskUsers as $user)
                                        @php
                                            $riskLevel = $user->security_score >= 60 ? 'high' : ($user->security_score >= 30 ? 'critical' : 'severe');
                                            $riskColor = $user->security_score >= 60 ? 'warning' : ($user->security_score >= 30 ? 'danger' : 'dark');
                                            $riskIcon = $user->security_score >= 60 ? 'fa-exclamation-triangle' : ($user->security_score >= 30 ? 'fa-exclamation-circle' : 'fa-skull-crossbones');
                                        @endphp
                                        <tr class="border-start border-{{ $riskColor }} border-3">
                                            <td class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <i class="fas {{ $riskIcon }} text-{{ $riskColor }} fa-lg"></i>
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-{{ $riskColor }}" 
                                                          style="font-size: 0.6rem;">
                                                        {{ $user->security_score }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ $user->name }}</strong>
                                                @if($user->locked_until && $user->locked_until > now())
                                                    <br><small class="text-danger"><i class="fas fa-lock"></i> Locked</small>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $user->email }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $roleBadgeColor = match($user->role) {
                                                        'admin' => 'danger',
                                                        'employer' => 'info',
                                                        'pwd' => 'primary',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $roleBadgeColor }}">{{ strtoupper($user->role) }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($user->security_issues as $issue)
                                                        @php
                                                            $issueBadge = match($issue) {
                                                                'weak_password' => ['text' => 'Weak Password', 'color' => 'danger', 'icon' => 'fa-key'],
                                                                'no_2fa' => ['text' => 'No 2FA', 'color' => 'warning', 'icon' => 'fa-shield-alt'],
                                                                'failed_logins' => ['text' => 'Failed Logins', 'color' => 'danger', 'icon' => 'fa-times-circle'],
                                                                'locked' => ['text' => 'Locked', 'color' => 'dark', 'icon' => 'fa-lock'],
                                                                'expired_password' => ['text' => 'Password Expired', 'color' => 'warning', 'icon' => 'fa-clock'],
                                                                default => ['text' => $issue, 'color' => 'secondary', 'icon' => 'fa-exclamation']
                                                            };
                                                        @endphp
                                                        <span class="badge bg-{{ $issueBadge['color'] }} text-white" style="font-size: 0.7rem;">
                                                            <i class="fas {{ $issueBadge['icon'] }}"></i>
                                                            {{ $issueBadge['text'] }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                @if($user->last_login_at)
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $user->last_login_at->diffForHumans() }}
                                                    </small>
                                                @else
                                                    <span class="badge bg-secondary">Never</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="View User Details">
                                                    <i class="fas fa-eye me-1"></i>
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-shield-check fa-4x text-success mb-3" style="opacity: 0.3;"></i>
                                <h5 class="text-success mb-2">Excellent Security Status!</h5>
                                <p class="text-muted mb-0">No high-risk users detected in the system.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Security Recommendations -->
            <div class="card border-info">
                <div class="card-header bg-info bg-opacity-10">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-lightbulb text-info me-2"></i>
                        Security Recommendations
                    </h5>
                    <small class="text-muted">Actionable steps to improve system security</small>
                </div>
                <div class="card-body">
                    @php
                        $hasRecommendations = false;
                    @endphp

                    @if(($securityStats['users_with_strong_passwords'] ?? 0) < ($securityStats['total_users'] ?? 1))
                        @php $hasRecommendations = true; @endphp
                        <div class="alert alert-warning border-warning d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-key fa-2x text-warning me-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2">Strengthen Password Security</h6>
                                <p class="mb-2">
                                    <strong>{{ $securityStats['total_users'] - $securityStats['users_with_strong_passwords'] }}</strong> users need to update their passwords to meet current security standards.
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Recommendation: Send email notifications to affected users and enforce password change at next login.
                                </small>
                            </div>
                        </div>
                    @endif

                    @if(($securityStats['users_with_2fa'] ?? 0) < ($securityStats['total_users'] ?? 1))
                        @php $hasRecommendations = true; @endphp
                        <div class="alert alert-info border-info d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-shield-alt fa-2x text-info me-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2">Promote Two-Factor Authentication</h6>
                                <p class="mb-2">
                                    <strong>{{ $securityStats['total_users'] - $securityStats['users_with_2fa'] }}</strong> users ({{ round((($securityStats['total_users'] - $securityStats['users_with_2fa']) / $securityStats['total_users']) * 100) }}%) haven't enabled 2FA.
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Recommendation: Launch a security awareness campaign highlighting 2FA benefits.
                                </small>
                            </div>
                        </div>
                    @endif

                    @if(($securityStats['locked_accounts'] ?? 0) > 0)
                        @php $hasRecommendations = true; @endphp
                        <div class="alert alert-danger border-danger d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-lock fa-2x text-danger me-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2">Review Locked Accounts</h6>
                                <p class="mb-2">
                                    <strong>{{ $securityStats['locked_accounts'] }}</strong> account(s) are currently locked due to security measures.
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Recommendation: Review each locked account to verify legitimacy before unlocking.
                                </small>
                            </div>
                        </div>
                    @endif

                    @if(($securityStats['expired_passwords'] ?? 0) > 0)
                        @php $hasRecommendations = true; @endphp
                        <div class="alert alert-warning border-warning d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock fa-2x text-warning me-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2">Address Expired Passwords</h6>
                                <p class="mb-2">
                                    <strong>{{ $securityStats['expired_passwords'] }}</strong> user(s) have passwords older than 90 days.
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Recommendation: Force password reset for these accounts to maintain security hygiene.
                                </small>
                            </div>
                        </div>
                    @endif

                    @if(count($riskUsers) > 0)
                        @php $hasRecommendations = true; @endphp
                        <div class="alert alert-danger border-danger d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-shield fa-2x text-danger me-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2">Immediate Action Required</h6>
                                <p class="mb-2">
                                    <strong>{{ count($riskUsers) }}</strong> high-risk user(s) identified requiring immediate security intervention.
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Recommendation: Review the at-risk users table above and take corrective actions.
                                </small>
                            </div>
                        </div>
                    @endif

                    @if(($securityStats['never_logged_in'] ?? 0) > 0)
                        @php $hasRecommendations = true; @endphp
                        <div class="alert alert-secondary border-secondary d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-clock fa-2x text-secondary me-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading mb-2">Inactive Account Review</h6>
                                <p class="mb-2">
                                    <strong>{{ $securityStats['never_logged_in'] }}</strong> account(s) have never logged in.
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Recommendation: Send account activation reminders or consider account cleanup after 30 days.
                                </small>
                            </div>
                        </div>
                    @endif

                    @if(!$hasRecommendations)
                        <div class="text-center py-4">
                            <i class="fas fa-thumbs-up fa-3x text-success mb-3" style="opacity: 0.3;"></i>
                            <h5 class="text-success mb-2">Outstanding Security Posture!</h5>
                            <p class="text-muted mb-0">No critical security recommendations at this time. Continue monitoring.</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-light">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        <strong>Note:</strong> Security report generated on {{ now()->format('F d, Y h:i A') }}. 
                        Regular security audits are recommended weekly.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Print functionality
    document.querySelector('.btn-outline-secondary[onclick*="print"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        window.print();
    });

    // CSV Export functionality
    document.querySelector('.btn-outline-success[onclick*="exportCSV"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        exportSecurityReportToCSV();
    });

    function exportSecurityReportToCSV() {
        const csvData = [];
        
        // Headers
        csvData.push(['PWD Security Report - Generated on {{ now()->format("Y-m-d H:i:s") }}']);
        csvData.push([]);
        
        // Overall Statistics
        csvData.push(['Overall Statistics']);
        csvData.push(['Metric', 'Value']);
        csvData.push(['Total Users', '{{ $securityStats["total_users"] ?? 0 }}']);
        csvData.push(['Strong Passwords', '{{ $securityStats["users_with_strong_passwords"] ?? 0 }}']);
        csvData.push(['Users with 2FA', '{{ $securityStats["users_with_2fa"] ?? 0 }}']);
        csvData.push(['Active Users', '{{ $securityStats["active_users"] ?? 0 }}']);
        csvData.push(['Locked Accounts', '{{ $securityStats["locked_accounts"] ?? 0 }}']);
        csvData.push(['Expired Passwords', '{{ $securityStats["expired_passwords"] ?? 0 }}']);
        csvData.push([]);
        
        // Role Breakdown
        csvData.push(['User Role Breakdown']);
        csvData.push(['Role', 'Total', 'Strong Passwords', 'With 2FA', 'At Risk']);
        csvData.push([
            'PWD Users',
            '{{ $securityStats["pwd_users"] ?? 0 }}',
            '{{ $roleSecurityBreakdown["pwd"]["strong_passwords"] ?? 0 }}',
            '{{ $roleSecurityBreakdown["pwd"]["with_2fa"] ?? 0 }}',
            '{{ $roleSecurityBreakdown["pwd"]["at_risk"] ?? 0 }}'
        ]);
        csvData.push([
            'Employers',
            '{{ $securityStats["employer_users"] ?? 0 }}',
            '{{ $roleSecurityBreakdown["employer"]["strong_passwords"] ?? 0 }}',
            '{{ $roleSecurityBreakdown["employer"]["with_2fa"] ?? 0 }}',
            '{{ $roleSecurityBreakdown["employer"]["at_risk"] ?? 0 }}'
        ]);
        csvData.push([
            'Admins',
            '{{ $securityStats["admin_users"] ?? 0 }}',
            '{{ $roleSecurityBreakdown["admin"]["strong_passwords"] ?? 0 }}',
            '{{ $roleSecurityBreakdown["admin"]["with_2fa"] ?? 0 }}',
            '{{ $roleSecurityBreakdown["admin"]["at_risk"] ?? 0 }}'
        ]);
        csvData.push([]);
        
        // High-Risk Users
        @if(count($riskUsers) > 0)
        csvData.push(['High-Risk Users']);
        csvData.push(['User ID', 'Name', 'Email', 'Role', 'Security Score', 'Issues', 'Last Login']);
        @foreach($riskUsers as $user)
        csvData.push([
            '{{ $user->id }}',
            '{{ addslashes($user->name) }}',
            '{{ $user->email }}',
            '{{ strtoupper($user->role) }}',
            '{{ $user->security_score }}',
            '{{ implode(", ", array_map(function($issue) { return str_replace("_", " ", ucfirst($issue)); }, $user->security_issues)) }}',
            '{{ $user->last_login_at ? $user->last_login_at->format("Y-m-d H:i:s") : "Never" }}'
        ]);
        @endforeach
        @endif
        
        // Convert to CSV string
        const csvContent = csvData.map(row => 
            row.map(cell => {
                // Escape quotes and wrap in quotes if contains comma
                const cellStr = String(cell);
                if (cellStr.includes(',') || cellStr.includes('"') || cellStr.includes('\n')) {
                    return '"' + cellStr.replace(/"/g, '""') + '"';
                }
                return cellStr;
            }).join(',')
        ).join('\n');
        
        // Create download link
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        
        link.setAttribute('href', url);
        link.setAttribute('download', 'security_report_{{ now()->format("Y-m-d_His") }}.csv');
        link.style.visibility = 'hidden';
        
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Show success message
        alert('Security report exported successfully!');
    }
</script>

<style>
    @media print {
        .sidebar, .navbar, .btn, .breadcrumb {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 20px !important;
        }
        .card {
            break-inside: avoid;
            page-break-inside: avoid;
        }
        .table {
            font-size: 10px;
        }
    }
</style>
@endpush

@endsection
