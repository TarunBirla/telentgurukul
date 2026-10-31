@extends('layouts.crm')

@section('title', 'Courses & Programs')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Courses, Programs & Packages</h4>
        <p class="text-muted small mb-0">Manage brain development curriculum, session counts, pricing schedules, and multi-course packages.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newPackageModal">
            <i class="bi bi-box me-1"></i> New Package Bundle
        </button>
        <button class="btn btn-tg-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newCourseModal">
            <i class="bi bi-plus-lg me-1"></i> Add New Course
        </button>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-pills mb-4 gap-2" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#coursesTab">
            <i class="bi bi-journal-text me-1"></i> Individual Courses ({{ $courses->count() }})
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#packagesTab">
            <i class="bi bi-box-seam me-1"></i> Multi-Course Bundles ({{ $packages->count() }})
        </button>
    </li>
</ul>

<div class="tab-content">
    <!-- Courses Tab -->
    <div class="tab-pane fade show active" id="coursesTab">
        <div class="row g-4">
            @foreach($courses as $course)
                <div class="col-md-6 col-lg-4">
                    <div class="card p-4 border shadow-sm h-100 bg-white">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $course->category }}</span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                        </div>

                        <h5 class="fw-bold text-dark mb-2">{{ $course->name }}</h5>
                        <p class="text-secondary small mb-3" style="line-height:1.5;">{{ $course->description }}</p>

                        <div class="border-top border-bottom py-2 my-2 small">
                            <div class="d-flex justify-content-between py-1 text-muted">
                                <span>Duration:</span>
                                <strong class="text-dark">{{ $course->duration_days }} Days ({{ $course->total_sessions }} Sessions)</strong>
                            </div>
                            <div class="d-flex justify-content-between py-1 text-muted">
                                <span>Session Time:</span>
                                <strong class="text-dark">{{ $course->session_minutes }} Minutes</strong>
                            </div>
                            <div class="d-flex justify-content-between py-1 text-muted">
                                <span>Batch Limit:</span>
                                <strong class="text-dark">{{ $course->max_batch_capacity }} Students</strong>
                            </div>
                            <div class="d-flex justify-content-between py-1 text-muted">
                                <span>Total Enrolled:</span>
                                <strong class="text-primary">{{ $course->enrolments_count }} Students</strong>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2">
                            <div>
                                <span class="small text-muted" style="font-size:0.75rem;">Course Fee</span>
                                <h4 class="fw-bold text-primary mb-0">₹{{ number_format($course->course_fee) }}</h4>
                            </div>
                            <span class="badge bg-light text-muted border">Cert: Included</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Packages Tab -->
    <div class="tab-pane fade" id="packagesTab">
        <div class="row g-4">
            @foreach($packages as $pkg)
                <div class="col-lg-6">
                    <div class="card p-4 border shadow-sm bg-white position-relative">
                        <span class="position-absolute top-0 end-0 badge bg-danger text-white rounded-pill m-3 px-3 py-1">
                            Save ₹{{ number_format($pkg->discount_amount) }}
                        </span>
                        <h5 class="fw-bold text-dark mb-2">{{ $pkg->name }}</h5>
                        <p class="text-secondary small mb-3">{{ $pkg->description }}</p>

                        <div class="p-3 border rounded-3 bg-light mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="small text-muted">Package Price:</span>
                                    <div class="h3 fw-bold text-primary mb-0">₹{{ number_format($pkg->package_fee) }}</div>
                                </div>
                                <div class="text-end">
                                    <span class="small text-muted">Individual Sum:</span>
                                    <div class="text-muted text-decoration-line-through">₹{{ number_format($pkg->original_fee) }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="small text-muted">
                            <i class="bi bi-clock me-1"></i> Program Duration: <strong>{{ $pkg->duration_days }} Days</strong>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal: New Course -->
<div class="modal fade" id="newCourseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-journal-plus text-primary me-2"></i>Create New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.courses.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Course Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Speed Reading & Quantum Comprehension" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Category</label>
                        <select name="category" class="form-select">
                            <option value="Memory Enhancement">Memory Enhancement</option>
                            <option value="Brain Development">Brain Development</option>
                            <option value="Counselling & Profiling">Counselling & Profiling</option>
                            <option value="Neuro-Linguistic">Neuro-Linguistic</option>
                            <option value="Mathematical Skills">Mathematical Skills</option>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Course Fee (₹) *</label>
                            <input type="number" name="course_fee" class="form-control" placeholder="15000" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Total Sessions *</label>
                            <input type="number" name="total_sessions" class="form-control" placeholder="15" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Duration (Days)</label>
                            <input type="number" name="duration_days" class="form-control" value="30">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Session Minutes</label>
                            <input type="number" name="session_minutes" class="form-control" value="60">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Course syllabus and expected outcomes..."></textarea>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_certificate" id="certCheck" checked>
                            <label class="form-check-label small" for="certCheck">Provides Certificate</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_assessment" id="assessCheck" checked>
                            <label class="form-check-label small" for="assessCheck">Has Before/After Assessment</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-tg-primary">Save Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: New Package -->
<div class="modal fade" id="newPackageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-box-seam text-primary me-2"></i>Create Multi-Course Bundle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('crm.courses.package.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Package Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Complete Brain Mastery Package" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Original Value (₹)</label>
                            <input type="number" name="original_fee" class="form-control" placeholder="45000">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-secondary">Discounted Price (₹) *</label>
                            <input type="number" name="package_fee" class="form-control" placeholder="38000" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Package Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Included course highlights and discount details..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-tg-primary">Create Package</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
