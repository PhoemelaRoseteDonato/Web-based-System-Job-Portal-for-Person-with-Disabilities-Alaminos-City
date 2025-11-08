@extends('layouts.admin')

@section('title', 'System Statistics - Admin Panel')

@section('page-title', 'System Statistics')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-bar"></i> System Statistics & Analytics
        </h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- User Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-users"></i> User Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-primary h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $userStats['total_users'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-info h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">PWD Users</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $userStats['pwd_users'] }}</div>
                                    <small class="text-muted">{{ $userStats['pwd_percentage'] }}%</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-success h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Employers</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $userStats['employer_users'] }}</div>
                                    <small class="text-muted">{{ $userStats['verified_employers'] }} verified</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-warning h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Admin Users</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $userStats['admin_users'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4 mb-3">
                            <div class="card border-left-success h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Users</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $userStats['active_users'] }}</div>
                                    <small class="text-muted">{{ $userStats['active_percentage'] }}%</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-left-danger h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Locked Users</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $userStats['locked_users'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card border-left-info h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">2FA Enabled</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $userStats['two_factor_users'] }}</div>
                                    <small class="text-muted">{{ $userStats['two_factor_percentage'] }}%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-file-alt"></i> Job Application Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-primary h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Applications</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $applicationStats['total'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-warning h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $applicationStats['pending'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-success h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Approved</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $applicationStats['approved'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-danger h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Rejected</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $applicationStats['rejected'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Training Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> Training Enrollment Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-primary h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Enrollments</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $trainingStats['total_enrollments'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-info h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Enrolled</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $trainingStats['enrolled'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-success h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $trainingStats['completed'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-left-danger h-100">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Cancelled</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $trainingStats['cancelled'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visual Charts Row 1 -->
    <div class="row mb-4">
        <!-- User Distribution Pie Chart -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> User Distribution by Role</h5>
                </div>
                <div class="card-body">
                    <canvas id="userDistributionChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Application Status Doughnut Chart -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Application Status Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="applicationStatusChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Visual Charts Row 2 -->
    <div class="row mb-4">
        <!-- User Activity Bar Chart -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar"></i> User Activity Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="userActivityChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Training Enrollment Progress -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Training Enrollment Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="trainingStatusChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Trends -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> Registration Trends (Last 30 Days)</h5>
                </div>
                <div class="card-body">
                    <canvas id="registrationChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Summary Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-table"></i> Detailed Statistics Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Category</th>
                                    <th>Metric</th>
                                    <th class="text-center">Count</th>
                                    <th class="text-center">Percentage</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td rowspan="4" class="align-middle"><strong>Users by Role</strong></td>
                                    <td>PWD Users</td>
                                    <td class="text-center">{{ $userStats['pwd_users'] }}</td>
                                    <td class="text-center">{{ $userStats['pwd_percentage'] }}%</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: {{ $userStats['pwd_percentage'] }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Employers</td>
                                    <td class="text-center">{{ $userStats['employer_users'] }}</td>
                                    <td class="text-center">{{ $userStats['employer_percentage'] }}%</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: {{ $userStats['employer_percentage'] }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Administrators</td>
                                    <td class="text-center">{{ $userStats['admin_users'] }}</td>
                                    <td class="text-center">{{ $userStats['admin_percentage'] }}%</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: {{ $userStats['admin_percentage'] }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Total Users</strong></td>
                                    <td class="text-center"><strong>{{ $userStats['total_users'] }}</strong></td>
                                    <td class="text-center">100%</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="3" class="align-middle"><strong>User Activity</strong></td>
                                    <td>Active Users</td>
                                    <td class="text-center">{{ $userStats['active_users'] }}</td>
                                    <td class="text-center">{{ $userStats['active_percentage'] }}%</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: {{ $userStats['active_percentage'] }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Locked Users</td>
                                    <td class="text-center">{{ $userStats['locked_users'] }}</td>
                                    <td class="text-center">{{ $userStats['total_users'] > 0 ? round(($userStats['locked_users'] / $userStats['total_users']) * 100, 2) : 0 }}%</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-danger" style="width: {{ $userStats['total_users'] > 0 ? round(($userStats['locked_users'] / $userStats['total_users']) * 100, 2) : 0 }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2FA Enabled</td>
                                    <td class="text-center">{{ $userStats['two_factor_users'] }}</td>
                                    <td class="text-center">{{ $userStats['two_factor_percentage'] }}%</td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: {{ $userStats['two_factor_percentage'] }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Chart.js global configuration
    Chart.defaults.font.family = "'Segoe UI', 'Helvetica Neue', 'Arial', sans-serif";
    Chart.defaults.plugins.legend.labels.usePointStyle = true;

    // User Distribution Pie Chart
    const userDistCtx = document.getElementById('userDistributionChart').getContext('2d');
    new Chart(userDistCtx, {
        type: 'pie',
        data: {
            labels: ['PWD Users', 'Employers', 'Administrators'],
            datasets: [{
                data: [
                    {{ $userStats['pwd_users'] }},
                    {{ $userStats['employer_users'] }},
                    {{ $userStats['admin_users'] }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 206, 86, 0.8)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Application Status Doughnut Chart
    const appStatusCtx = document.getElementById('applicationStatusChart').getContext('2d');
    new Chart(appStatusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Approved', 'Rejected'],
            datasets: [{
                data: [
                    {{ $applicationStats['pending'] }},
                    {{ $applicationStats['approved'] }},
                    {{ $applicationStats['rejected'] }}
                ],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ],
                borderColor: [
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // User Activity Bar Chart
    const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
    new Chart(userActivityCtx, {
        type: 'bar',
        data: {
            labels: ['Active', 'Inactive', 'Locked', '2FA Enabled'],
            datasets: [{
                label: 'User Count',
                data: [
                    {{ $userStats['active_users'] }},
                    {{ $userStats['inactive_users'] }},
                    {{ $userStats['locked_users'] }},
                    {{ $userStats['two_factor_users'] }}
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(201, 203, 207, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(201, 203, 207, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed.y + ' users';
                        }
                    }
                }
            }
        }
    });

    // Training Status Bar Chart
    const trainingStatusCtx = document.getElementById('trainingStatusChart').getContext('2d');
    new Chart(trainingStatusCtx, {
        type: 'bar',
        data: {
            labels: ['Enrolled', 'Completed', 'Cancelled'],
            datasets: [{
                label: 'Enrollment Count',
                data: [
                    {{ $trainingStats['enrolled'] }},
                    {{ $trainingStats['completed'] }},
                    {{ $trainingStats['cancelled'] }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed.y + ' enrollments';
                        }
                    }
                }
            }
        }
    });

    // Registration Trends Line Chart
    const registrationData = @json($registrationTrends);
    const dates = registrationData.labels || [];
    const counts = registrationData.data || [];

    const regTrendsCtx = document.getElementById('registrationChart').getContext('2d');
    new Chart(regTrendsCtx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'New Registrations',
                data: counts,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: 'rgb(75, 192, 192)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return 'Registrations: ' + context.parsed.y;
                        }
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
</script>
@endsection
