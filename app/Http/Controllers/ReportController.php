<?php

namespace App\Http\Controllers;

use App\Models\Academics\Course;
use App\Models\Academics\Department;
use App\Models\Academics\SubCourse;
use App\Models\Academics\University;
use App\Models\Report;
use App\Models\Settings\AcademicYear;
use App\Models\Settings\AdmissionMode;
use App\Models\Settings\BloodGroup;
use App\Models\Settings\Category;
use App\Models\Settings\CourseMode;
use App\Models\Settings\CourseType;
use App\Models\Settings\Language;
use App\Models\Settings\Religion;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function studentReport(){
        try{
           if (request()->ajax()) {
                // Load related department and course type
                $data = Report::all();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('created_at', function ($report) {
                        return Carbon::parse($report->created_at)->format('Y-m-d');
                    })
                    ->make(true);
            }
            return view('reports.student');
        }catch(Exception $e){
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function createStudentReport(){
        $universities = University::all();
        $departments = Department::all();
        $courses = Course::all();
        $subCourses = SubCourse::all();
        $academicYears = AcademicYear::all();
        $admissionModes = AdmissionMode::all();
        $courseModes = CourseMode::all();
        $bloodGroups = BloodGroup::all();
        $categories = Category::all();
        $courseTypes = CourseType::all();
        $languages = Language::all();
        $religions = Religion::all();
        return view('reports.create',compact('universities','departments','courses','subCourses','academicYears','admissionModes','courseModes','bloodGroups','categories','courseTypes','languages','religions'));
    }
}
