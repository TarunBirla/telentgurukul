@extends('layouts.crm')

@section('title', 'Reports & Marketing Analytics')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Marketing & Business Analytics</h4>
        <p class="text-muted small mb-0">Evaluate campaign ROI, lead source conversion performance, and individual counsellor productivity.</p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-tg-light btn-sm">
            <i class="bi bi-printer me-1"></i> Print Analytics
        </button>
    </div>
</div>

<!-- 1. Lead Sources Marketing Conversion Table -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold text-dark"><i class="bi bi-pie-chart text-primary me-2"></i>Marketing Acquisition Channels Performance</span>
        <span class="badge bg-light text-muted border">Enquiry to Paid Admission</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Lead Source</th>
                    <th>Total Enquiries</th>
                    <th>Admissions Converted</th>
                    <th>Conversion Rate (%)</th>
                    <th>Performance Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sources as $src)
                    <tr>
                        <td class="fw-bold text-dark">
                            <i class="bi {{ $src['icon'] }} text-primary me-2"></i>{{ $src['name'] }}
                        </td>
                        <td class="fw-semibold">{{ $src['total_leads'] }}</td>
                        <td class="fw-bold text-success">{{ $src['converted'] }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:6px; width:60px;">
                                    <div class="progress-bar bg-success" style="width: {{ $src['conversion_rate'] }}%"></div>
                                </div>
                                <span class="small fw-bold">{{ $src['conversion_rate'] }}%</span>
                            </div>
                        </td>
                        <td>
                            @if($src['conversion_rate'] >= 30)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">High Converting</span>
                            @elseif($src['conversion_rate'] >= 15)
                                <span class="badge bg-info-subtle text-info border border-info-subtle">Moderate</span>
                            @else
                                <span class="badge bg-light text-muted border">Top of Funnel</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- 2. Counsellor Performance Table -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold text-dark"><i class="bi bi-person-check text-info me-2"></i>Counsellor Sales & Counselling Performance</span>
        <span class="badge bg-light text-muted border">Employee KPIs</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Staff Name & Role</th>
                    <th>Leads Assigned</th>
                    <th>Counselling Done</th>
                    <th>Admissions Closed</th>
                    <th>Conversion Rate (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($counsellors as $coun)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $coun['name'] }}</div>
                            <span class="badge bg-light text-muted border text-capitalize" style="font-size:0.65rem;">{{ str_replace('_', ' ', $coun['role']) }}</span>
                        </td>
                        <td class="fw-semibold">{{ $coun['assigned'] }}</td>
                        <td class="fw-semibold text-info">{{ $coun['counselling_done'] }}</td>
                        <td class="fw-bold text-success">{{ $coun['converted'] }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress flex-grow-1" style="height:6px; width:60px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $coun['conversion_rate'] }}%"></div>
                                </div>
                                <span class="small fw-bold">{{ $coun['conversion_rate'] }}%</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- 3. Course Revenue Generation Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold text-dark"><i class="bi bi-wallet2 text-success me-2"></i>Course-wise Revenue Generation</span>
        <span class="badge bg-light text-muted border">Financial Attribution</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Course Name</th>
                    <th>Category</th>
                    <th>Total Enrolments</th>
                    <th>Total Collected</th>
                    <th>Pending Dues</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $c)
                    <tr>
                        <td class="fw-bold text-dark">{{ $c['name'] }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $c['category'] }}</span></td>
                        <td class="fw-bold text-primary">{{ $c['enrolments'] }} Students</td>
                        <td class="fw-bold text-success">₹{{ number_format($c['revenue']) }}</td>
                        <td class="fw-bold {{ $c['pending'] > 0 ? 'text-danger' : 'text-muted' }}">₹{{ number_format($c['pending']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
