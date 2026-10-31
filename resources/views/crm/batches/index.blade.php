@extends('layouts.crm')

@section('title', 'Batches & Training Groups')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Batches & Attendance Management</h4>
        <p class="text-muted small mb-0">Manage brain development batches, schedule classes, assign trainers, and track daily student attendance.</p>
    </div>
    <div>
        <button class="btn btn-tg-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#newBatchModal">
            <i class="bi bi-calendar3-week me-1"></i> <span>Create New Batch</span>
        </button>
    </div>
</div>

<div class="row g-4">
    @forelse($batches as $batch)
        <div class="col-lg-6">
            <div class="card p-4 border shadow-sm bg-white h-100">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="badge bg-primary font-monospace">{{ $batch->batch_code }}</span>
                        <span class="badge bg-success-subtle text-success border border-success-subtle ms-1">{{ ucfirst($batch->status) }}</span>
                    </div>
                    <span class="badge bg-light text-muted border">
                        {{ $batch->batchStudents->count() }} / {{ $batch->max_capacity }} Students
                    </span>
                </div>

                <h5 class="fw-bold text-dark mb-1">
                    <a href="{{ route('crm.batches.show', $batch->id) }}" class="text-dark text-decoration-none">
                        {{ $batch->batch_name }}
                    </a>
                </h5>
                <div class="text-muted small mb-3">
                    Course: <strong class="text-primary">{{ $batch->course ? $batch->course->name : 'N/A' }}</strong>
                </div>

                <div class="p-3 border rounded-3 bg-light small mb-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <span class="text-muted">Days of Week:</span>
                            <div class="fw-bold text-dark">{{ $batch->days_of_week }}</div>
                        </div>
                        <div class="col-6">
                            <span class="text-muted">Timings:</span>
                            <div class="fw-bold text-dark">{{ $batch->class_time }}</div>
                        </div>
                        <div class="col-6">
                            <span class="text-muted">Assigned Trainer:</span>
                            <div class="fw-bold text-dark">{{ $batch->trainer ? $batch->trainer->name : 'Unassigned' }}</div>
                        </div>
                        <div class="col-6">
                            <span class="text-muted">Centre Branch:</span>
                            <div class="fw-bold text-dark">{{ $batch->branch ? $batch->branch->name : 'Noida HQ' }}</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2">
                    <div class="small text-muted">
                        Started on: <strong>{{ $batch->start_date ? $batch->start_date->format('d M Y') : 'N/A' }}</strong>
                    </div>
                    <a href="{{ route('crm.batches.show', $batch->id) }}" class="btn btn-outline-primary btn-sm fw-semibold">
                        <i class="bi bi-calendar2-check me-1"></i> Manage & Mark Attendance
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5 text-muted">No training batches created.</div>
    @endforelse
</div>

<!-- Modal: New Batch -->
<div class="modal fade" id="newBatchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-calendar3-week text-primary me-2"></i>Create New Training Batch</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.batches.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Batch Name *</label>
                        <input type="text" name="batch_name" class="form-control" placeholder="e.g. Photographic Memory - Champions Batch" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Course Program *</label>
                            <select name="course_id" class="form-select" required>
                                @foreach($courses as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Assigned Trainer</label>
                            <select name="trainer_id" class="form-select">
                                @foreach($trainers as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Days of Week</label>
                            <input type="text" name="days_of_week" class="form-control" value="Mon,Wed,Fri">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Class Timings</label>
                            <input type="text" name="class_time" class="form-control" value="04:00 PM - 05:30 PM">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Start Date *</label>
                            <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Max Student Capacity</label>
                            <input type="number" name="max_capacity" class="form-control" value="12">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Batch Notes</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Batch syllabus goals, practice guidelines..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-tg-primary">Create Batch</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
