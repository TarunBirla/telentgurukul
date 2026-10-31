<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CRM') - Talent Gurukul India</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --tg-primary: #1e3a8a;       /* Deep Brain Navy */
            --tg-primary-light: #eff6ff;
            --tg-accent: #0284c7;        /* Cognitive Blue */
            --tg-sidebar-width: 260px;
            --tg-border: #e2e8f0;
            --tg-text-main: #0f172a;
            --tg-text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: var(--tg-text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styling - Pure White Crisp Design */
        #crmSidebar {
            width: var(--tg-sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #ffffff;
            border-right: 1px solid var(--tg-border);
            z-index: 1030;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--tg-border);
            display: flex;
            align-items: center;
            gap: 12px;
            background: #ffffff;
        }

        .brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%);
            color: #ffffff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            box-shadow: 0 4px 10px rgba(30, 58, 138, 0.2);
        }

        .brand-text h6 {
            font-size: 0.95rem;
            font-weight: 800;
            margin: 0;
            color: #0f172a;
            letter-spacing: -0.2px;
        }

        .brand-text span {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--tg-accent);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0.75rem;
        }

        .nav-section-title {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            padding: 0.75rem 0.75rem 0.35rem;
            margin-top: 0.5rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.6rem 0.85rem;
            color: #334155;
            font-size: 0.86rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.18s ease;
            margin-bottom: 2px;
            text-decoration: none;
        }

        .sidebar-nav .nav-link i {
            font-size: 1.15rem;
            color: #64748b;
            transition: color 0.18s ease;
        }

        .sidebar-nav .nav-link:hover {
            background-color: #f8fafc;
            color: var(--tg-primary);
        }

        .sidebar-nav .nav-link:hover i {
            color: var(--tg-primary);
        }

        .sidebar-nav .nav-link.active {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-weight: 600;
        }

        .sidebar-nav .nav-link.active i {
            color: #1d4ed8;
        }

        .sidebar-nav .badge {
            margin-left: auto;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid var(--tg-border);
            background: #fafafa;
        }

        /* Top Header Navbar */
        #crmHeader {
            height: 64px;
            margin-left: var(--tg-sidebar-width);
            background-color: #ffffff;
            border-bottom: 1px solid var(--tg-border);
            position: sticky;
            top: 0;
            z-index: 1020;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            transition: margin-left 0.3s ease;
        }

        /* Main Content Container */
        #crmContent {
            margin-left: var(--tg-sidebar-width);
            padding: 1.75rem;
            background-color: #ffffff;
            min-height: calc(100vh - 64px);
            transition: margin-left 0.3s ease;
        }

        /* Clean White Cards with Crisp Borders */
        .card {
            background-color: #ffffff;
            border: 1px solid var(--tg-border);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border-color: #cbd5e1;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid var(--tg-border);
            padding: 1rem 1.25rem;
            font-weight: 600;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
        }

        /* Clean Table Styling */
        .table {
            color: var(--tg-text-main);
            vertical-align: middle;
            margin-bottom: 0;
        }

        .table th {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            background-color: #f8fafc;
            border-bottom: 1px solid var(--tg-border);
            padding: 0.85rem 1rem;
        }

        .table td {
            font-size: 0.85rem;
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tr:hover td {
            background-color: #fcfcfd;
        }

        /* Metric KPI Card */
        .metric-card {
            padding: 1.25rem;
            border-radius: 12px;
            border: 1px solid var(--tg-border);
            background: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .metric-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        /* Action Buttons */
        .btn-tg-primary {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.45rem 1rem;
            border: none;
            transition: background-color 0.15s ease;
        }

        .btn-tg-primary:hover {
            background-color: #172554;
            color: #ffffff;
        }

        .btn-tg-light {
            background-color: #f8fafc;
            color: #334155;
            border: 1px solid var(--tg-border);
            font-weight: 500;
            border-radius: 8px;
            padding: 0.45rem 1rem;
        }

        .btn-tg-light:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Responsive */
        @media (max-width: 991px) {
            #crmSidebar {
                margin-left: calc(-1 * var(--tg-sidebar-width));
            }
            #crmSidebar.show {
                margin-left: 0;
            }
            #crmHeader, #crmContent {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- 1. Pure White Clean CRM Sidebar -->
    <aside id="crmSidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="brand-text">
                <h6>TALENT GURUKUL</h6>
                <span>Student Lifecycle CRM</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <!-- Main Section -->
            <div class="nav-section-title">Core Management</div>
            <a href="{{ route('crm.dashboard') }}" class="nav-link {{ request()->routeIs('crm.dashboard*') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard Overview</span>
            </a>

            <!-- Enquiries & Leads Section -->
            <div class="nav-section-title">Admissions & Pipeline</div>
            <a href="{{ route('crm.leads.index') }}" class="nav-link {{ request()->routeIs('crm.leads.index') ? 'active' : '' }}">
                <i class="bi bi-funnel-fill"></i>
                <span>All Enquiries & Leads</span>
                @php $leadCount = \App\Models\Lead::where('status', 'new_enquiry')->count(); @endphp
                @if($leadCount > 0)
                    <span class="badge bg-danger rounded-pill">{{ $leadCount }}</span>
                @endif
            </a>
            <a href="{{ route('crm.leads.pipeline') }}" class="nav-link {{ request()->routeIs('crm.leads.pipeline') ? 'active' : '' }}">
                <i class="bi bi-kanban-fill"></i>
                <span>Lead Pipeline (Kanban)</span>
            </a>
            <a href="{{ route('crm.leads.followups') }}" class="nav-link {{ request()->routeIs('crm.leads.followups') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Follow-up Tasks</span>
                @php 
                    $dueCount = \App\Models\Lead::whereDate('followup_date', '<=', \Carbon\Carbon::today()->toDateString())
                        ->whereNotIn('status', ['admission_confirmed', 'lost_lead'])->count(); 
                @endphp
                @if($dueCount > 0)
                    <span class="badge bg-warning text-dark rounded-pill">{{ $dueCount }}</span>
                @endif
            </a>

            <!-- Counselling Module -->
            <a href="{{ route('crm.counselling.index') }}" class="nav-link {{ request()->routeIs('crm.counselling*') ? 'active' : '' }}">
                <i class="bi bi-calendar2-heart-fill"></i>
                <span>Counselling Sessions</span>
            </a>

            <!-- Students & Parents Section -->
            <div class="nav-section-title">Student Operations</div>
            <a href="{{ route('crm.students.index') }}" class="nav-link {{ request()->routeIs('crm.students.index') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>All Registered Students</span>
            </a>
            <a href="{{ route('crm.students.parents') }}" class="nav-link {{ request()->routeIs('crm.students.parents') ? 'active' : '' }}">
                <i class="bi bi-person-hearts"></i>
                <span>Parent Directory</span>
                <span class="badge bg-light text-muted border">Multi-Child</span>
            </a>
            <a href="{{ route('crm.students.create') }}" class="nav-link {{ request()->routeIs('crm.students.create') ? 'active' : '' }}">
                <i class="bi bi-person-plus-fill"></i>
                <span>New Registration</span>
            </a>

            <!-- Courses & Training -->
            <div class="nav-section-title">Programs & Classes</div>
            <a href="{{ route('crm.courses.index') }}" class="nav-link {{ request()->routeIs('crm.courses*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>Courses & Packages</span>
            </a>
            <a href="{{ route('crm.batches.index') }}" class="nav-link {{ request()->routeIs('crm.batches*') ? 'active' : '' }}">
                <i class="bi bi-calendar3-week-fill"></i>
                <span>Batches & Attendance</span>
            </a>
            <a href="{{ route('crm.progress.index') }}" class="nav-link {{ request()->routeIs('crm.progress*') ? 'active' : '' }}">
                <i class="bi bi-award-fill"></i>
                <span>Assessments & Certs</span>
            </a>

            <!-- Financials Section -->
            <div class="nav-section-title">Accounts & Billing</div>
            <a href="{{ route('crm.fees.index') }}" class="nav-link {{ request()->routeIs('crm.fees.index') ? 'active' : '' }}">
                <i class="bi bi-receipt-cutoff"></i>
                <span>Fee Ledgers & Invoices</span>
            </a>
            <a href="{{ route('crm.fees.payments') }}" class="nav-link {{ request()->routeIs('crm.fees.payments') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i>
                <span>Payment Receipts</span>
            </a>

            <!-- Communication & Marketing -->
            <div class="nav-section-title">Engagement & Analytics</div>
            <a href="{{ route('crm.communication.index') }}" class="nav-link {{ request()->routeIs('crm.communication*') ? 'active' : '' }}">
                <i class="bi bi-whatsapp"></i>
                <span>WhatsApp & Messages</span>
            </a>
            <a href="{{ route('crm.reports.index') }}" class="nav-link {{ request()->routeIs('crm.reports*') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i>
                <span>Marketing & Reports</span>
            </a>

            <!-- System Settings -->
            <div class="nav-section-title">Administration</div>
            <a href="{{ route('crm.settings.index') }}" class="nav-link {{ request()->routeIs('crm.settings*') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i>
                <span>Staff, Roles & Branches</span>
            </a>
            <a href="{{ route('parent.dashboard') }}" class="nav-link" target="_blank">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>View Parent Portal</span>
            </a>
            <a href="{{ route('home') }}" class="nav-link" target="_blank">
                <i class="bi bi-globe2"></i>
                <span>Website Landing Page</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary-subtle text-primary fw-bold rounded-circle p-2 text-center" style="width:36px;height:36px;font-size:0.8rem;">
                        {{ substr(auth()->user()->name ?? 'Dr. Sameer', 0, 2) }}
                    </div>
                    <div style="line-height:1.2;">
                        <div class="fw-bold small text-truncate" style="max-width:110px;">{{ auth()->user()->name ?? 'Dr. Sameer' }}</div>
                        <span class="badge bg-primary-subtle text-primary" style="font-size:0.65rem;">{{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'Admin')) }}</span>
                    </div>
                </div>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-light border text-danger" title="Logout">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- 2. Sticky Top Header -->
    <header id="crmHeader">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-light d-lg-none" id="sidebarToggleBtn">
                <i class="bi bi-list fs-5"></i>
            </button>
            <div class="d-none d-md-flex align-items-center gap-2 text-muted small">
                <i class="bi bi-geo-alt-fill text-primary"></i>
                <span class="fw-semibold text-dark">Branch:</span>
                <span class="badge bg-light text-dark border">Talent Gurukul - Head Office (Noida)</span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Quick Role Switcher Pill for Pairing/Testing -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2 rounded-pill px-3" data-bs-toggle="dropdown">
                    <i class="bi bi-person-badge"></i>
                    <span>Role: <strong class="text-primary">{{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'Admin')) }}</strong></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="font-size:0.85rem;">
                    <li class="dropdown-header text-uppercase fw-bold" style="font-size:0.7rem;">Simulate Employee Role</li>
                    <li><a class="dropdown-item" href="{{ route('login.as', 'admin') }}"><i class="bi bi-shield-check text-danger me-2"></i>Super Admin / Director</a></li>
                    <li><a class="dropdown-item" href="{{ route('login.as', 'counsellor') }}"><i class="bi bi-headset text-primary me-2"></i>Sr. Brain Counsellor</a></li>
                    <li><a class="dropdown-item" href="{{ route('login.as', 'admission_executive') }}"><i class="bi bi-person-check text-info me-2"></i>Admission Executive</a></li>
                    <li><a class="dropdown-item" href="{{ route('login.as', 'accountant') }}"><i class="bi bi-wallet2 text-success me-2"></i>Accounts Head</a></li>
                    <li><a class="dropdown-item" href="{{ route('login.as', 'trainer') }}"><i class="bi bi-mortarboard text-warning me-2"></i>Lead Brain Trainer</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('login.as', 'parent') }}"><i class="bi bi-people text-purple me-2"></i>Parent Account</a></li>
                </ul>
            </div>

            <!-- Server Installer Shortcut -->
            <a href="{{ route('setup.index') }}" class="btn btn-sm btn-light border d-none d-sm-inline-flex align-items-center gap-1" title="Live Server DB Setup">
                <i class="bi bi-database-gear text-success"></i>
                <span class="small fw-semibold">DB Installer</span>
            </a>

            <!-- Quick Add Dropdown -->
            <div class="dropdown">
                <button class="btn btn-sm btn-tg-primary dropdown-toggle d-flex align-items-center gap-1" data-bs-toggle="dropdown">
                    <i class="bi bi-plus-lg"></i>
                    <span>Quick Add</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="font-size:0.85rem;">
                    <li><a class="dropdown-item" href="{{ route('crm.leads.index') }}#addLeadModal" data-bs-toggle="modal" data-bs-target="#newLeadModal"><i class="bi bi-funnel text-primary me-2"></i>New Lead Enquiry</a></li>
                    <li><a class="dropdown-item" href="{{ route('crm.students.create') }}"><i class="bi bi-person-plus text-success me-2"></i>Register New Student</a></li>
                    <li><a class="dropdown-item" href="{{ route('crm.counselling.index') }}"><i class="bi bi-calendar2-plus text-info me-2"></i>Book Counselling Slot</a></li>
                    <li><a class="dropdown-item" href="{{ route('crm.fees.index') }}"><i class="bi bi-currency-rupee text-warning me-2"></i>Collect Fee Payment</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- 3. Main Workspace Content -->
    <main id="crmContent">
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert" style="background-color: #ecfdf5; color: #065f46;">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mobile Sidebar Toggle
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const sidebar = document.getElementById('crmSidebar');
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });
        }
    </script>
    @yield('scripts')
</body>
</html>
