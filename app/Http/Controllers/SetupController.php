<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;
use App\Models\Student;
use App\Models\Lead;
use App\Models\Course;

class SetupController extends Controller
{
    public function index()
    {
        $dbConnected = false;
        $dbError = null;
        $connectionType = config('database.default');

        try {
            DB::connection()->getPdo();
            $dbConnected = true;
        } catch (\Exception $e) {
            $dbError = $e->getMessage();
        }

        $phpVersion = PHP_VERSION;
        $sqliteAvailable = extension_loaded('pdo_sqlite');
        $mysqlAvailable = extension_loaded('pdo_mysql');
        
        $stats = [
            'users' => 0,
            'leads' => 0,
            'students' => 0,
            'courses' => 0,
        ];

        if ($dbConnected) {
            try {
                $stats['users'] = User::count();
                $stats['leads'] = Lead::count();
                $stats['students'] = Student::count();
                $stats['courses'] = Course::count();
            } catch (\Exception $e) {
                // tables might not exist yet
            }
        }

        return view('setup.index', compact(
            'dbConnected',
            'dbError',
            'connectionType',
            'phpVersion',
            'sqliteAvailable',
            'mysqlAvailable',
            'stats'
        ));
    }

    public function run(Request $request)
    {
        try {
            // If using SQLite and file doesn't exist, create it
            if (config('database.default') === 'sqlite') {
                $dbPath = database_path('database.sqlite');
                if (!File::exists($dbPath)) {
                    File::put($dbPath, '');
                }
            }

            // Run migrations with force flag
            Artisan::call('migrate:fresh', ['--force' => true]);
            $migrateOutput = Artisan::output();

            // Run seeder with force flag
            Artisan::call('db:seed', ['--force' => true]);
            $seedOutput = Artisan::output();

            // Clear cache
            Artisan::call('optimize:clear');

            $userCount = User::count();
            $studentCount = Student::count();
            $leadCount = Lead::count();
            $courseCount = Course::count();

            return view('setup.success', [
                'success' => true,
                'migrateOutput' => $migrateOutput,
                'seedOutput' => $seedOutput,
                'userCount' => $userCount,
                'studentCount' => $studentCount,
                'leadCount' => $leadCount,
                'courseCount' => $courseCount,
            ]);
        } catch (\Exception $e) {
            return view('setup.error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
