<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Academics\University;
use App\Models\Academics\Course;
use App\Models\Academics\Department;
use App\Models\Academics\SubCourse;
use App\Models\Academics\Subject;
use App\Models\StudentLedger;
use App\Models\UniversityFees;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents          = Student::count();
        $newStudentsThisMonth   = Student::whereMonth('created_at', now()->month)->count();
        $totalCourses           = Course::count();
        $activeCourses          = Course::where('status', true)->count();
        $totalSubCourses        = SubCourse::count();
        $totalSubjects          = Subject::count();
        $totalRevenue           = StudentLedger::sum('amount');
        $monthlyRevenue         = $this->getMonthlyRevenue();
        $monthlyUniversityFees  = $this->getMonthlyUniversityFees();
        $revenueGrowth          = $this->getRevenueGrowth();
        $totalUniversities      = University::count();
        $totalDepartments       = Department::count();
        $recentStudents         = Student::with(['subCourse', 'academicYear'])
                                        ->latest()
                                        ->take(5)
                                        ->get();
        $courseDistribution     = $this->getCourseDistribution();
        $universities           = University::withCount('departments')->take(4)->get();

        return view('content.home', compact(
            'totalStudents',
            'newStudentsThisMonth',
            'totalCourses',
            'activeCourses',
            'totalSubCourses',
            'totalSubjects',
            'totalRevenue',
            'monthlyRevenue',
            'monthlyUniversityFees',
            'revenueGrowth',
            'totalUniversities',
            'totalDepartments',
            'recentStudents',
            'courseDistribution',
            'universities'
        ));
    }

    private function getMonthlyRevenue()
    {
        $rows = StudentLedger::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[] = $rows[$m] ?? 0;
        }

        return $months;
    }

    private function getMonthlyUniversityFees()
    {
        $rows = UniversityFees::selectRaw('MONTH(date) as month, SUM(amount) as total')
            ->whereYear('date', now()->year)
            ->where('status', 'success')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[] = $rows[$m] ?? 0;
        }

        return $months;
    }

    private function getRevenueGrowth()
    {
        $current = StudentLedger::whereMonth('created_at', now()->month)->sum('amount');
        $last    = StudentLedger::whereMonth('created_at', now()->subMonth()->month)->sum('amount');
        return $last > 0 ? (($current - $last) / $last) * 100 : 0;
    }

    private function getCourseDistribution()
    {
        $rows = Student::selectRaw('sub_courses.name as course_name, COUNT(*) as count')
            ->join('sub_courses', 'students.sub_course_id', '=', 'sub_courses.id')
            ->groupBy('sub_courses.name')
            ->orderByDesc('count')
            ->get();

        return [
            'labels' => $rows->pluck('course_name')->toArray(),
            'counts' => $rows->pluck('count')->map(fn($v) => (int)$v)->toArray(),
        ];
    }
}
