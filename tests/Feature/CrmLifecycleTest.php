<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentPayment;
use App\Models\Certificate;
use App\Models\Lead;

class CrmLifecycleTest extends TestCase
{
    public function test_frontend_landing_page_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('TALENT GURUKUL INDIA', false);
        $response->assertSee('Photographic Memory', false);
    }

    public function test_frontend_enquiry_form_submission_creates_lead()
    {
        $response = $this->post('/enquiry', [
            'parent_name' => 'Sunil Grover',
            'student_name' => 'Ritik Grover',
            'mobile' => '9876598765',
            'student_age' => 11,
            'course_interest' => 'Photographic Memory Training',
            'city' => 'Noida',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('leads', [
            'parent_name' => 'Sunil Grover',
            'mobile' => '9876598765',
            'course_interest' => 'Photographic Memory Training',
        ]);
    }

    public function test_setup_installer_route_loads()
    {
        $response = $this->get('/setup');
        $response->assertStatus(200);
        $response->assertSee('Live Server Database', false);
    }

    public function test_crm_dashboard_loads()
    {
        $user = User::where('role', 'admin')->first();
        $response = $this->actingAs($user)->get('/crm/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Business & Operations Dashboard', false);
    }

    public function test_lead_management_and_pipeline_loads()
    {
        $user = User::where('role', 'admin')->first();
        $response = $this->actingAs($user)->get('/crm/leads');
        $response->assertStatus(200);
        $response->assertSee('All Enquiries', false);

        $pipelineResponse = $this->actingAs($user)->get('/crm/leads/pipeline');
        $pipelineResponse->assertStatus(200);
        $pipelineResponse->assertSee('Visual Lead Pipeline', false);
    }

    public function test_student_and_parent_portal_loads()
    {
        $user = User::where('role', 'admin')->first();
        $response = $this->actingAs($user)->get('/crm/students');
        $response->assertStatus(200);

        $student = Student::first();
        $studentShow = $this->actingAs($user)->get('/crm/students/' . $student->id);
        $studentShow->assertStatus(200);

        $parentResponse = $this->get('/parent/dashboard');
        $parentResponse->assertStatus(200);
        $parentResponse->assertSee('Parent Dashboard', false);
    }

    public function test_payment_receipt_and_certificate_views()
    {
        $payment = StudentPayment::first();
        if ($payment) {
            $receiptResponse = $this->get('/crm/fees/receipt/' . $payment->id);
            $receiptResponse->assertStatus(200);
            $receiptResponse->assertSee('Official Fee Receipt', false);
        }

        $certificate = Certificate::first();
        if ($certificate) {
            $certResponse = $this->get('/crm/progress/certificate/' . $certificate->id);
            $certResponse->assertStatus(200);
            $certResponse->assertSee('CERTIFICATE OF EXCELLENCE', false);
        }
    }
}
