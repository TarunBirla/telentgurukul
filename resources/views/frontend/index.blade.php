<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talent Gurukul India - Children's Brain Development & Memory Institute</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #1e3a8a;
            --primary-dark: #172554;
            --accent: #0284c7;
            --secondary: #f59e0b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .brand-font {
            font-family: 'Outfit', sans-serif;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.5px;
            font-size: 1.4rem;
        }

        .hero-section {
            background: radial-gradient(circle at top right, #eff6ff 0%, #ffffff 60%);
            padding: 5rem 0 4rem;
            position: relative;
        }

        .program-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.75rem;
            transition: all 0.25s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .program-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
            box-shadow: 0 12px 30px rgba(2, 132, 199, 0.08);
        }

        .program-icon-box {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin-bottom: 1.25rem;
            background: #eff6ff;
            color: var(--primary);
        }

        .metric-pill {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: var(--primary);
        }

        .footer-link {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.15s ease;
        }
        .footer-link:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- 1. Top Announcement Bar -->
    <div class="py-2 bg-dark text-white small" style="background:#0f172a !important;">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-geo-alt-fill text-warning me-1"></i> Centres in Noida, Delhi & Lucknow</span>
                <span class="d-none d-md-inline text-muted">|</span>
                <span class="d-none d-md-inline"><i class="bi bi-telephone-fill text-info me-1"></i> Helpline: +91 98765 43210</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('setup.index') }}" class="text-warning text-decoration-none fw-semibold">
                    <i class="bi bi-database-check me-1"></i> Live Server Installer
                </a>
                <span class="text-muted">|</span>
                <a href="{{ route('login') }}" class="text-light text-decoration-none fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> CRM Login
                </a>
            </div>
        </div>
    </div>

    <!-- 2. Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
                <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%);">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <span>TALENT GURUKUL <small class="text-muted fs-6 fw-normal">INDIA</small></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium">
                    <li class="nav-item"><a class="nav-link text-dark" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#programs">Brain Programs</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#packages">Special Bundles</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#results">Proven Results</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#testimonials">Testimonials</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="#counsellingForm">Free Counselling</a></li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('parent.dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                        <i class="bi bi-person-heart me-1"></i> Parent Portal
                    </a>
                    <a href="{{ route('crm.dashboard') }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold shadow-sm" style="background:#1e3a8a; border:none;">
                        <i class="bi bi-speedometer2 me-1"></i> Staff CRM
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- 3. Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-primary-subtle text-primary border border-primary-subtle small fw-bold mb-3">
                        <i class="bi bi-stars"></i> India's Premier Child Brain Development Institute
                    </div>
                    <h1 class="display-4 fw-extrabold text-dark mb-3" style="line-height: 1.15;">
                        Unlock Your Child's <span style="color:#0284c7;">Photographic Memory</span> & Peak Cognitive Potential.
                    </h1>
                    <p class="lead text-secondary mb-4" style="font-size: 1.15rem;">
                        Transform ordinary memorization into vivid photographic capture. Scientifically validated programs in DMIT Profiling, Midbrain Activation, NLP Mnemonics, and Quantum Speed Reading for ages 4 to 16.
                    </p>

                    <div class="d-flex flex-wrap gap-3 mb-4">
                        <a href="#counsellingForm" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%); border:none;">
                            <i class="bi bi-calendar2-check-fill me-2"></i> Book Free Brain Assessment
                        </a>
                        <a href="#programs" class="btn btn-outline-secondary btn-lg rounded-pill px-4 fw-semibold">
                            Explore Programs
                        </a>
                    </div>

                    <!-- Trust Stats -->
                    <div class="row g-3 pt-2">
                        <div class="col-sm-4">
                            <div class="metric-pill">
                                <h3 class="fw-bold mb-0 text-primary">5,000+</h3>
                                <div class="small text-muted fw-semibold">Children Transformed</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="metric-pill">
                                <h3 class="fw-bold mb-0 text-success">3x - 5x</h3>
                                <div class="small text-muted fw-semibold">Memory Recall Speed</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="metric-pill">
                                <h3 class="fw-bold mb-0 text-warning">100%</h3>
                                <div class="small text-muted fw-semibold">Scientific Pedagogy</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Counselling Enquiry Card -->
                <div class="col-lg-5" id="counsellingForm">
                    <div class="card p-4 p-md-4 shadow-lg border-0" style="border-radius: 20px; background: #ffffff;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h4 class="fw-bold mb-0 text-dark">Book Free Counselling</h4>
                            <span class="badge bg-danger rounded-pill px-3 py-1">Limited Slots</span>
                        </div>
                        <p class="text-muted small mb-3">Get in-depth guidance on your child's inborn learning styles and memory capability.</p>

                        <form action="{{ route('enquiry.submit') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label small fw-semibold text-secondary mb-1">Parent's Name *</label>
                                <input type="text" name="parent_name" class="form-control" placeholder="e.g. Rajesh Sharma" required>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Child's Name</label>
                                    <input type="text" name="student_name" class="form-control" placeholder="e.g. Aarav">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Child's Age</label>
                                    <input type="number" name="student_age" class="form-control" placeholder="e.g. 10" min="4" max="18">
                                </div>
                            </div>

                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Mobile Number *</label>
                                    <input type="tel" name="mobile" class="form-control" placeholder="10-digit number" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">City</label>
                                    <input type="text" name="city" class="form-control" value="Noida / NCR">
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label small fw-semibold text-secondary mb-1">Select Program of Interest *</label>
                                <select name="course_interest" class="form-select" required>
                                    <option value="Photographic Memory Training" selected>Photographic Memory Training</option>
                                    <option value="Midbrain Activation Program">Midbrain Activation Program</option>
                                    <option value="DMIT & Brain Profiling Counselling">DMIT & Counselling</option>
                                    <option value="NLP & Mnemonics for Kids">NLP & Mnemonics for Kids</option>
                                    <option value="Speed Reading & Quantum Comprehension">Speed Reading</option>
                                    <option value="Vedic Maths & Mental Arithmetic">Vedic Maths</option>
                                    <option value="Complete Super Brain Development Package">Complete Super Brain Package</option>
                                </select>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Preferred Date</label>
                                    <input type="date" name="preferred_counselling_date" class="form-control" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Preferred Time</label>
                                    <select name="preferred_counselling_time" class="form-select">
                                        <option>11:00 AM</option>
                                        <option>02:30 PM</option>
                                        <option>04:30 PM</option>
                                        <option>06:00 PM</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 rounded-3 fw-bold shadow-sm" style="background:#1e3a8a; border:none;">
                                <i class="bi bi-send-check-fill me-1"></i> Register Free Session & Enter CRM
                            </button>
                            <div class="text-center mt-2" style="font-size:0.75rem; color:#64748b;">
                                <i class="bi bi-shield-check text-success"></i> Automatically creates a lead in the CRM pipeline.
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Specialized Programs Section -->
    <section class="py-5" id="programs" style="background:#f8fafc;">
        <div class="container py-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="badge bg-primary-subtle text-primary fw-bold text-uppercase px-3 py-1 mb-2">Scientific Methodologies</span>
                <h2 class="display-6 fw-bold text-dark">Specialized Brain & Learning Programs</h2>
                <p class="text-muted">Designed by neuro-education psychologists and memory grandmasters to nurture left and right brain harmony.</p>
            </div>

            <div class="row g-4">
                @foreach($courses as $course)
                    <div class="col-md-6 col-lg-4">
                        <div class="program-card">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="program-icon-box">
                                        @if(str_contains(strtolower($course->name), 'memory'))
                                            <i class="bi bi-camera-fill text-primary"></i>
                                        @elseif(str_contains(strtolower($course->name), 'midbrain'))
                                            <i class="bi bi-eye-fill text-info"></i>
                                        @elseif(str_contains(strtolower($course->name), 'dmit'))
                                            <i class="bi bi-fingerprint text-purple"></i>
                                        @elseif(str_contains(strtolower($course->name), 'nlp'))
                                            <i class="bi bi-chat-heart-fill text-warning"></i>
                                        @elseif(str_contains(strtolower($course->name), 'speed'))
                                            <i class="bi bi-book-half text-success"></i>
                                        @else
                                            <i class="bi bi-calculator-fill text-danger"></i>
                                        @endif
                                    </div>
                                    <span class="badge bg-light text-dark border">{{ $course->category }}</span>
                                </div>

                                <h5 class="fw-bold text-dark mb-2">{{ $course->name }}</h5>
                                <p class="text-secondary small mb-3" style="line-height:1.6;">{{ $course->description }}</p>

                                <div class="border-top pt-3 mb-3">
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span><i class="bi bi-clock me-1"></i> Duration:</span>
                                        <strong class="text-dark">{{ $course->duration_days }} Days ({{ $course->total_sessions }} Sessions)</strong>
                                    </div>
                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                        <span><i class="bi bi-people me-1"></i> Batch Size:</span>
                                        <strong class="text-dark">Max {{ $course->max_batch_capacity }} Students</strong>
                                    </div>
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span><i class="bi bi-award me-1"></i> Certificate:</span>
                                        <strong class="text-success"><i class="bi bi-check2"></i> Included</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pt-2">
                                <div>
                                    <div class="small text-muted" style="font-size:0.75rem;">Program Fee</div>
                                    <div class="h5 fw-bold text-primary mb-0">₹{{ number_format($course->course_fee) }}</div>
                                </div>
                                <a href="#counsellingForm" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-semibold">
                                    Enrol Child
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. Package Bundles -->
    <section class="py-5" id="packages">
        <div class="container py-4">
            <div class="text-center max-w-700 mx-auto mb-5">
                <span class="badge bg-warning-subtle text-warning fw-bold text-uppercase px-3 py-1 mb-2">Value Bundles</span>
                <h2 class="display-6 fw-bold text-dark">Comprehensive Brain Mastery Packages</h2>
                <p class="text-muted">Multi-course pathways structured for holistic cognitive acceleration with exclusive fee concessions.</p>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($packages as $pkg)
                    <div class="col-lg-6">
                        <div class="card p-4 border-2 border-primary rounded-4 shadow-sm bg-white position-relative">
                            <span class="position-absolute top-0 end-0 badge bg-primary text-white rounded-pill m-3 px-3 py-2 fw-semibold">
                                Save ₹{{ number_format($pkg->discount_amount) }}
                            </span>
                            <h4 class="fw-bold text-dark mb-2">{{ $pkg->name }}</h4>
                            <p class="text-secondary small mb-3">{{ $pkg->description }}</p>

                            <div class="d-flex align-items-baseline gap-3 mb-4">
                                <span class="h2 fw-bold text-primary mb-0">₹{{ number_format($pkg->package_fee) }}</span>
                                <span class="text-muted text-decoration-line-through">₹{{ number_format($pkg->original_fee) }}</span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Recommended</span>
                            </div>

                            <a href="#counsellingForm" class="btn btn-primary rounded-pill py-2 fw-bold w-100" style="background:#1e3a8a; border:none;">
                                Book This Package for Your Child
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. Proven Before & After Results -->
    <section class="py-5 bg-light" id="results">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge bg-success-subtle text-success fw-bold text-uppercase px-3 py-1 mb-2">Measured Outcomes</span>
                    <h2 class="display-6 fw-bold text-dark mb-3">Observable & Scientific Progress Tracking</h2>
                    <p class="text-secondary">
                        Every child undergoes an authorized Baseline Assessment upon enrollment, followed by continuous session milestone tracking, and a Final Evaluation report downloadable from the Parent Portal.
                    </p>

                    <div class="p-3 border rounded-3 bg-white mb-3 shadow-sm">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold small">Memory Retention & Recall Accuracy</span>
                            <span class="fw-bold text-success small">48% ➔ 94% (+46%)</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 94%"></div>
                        </div>
                    </div>

                    <div class="p-3 border rounded-3 bg-white mb-3 shadow-sm">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold small">Reading & Comprehension Speed</span>
                            <span class="fw-bold text-primary small">110 WPM ➔ 310 WPM (2.8x)</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 85%"></div>
                        </div>
                    </div>

                    <div class="p-3 border rounded-3 bg-white shadow-sm">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold small">Sustained Focus & Concentration Span</span>
                            <span class="fw-bold text-info small">12 mins ➔ 45 mins</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 90%"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" id="testimonials">
                    <div class="card p-4 rounded-4 border-0 shadow-sm bg-white mb-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-primary-subtle text-primary fw-bold rounded-circle p-3 text-center" style="width:48px;height:48px;">
                                RS
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Rajesh Sharma</h6>
                                <small class="text-muted">Parent of Aarav (10 yrs) & Ananya (8 yrs) - Noida</small>
                            </div>
                        </div>
                        <div class="text-warning mb-2">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-secondary small mb-0 fst-italic">
                            "Aarav was struggling to memorize textbook chapters for his 5th standard exams and would get exhausted. Within 4 weeks of Photographic Memory Training at Talent Gurukul, his confidence skyrocketed! The parent portal is also fantastic to check his daily class progress."
                        </p>
                    </div>

                    <div class="card p-4 rounded-4 border-0 shadow-sm bg-white">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-info-subtle text-info fw-bold rounded-circle p-3 text-center" style="width:48px;height:48px;">
                                MD
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Manoj Deshmukh</h6>
                                <small class="text-muted">Parent of Reyansh (11 yrs) - South Delhi</small>
                            </div>
                        </div>
                        <div class="text-warning mb-2">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="text-secondary small mb-0 fst-italic">
                            "The DMIT profiling accurately identified Reyansh's visual-spatial brain strength. The trainers are deeply committed and patient. Highly recommended for every parent who wants to discover their child's true gift!"
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Footer -->
    <footer class="bg-dark text-white pt-5 pb-4" style="background:#0f172a !important;">
        <div class="container">
            <div class="row g-4 pb-4 border-bottom border-secondary border-opacity-25">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <h5 class="fw-bold mb-0">TALENT GURUKUL INDIA</h5>
                    </div>
                    <p class="text-secondary small mb-3">
                        Transforming education through cognitive empowerment, sensory integration, and right-brain photographic memory methods.
                    </p>
                    <div class="text-secondary small">
                        <i class="bi bi-shield-check text-success me-1"></i> ISO Certified Pedagogical Framework
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <h6 class="fw-bold text-uppercase text-light mb-3" style="font-size:0.8rem; letter-spacing:0.5px;">Centres & Branches</h6>
                    <div class="small text-secondary mb-2">
                        <strong class="text-light">Head Office:</strong> Sector 62, Institutional Area, Noida - 201309
                    </div>
                    <div class="small text-secondary mb-2">
                        <strong class="text-light">Delhi Centre:</strong> Green Park Main Market, South Delhi - 110016
                    </div>
                    <div class="small text-secondary mb-2">
                        <strong class="text-light">Lucknow Hub:</strong> Gomti Nagar, Lucknow - 226010
                    </div>
                    <div class="small text-secondary">
                        <i class="bi bi-envelope text-info me-1"></i> info@talentgurukulindia.com
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <h6 class="fw-bold text-uppercase text-light mb-3" style="font-size:0.8rem; letter-spacing:0.5px;">System Portals</h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="{{ route('crm.dashboard') }}" class="footer-link"><i class="bi bi-speedometer2 me-2"></i>Staff CRM Management Portal</a></li>
                        <li><a href="{{ route('parent.dashboard') }}" class="footer-link"><i class="bi bi-person-heart me-2"></i>Parent Student Portal</a></li>
                        <li><a href="{{ route('login') }}" class="footer-link"><i class="bi bi-lock me-2"></i>Employee Authentication</a></li>
                        <li><a href="{{ route('setup.index') }}" class="footer-link text-warning"><i class="bi bi-database-gear me-2"></i>One-Click Live Database Setup Route</a></li>
                    </ul>
                </div>
            </div>

            <div class="d-flex flex-wrap justify-content-between align-items-center pt-4 small text-secondary">
                <div>© {{ date('Y') }} Talent Gurukul India. All Rights Reserved.</div>
                <div>Designed & Engineered with Laravel & Tailwind/Bootstrap UI</div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Success Modal if Enquiry Submitted -->
    @if(session('success_modal'))
        <div class="modal fade show d-block" id="successModal" tabindex="-1" style="background: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 p-4 text-center">
                    <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px; font-size: 2rem;">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <h4 class="fw-bold mb-2">{{ session('success_modal')['title'] }}</h4>
                    <p class="text-secondary small mb-4">{{ session('success_modal')['message'] }}</p>
                    
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('home') }}" class="btn btn-light border rounded-pill px-4">Close</a>
                        <a href="{{ route('crm.leads.show', session('success_modal')['lead_id']) }}" class="btn btn-primary rounded-pill px-4" style="background:#1e3a8a;">
                            View Lead in CRM <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

</body>
</html>
