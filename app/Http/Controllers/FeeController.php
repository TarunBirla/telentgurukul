<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentInvoice;
use App\Models\StudentPayment;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\Enrolment;
use App\Models\CommunicationLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentInvoice::with(['student.parent', 'enrolment.course', 'payments']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest()->paginate(15);
        $totalBilled = StudentInvoice::sum('final_payable');
        $totalCollected = StudentPayment::sum('amount');
        $totalOutstanding = StudentInvoice::sum('balance_due');

        return view('crm.fees.index', compact('invoices', 'totalBilled', 'totalCollected', 'totalOutstanding'));
    }

    public function payments()
    {
        $payments = StudentPayment::with(['student', 'parent', 'invoice', 'collector'])->latest()->paginate(15);
        return view('crm.fees.payments', compact('payments'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'student_invoice_id' => 'required|exists:student_invoices,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
        ]);

        $invoice = StudentInvoice::with('student.parent', 'enrolment')->findOrFail($request->student_invoice_id);

        $amount = min($request->amount, $invoice->balance_due);
        $receiptNumber = 'RCP-' . date('Y') . '-' . str_pad(StudentPayment::count() + 1, 4, '0', STR_PAD_LEFT);

        $payment = StudentPayment::create([
            'receipt_number' => $receiptNumber,
            'student_invoice_id' => $invoice->id,
            'enrolment_id' => $invoice->enrolment_id,
            'student_id' => $invoice->student_id,
            'parent_id' => $invoice->parent_id,
            'amount' => $amount,
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'transaction_reference' => $request->transaction_reference,
            'collected_by_user_id' => Auth::id(),
            'notes' => $request->notes,
        ]);

        // Update invoice balance
        $invoice->paid_amount += $amount;
        $invoice->balance_due = max(0, $invoice->final_payable - $invoice->paid_amount);

        if ($invoice->balance_due == 0) {
            $invoice->status = 'paid';
        } else {
            $invoice->status = 'partially_paid';
        }
        $invoice->save();

        // Update enrolment
        if ($invoice->enrolment) {
            $enrol = $invoice->enrolment;
            $enrol->paid_amount += $amount;
            $enrol->due_balance = max(0, $enrol->final_payable - $enrol->paid_amount);
            $enrol->save();
        }

        // Send WhatsApp Payment Receipt Confirmation
        if ($invoice->student && $invoice->student->parent) {
            $parent = $invoice->student->parent;
            CommunicationLog::create([
                'channel' => 'whatsapp',
                'recipient_type' => 'parent',
                'recipient_id' => $parent->id,
                'recipient_phone_or_email' => $parent->primary_mobile,
                'template_name' => 'payment_receipt',
                'message_content' => "Dear {$parent->father_name}, payment of ₹" . number_format($amount, 2) . " received for {$invoice->student->first_name} (Receipt #{$receiptNumber}). Outstanding Balance: ₹" . number_format($invoice->balance_due, 2) . ". Thank you! Talent Gurukul India.",
                'status' => 'sent',
                'sent_by_user_id' => Auth::id(),
            ]);
        }

        return back()->with('success', "Payment of ₹" . number_format($amount, 2) . " recorded successfully! Receipt #{$receiptNumber} generated.");
    }

    public function receipt($id)
    {
        $payment = StudentPayment::with(['student.parent', 'invoice.enrolment.course', 'collector'])->findOrFail($id);
        return view('crm.fees.receipt', compact('payment'));
    }
}
