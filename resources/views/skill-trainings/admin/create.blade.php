@extends('layouts.admin')

@section('title', 'Create Skill Training - Admin Panel')

@section('page-title', 'Create Skill Training')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-graduation-cap"></i> Create New Skill Training
        </h1>
        <a href="{{ route('admin.skill-trainings.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Trainings
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

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Create New Skill Training</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.skill-trainings.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Training Title *</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description *</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="objectives" class="form-label">Learning Objectives *</label>
                                <textarea class="form-control" id="objectives" name="objectives" rows="3" required>{{ old('objectives') }}</textarea>
                                @error('objectives')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="trainer" class="form-label">Trainer/Facilitator *</label>
                                        <input type="text" class="form-control" id="trainer" name="trainer" value="{{ old('trainer') }}" required>
                                        @error('trainer')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Location *</label>
                                        <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
                                        @error('location')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date *</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                        @error('start_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date *</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="max_participants" class="form-label">Maximum Participants *</label>
                                <input type="number" class="form-control" id="max_participants" name="max_participants" value="{{ old('max_participants') }}" min="1" required>
                                @error('max_participants')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active (Visible to users)</label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.skill-trainings.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Training</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
