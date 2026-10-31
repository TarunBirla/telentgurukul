@extends('layouts.crm')

@section('title', 'Staff, Roles & Branches')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Employees, Roles & Centre Branches</h4>
        <p class="text-muted small mb-0">Role-based access control, branch allocations, and system audit trail.</p>
    </div>
</div>

<!-- Tabs -->
<ul class="nav nav-pills mb-4 gap-2" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#staffTab">
            <i class="bi bi-people me-1"></i> Employees & Roles ({{ $users->count() }})
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#branchesTab">
            <i class="bi bi-geo-alt me-1"></i> Branches ({{ $branches->count() }})
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link rounded-pill px-3 py-2 fw-semibold" data-bs-toggle="pill" data-bs-target="#auditTab">
            <i class="bi bi-shield-lock me-1"></i> Audit Activity Logs ({{ $auditLogs->count() }})
        </button>
    </li>
</ul>

<div class="tab-content">
    <!-- Staff Tab -->
    <div class="tab-pane fade show active" id="staffTab">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Staff Name</th>
                            <th>Email Login</th>
                            <th>Contact Phone</th>
                            <th>System Role</th>
                            <th>Assigned Centre</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                            <tr>
                                <td>
                                    <div class="fw-bold text-dark">{{ $u->name }}</div>
                                </td>
                                <td><code>{{ $u->email }}</code></td>
                                <td class="small">{{ $u->phone ?: 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle text-capitalize">
                                        {{ str_replace('_', ' ', $u->role) }}
                                    </span>
                                </td>
                                <td class="small text-muted">{{ $u->branch ? $u->branch->name : 'All Centres' }}</td>
                                <td><span class="badge bg-success-subtle text-success border border-success-subtle">Active</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Branches Tab -->
    <div class="tab-pane fade" id="branchesTab">
        <div class="row g-4">
            @foreach($branches as $b)
                <div class="col-md-4">
                    <div class="card p-4 border shadow-sm bg-white h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary font-monospace">{{ $b->code }}</span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Operational</span>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $b->name }}</h5>
                        <div class="text-muted small mb-3"><i class="bi bi-geo-alt"></i> {{ $b->city }}</div>
                        <p class="text-secondary small mb-3">{{ $b->address }}</p>
                        <div class="border-top pt-2 small text-muted">
                            <div><i class="bi bi-telephone me-1"></i> {{ $b->phone }}</div>
                            <div><i class="bi bi-envelope me-1"></i> {{ $b->email }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Audit Logs Tab -->
    <div class="tab-pane fade" id="auditTab">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Action Type</th>
                            <th>Target Module</th>
                            <th>Activity Description</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($auditLogs as $log)
                            <tr>
                                <td class="small text-muted">{{ $log->created_at->format('d M Y, h:i A') }}</td>
                                <td class="fw-bold small text-dark">{{ $log->user_name ?: ($log->user ? $log->user->name : 'System') }}</td>
                                <td><span class="badge bg-light text-dark border font-monospace">{{ $log->action }}</span></td>
                                <td><span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $log->module }}</span></td>
                                <td class="small text-secondary" style="max-width:320px;">{{ $log->description }}</td>
                                <td class="small font-monospace text-muted">{{ $log->ip_address ?: '127.0.0.1' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
