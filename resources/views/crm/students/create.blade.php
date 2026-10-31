@extends('layouts.crm')

@section('title', 'Register New Student')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('crm.students.index') }}" class="btn btn-sm btn-light border text-muted">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold text-dark mb-0">New Student Registration & Admission</h4>
            <p class="text-muted small mb-0">Complete enrollment, generate official Student ID, and setup fee ledger.</p>
        </div>
    </div>
</div>

<form action="{{ route('crm.students.store') }}" method="POST">
    @csrf
    <div class="row g-4">
        <!-- 1. Child / Student Information -->
        <div class="col-lg-6">
            <div class="card p-4 border-0 shadow-sm h-100 bg-white">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-person-fill text-primary me-2"></i>Child / Student Details</h6>

                <div class="row g-2 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold text-secondary">First Name *</label>
                        <input type="text" name="first_name" class="form-control" placeholder="e.g. Reyansh" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold text-secondary">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="e.g. Verma">
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-sm-4">
                        <label class="form-label small fw-semibold text-secondary">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" id="dobInput">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label small fw-semibold text-secondary">Age</label>
                        <input type="number" name="age" class="form-control" placeholder="e.g. 10">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label small fw-semibold text-secondary">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-sm-8">
                        <label class="form-label small fw-semibold text-secondary">Current School Name</label>
                        <input type="text" name="school_name" class="form-control" placeholder="e.g. Delhi Public School">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label small fw-semibold text-secondary">Current Grade / Class</label>
                        <input type="text" name="current_class" class="form-control" placeholder="e.g. 5th Standard">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Medical / Special Dietary Notes</label>
                    <textarea name="medical_notes" class="form-control" rows="2" placeholder="Any allergy, spectacles power, or learning preference notes..."></textarea>
                </div>
            </div>
        </div>

        <!-- 2. Parent / Guardian Details -->
        <div class="col-lg-6">
            <div class="card p-4 border-0 shadow-sm h-100 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-people-fill text-success me-2"></i>Parent / Guardian Details</h6>
                    <span class="badge bg-light text-muted border">Automatic Sibling Linking</span>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold text-secondary">Father's Full Name</label>
                        <input type="text" name="father_name" class="form-control" placeholder="e.g. Alok Verma">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold text-secondary">Mother's Full Name</label>
                        <input type="text" name="mother_name" class="form-control" placeholder="e.g. Anita Verma">
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold text-secondary">Primary Mobile (Login ID) *</label>
                        <input type="tel" name="primary_mobile" class="form-control" placeholder="10-digit mobile" required>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold text-secondary">WhatsApp Number</label>
                        <input type="tel" name="whatsapp_number" class="form-control" placeholder="For automated receipts">
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold text-secondary">Parent Email</label>
                        <input type="email" name="email" class="form-control" placeholder="parent@example.com">
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label small fw-semibold text-secondary">City</label>
                        <input type="text" name="city" class="form-control" value="Noida / NCR">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Residential Address</label>
                    <textarea name="address" class="form-control" rows="2" placeholder="House/Flat No, Sector, Landmark..."></textarea>
                </div>
            </div>
        </div>

        <!-- 3. Course Enrollment & Fee Setup -->
        <div class="col-12">
            <div class="card p-4 border-0 shadow-sm bg-white">
                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-mortarboard-fill text-warning me-2"></i>Program Selection & Financial Terms</h6>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-secondary">Select Course *</label>
                        <select name="course_id" class="form-select" id="courseSelect" required>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" data-fee="{{ $c->course_fee }}">
                                    {{ $c->name }} (₹{{ number_format($c->course_fee) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-secondary">Branch / Training Centre *</label>
                        <select name="branch_id" class="form-select" required>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->city }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-secondary">Discount / Sibling Concession (₹)</label>
                        <input type="number" name="discount_amount" class="form-control" value="0" min="0">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-secondary">Admission Date</label>
                        <input type="date" name="admission_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-secondary">Batch Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d', strtotime('+2 days')) }}">
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('crm.students.index') }}" class="btn btn-light border px-4">Cancel</a>
                    <button type="submit" class="btn btn-tg-primary px-5 py-2 fw-bold">
                        <i class="bi bi-check-lg me-1"></i> Register Student & Create Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
