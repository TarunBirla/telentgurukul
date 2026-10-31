<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'parent') {
                return redirect()->route('parent.dashboard');
            }
            return redirect()->route('crm.dashboard');
        }

        $roles = [
            'admin' => [
                'email' => 'admin@talentgurukul.com',
                'title' => 'Super Admin / Director',
                'desc' => 'Full system configuration, financial overviews & management',
                'icon' => 'bi-shield-check',
                'badge' => 'bg-danger text-white'
            ],
            'counsellor' => [
                'email' => 'counsellor@talentgurukul.com',
                'title' => 'Sr. Brain Counsellor',
                'desc' => 'Leads, calls, pipeline, appointments & counselling notes',
                'icon' => 'bi-headset',
                'badge' => 'bg-primary text-white'
            ],
            'admission_executive' => [
                'email' => 'admissions@talentgurukul.com',
                'title' => 'Admission Executive',
                'desc' => 'Registrations, student profile onboarding, document checks',
                'icon' => 'bi-person-check',
                'badge' => 'bg-info text-dark'
            ],
            'accountant' => [
                'email' => 'accounts@talentgurukul.com',
                'title' => 'Accounts Head',
                'desc' => 'Fees, installments, payment collection, receipts & ledgers',
                'icon' => 'bi-wallet2',
                'badge' => 'bg-success text-white'
            ],
            'trainer' => [
                'email' => 'trainer@talentgurukul.com',
                'title' => 'Brain Trainer',
                'desc' => 'Batches, class schedule, attendance & assessment reports',
                'icon' => 'bi-mortarboard',
                'badge' => 'bg-warning text-dark'
            ],
            'parent' => [
                'email' => 'parent@gmail.com',
                'title' => 'Parent Portal',
                'desc' => 'Track multiple children, attendance %, fee receipts & progress',
                'icon' => 'bi-people',
                'badge' => 'bg-purple text-white'
            ],
        ];

        return view('auth.login', compact('roles'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'parent') {
                return redirect()->route('parent.dashboard');
            }
            return redirect()->route('crm.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function loginAs($role)
    {
        $user = User::where('role', $role)->first();
        if (!$user && $role === 'admin') {
            $user = User::first();
        }

        if ($user) {
            Auth::login($user);
            request()->session()->regenerate();
            if ($user->role === 'parent') {
                return redirect()->route('parent.dashboard')->with('success', 'Logged in as Parent: ' . $user->name);
            }
            return redirect()->route('crm.dashboard')->with('success', 'Logged in as ' . $user->name . ' (' . ucfirst($user->role) . ')');
        }

        return redirect()->route('login')->with('error', 'User role not found. Please run installer.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('info', 'You have been logged out.');
    }
}
