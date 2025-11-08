@extends('layouts.admin')

@section('title', 'Application Statistics')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Back to Applications
            </a>
            <h2 class="fw-bold">
                <i class="fas fa-chart-bar text-primary"></i> Application Statistics
            </h2>
            <p class="text-muted">Comprehensive overview of all job applications</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="text-center display-4 fw-bold text-primary">{{ number_format($totalApplications) }}</h3>
                    <p class="text-center text-muted mb-0">Total Applications Received</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications by Status -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-chart-pie text-primary"></i> Applications by Status
                    </h5>
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-list text-primary"></i> Status Breakdown
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Status</th>
                                    <th class="text-end">Count</th>
                                    <th class="text-end">Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applicationsByStatus as $status => $count)
                                <tr>
                                    <td>
                                        @if($status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($status == 'shortlisted')
                                            <span class="badge bg-info">Shortlisted</span>
                                        @elseif($status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @elseif($status == 'hired')
                                            <span class="badge bg-primary">Hired</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-end">{{ $count }}</td>
                                    <td class="text-end">
                                        {{ $totalApplications > 0 ? number_format(($count / $totalApplications) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Applications by Month -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-chart-line text-primary"></i> Applications Over Time (Last 12 Months)
                    </h5>
                    <canvas id="monthlyChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Jobs -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-trophy text-warning"></i> Top 10 Jobs by Applications
                    </h5>
                    @if($topJobs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th class="text-end">Applications</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topJobs as $index => $job)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if($job->jobPosting)
                                                <strong>{{ $job->jobPosting->title }}</strong>
                                            @else
                                                <em class="text-muted">Job Deleted</em>
                                            @endif
                                        </td>
                                        <td>
                                            @if($job->jobPosting)
                                                {{ $job->jobPosting->company ?? 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <span class="badge bg-primary rounded-pill">{{ $job->applications }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No job data available yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($applicationsByStatus);
    
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData).map(key => key.charAt(0).toUpperCase() + key.slice(1)),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: [
                    'rgba(255, 193, 7, 0.8)',  // pending - yellow
                    'rgba(13, 202, 240, 0.8)', // shortlisted - cyan
                    'rgba(25, 135, 84, 0.8)',  // approved - green
                    'rgba(220, 53, 69, 0.8)',  // rejected - red
                    'rgba(13, 110, 253, 0.8)', // hired - blue
                    'rgba(108, 117, 125, 0.8)' // other - gray
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($applicationsByMonth);
    
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyData.map(item => {
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return monthNames[item.month - 1] + ' ' + item.year;
            }),
            datasets: [{
                label: 'Applications',
                data: monthlyData.map(item => item.count),
                borderColor: 'rgb(13, 110, 253)',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
