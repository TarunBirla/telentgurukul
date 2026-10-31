# Talent Gurukul India – Complete Student Lifecycle CRM & Frontend

A custom, end-to-end **Student Admission, Counselling, Course Management, Fee Management, Progress Tracking, and Parent Relationship CRM** built with **Laravel 10**, **PHP 8.1+**, **Bootstrap 5.3 CDN**, and **Bootstrap Icons CDN**.

Designed specifically for **Talent Gurukul India**'s children's brain development programs:
- **Photographic Memory Training**
- **Midbrain Activation Program**
- **DMIT & Brain Profiling Counselling**
- **NLP & Mnemonics for Kids**
- **Speed Reading & Quantum Comprehension**
- **Vedic Maths & Lightning Calculations**

---

## 🚀 Live Server One-Click Database Setup Route

When deploying to **any live hosting (cPanel, Shared Hosting, VPS, Cloud)** without command-line access, simply hit:

```
http://your-domain.com/setup
```
or 
```
http://your-domain.com/install
```
or directly trigger:
```
http://your-domain.com/setup/run
```

This route automatically:
1. Creates the database (SQLite or uses your configured MySQL database).
2. Runs all 14+ database migrations with `--force`.
3. Seeds complete realistic demo records (Leads across all stages, appointments, students, parents, multi-child relationships, courses, batches, attendances, fee invoices, receipts, before/after assessments, certificates, WhatsApp communication logs, and audit trails).
4. Clears and optimizes application cache.
5. Displays a summary report with 1-click direct login buttons!

---

## 🔑 Default Login Credentials

| Role | Email | Password | Responsibilities |
|---|---|---|---|
| **Super Admin / Director** | `admin@talentgurukul.com` | `password` | Complete system access, financial summaries & overview |
| **Sr. Brain Counsellor** | `counsellor@talentgurukul.com` | `password` | Leads, calls, pipeline, counselling slots & outcome notes |
| **Admission Executive** | `admissions@talentgurukul.com` | `password` | Student registrations, onboarding & document verification |
| **Accounts Head** | `accounts@talentgurukul.com` | `password` | Fee invoices, installment plans, payments & receipts |
| **Lead Brain Trainer** | `trainer@talentgurukul.com` | `password` | Batches, class schedules, attendance & assessments |
| **Parent Portal** | `parent@gmail.com` | `password` | Dedicated parent dashboard for multiple linked children |

> **Tip:** The login page (`/login`) also includes a **1-click Role Switcher** to quickly test any employee role or parent portal with zero typing!

---

## 🌟 Modules Implemented

### 1. Frontend Landing Page (`/`)
- Pure, clean aesthetic with Talent Gurukul branding.
- Hero section with key metrics (5,000+ students, 3x recall speed).
- Interactive **Free Brain Counselling Booking Form** on the page that automatically creates a lead in the CRM database and logs an automated WhatsApp acknowledgement.
- Programs grid, multi-course bundles, before-and-after results, and parent testimonials.
- Direct links to **Staff CRM** and **Parent Portal**.

### 2. Business Dashboard & KPIs (`/crm/dashboard`)
- 10+ Real-time cards: Total Enquiries, New Leads Today, Follow-ups Due, Counselling Scheduled, Admissions Completed, Active Students, Fees Collected, Outstanding Balance, Upcoming Classes, Conversion Rate.
- Interactive Chart.js charts: Lead Sources breakdown & Course-wise registrations.
- Today's due follow-up tasks and upcoming counselling appointments.

### 3. Lead Management & Visual Pipeline (`/crm/leads`, `/crm/leads/pipeline`, `/crm/leads/followups`)
- All leads table with filters by status, source, counsellor, search.
- **Kanban Pipeline Board**: Drag-and-drop or 1-click move between stages (`New Enquiry`, `Contact Pending`, `Contacted`, `Interested`, `Counselling Scheduled`, `Follow-up Due`, `Admission Confirmed`, `Lost Lead`).
- Duplicate mobile number detection.
- **Lead 360 View (`/crm/leads/{id}`)**: Chronological activity timeline, call logs, counsellor reassignment, and direct **"Convert to Student"** action.

### 4. Counselling & Appointments (`/crm/counselling`)
- Daily/upcoming appointment calendar.
- Offline centre visit & Online video session modes.
- Record session notes: parent concerns, child interests, recommended program, admission probability (0-100%), counsellor remarks, next follow-up.

### 5. Parent & Student Management (`/crm/students`, `/crm/students/parents`)
- **Multiple children under one parent architecture**: Unified parent profile linked to multiple child records (e.g., Rajesh Sharma -> Aarav Sharma & Ananya Sharma).
- Student 360 profile with complete lifecycle history, documents, enrolled programs, attendance rate, fee ledger, and assessments.

### 6. Courses & Multi-Course Bundles (`/crm/courses`)
- Configurable courses with session count, session minutes, fees, batch capacities, and certification eligibility.
- Course package bundles with original fees, discounted fees, and savings calculator.

### 7. Batches & Attendance Sheet (`/crm/batches`, `/crm/batches/{id}`)
- Batch management: batch code, timings, days of the week, trainer allocation, and capacity limits.
- Class scheduling: session topics, date, homework assignment.
- **Interactive Daily Attendance Marking**: Mark Present / Absent / Late / Leave for all batch students with 1-click submit.

### 8. Fee Ledgers, Payments & Receipts (`/crm/fees`, `/crm/fees/payments`, `/crm/fees/receipt/{id}`)
- Course fee invoices, discounts, installments, and outstanding balance tracking.
- Collect payment modal (Cash, UPI, Bank Transfer, Card).
- **Printable / Downloadable Official Payment Receipt** with company header, receipt number, student ID, and authorized stamp.

### 9. Cognitive Progress & Certificates (`/crm/progress`, `/crm/progress/report/{id}`, `/crm/progress/certificate/{id}`)
- Before-and-after assessment evaluation (Memory score, concentration score, reading speed WPM, recall accuracy %, trainer remarks).
- **Visual Progress Comparison Report** for parents.
- **Printable Certificate of Excellence** with golden foil border, grade distinction, and director signature.

### 10. Dedicated Parent Portal (`/parent/dashboard`)
- Independent parent login.
- View linked children, courses enrolled, class attendance %, payment receipts, progress reports, and certificates.
- Submit trainer feedback or batch scheduling requests.

### 11. WhatsApp & Multi-Channel Communication (`/crm/communication`)
- Pre-built templates for Enquiry acknowledgement, Counselling reminder, Payment confirmation, Fee due reminder, Upcoming class reminder, Course completion.
- Outbound dispatch audit log.

### 12. Marketing Analytics & System Settings (`/crm/reports`, `/crm/settings`)
- Marketing channels ROI (Instagram, Facebook, Google Ads, Website, Referrals) with conversion percentages.
- Counsellor performance tracking.
- Employees, roles, branches, and system audit trail logs.

---

## 💻 Running Locally

1. Start the Laravel development server:
   ```bash
   php artisan serve
   ```
2. Open your browser:
   - **Frontend Landing Page:** `http://127.0.0.1:8000`
   - **CRM Dashboard:** `http://127.0.0.1:8000/crm`
   - **Parent Portal:** `http://127.0.0.1:8000/parent/dashboard`
   - **Database Setup Wizard:** `http://127.0.0.1:8000/setup`
"# telentgurukul" 
