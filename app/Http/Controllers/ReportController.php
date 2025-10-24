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
use App\Models\Student;
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

    public function storeStudentReport(Request $request){
        try{
            $storeData['for'] = "students";
            $storeData['name'] = $request->tag;
            $request->request->remove('tag');
            $request->request->remove('_token');
            $storeData['filter'] = json_encode($request->all());
            $store = Report::create($storeData);
            return response()->json([
                'status'=>'success',
                'message'=>'Report Generated go to report and download',
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>'error',
                'message'=>$e->getMessage(),
            ]);
        }
    }

    public function viewStudentReport(Request $request,$id){
        try{
            $report = Report::findOrFail($id);
            $filter = json_decode($report->filter,true);
            $student = new Student();
            foreach($filter as $column => $value){
                $student->where($column,$value);
            }
            $students = $student->get();
            if (request()->ajax()) {
                return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('academic_year', fn($row) => $row->academicYear?->name ?? '-')
                ->addColumn('university', fn($row) => $row->university?->name ?? '-')
                ->addColumn('course_type', fn($row) => $row->courseType?->name ?? '-')
                ->addColumn('course', fn($row) => $row->course?->name ?? '-')
                ->addColumn('sub_course', fn($row) => $row->subCourse?->name ?? '-')
                ->addColumn('mode', fn($row) => $row->mode?->name ?? '-')
                ->addColumn('course_mode', fn($row) => $row->courseMode?->name ?? '-')
                ->addColumn('language', fn($row) => $row->language?->name ?? '-')
                ->addColumn('blood_group', fn($row) => $row->bloodGroup?->name ?? '-')
                ->addColumn('religion', fn($row) => $row->religion?->name ?? '-')
                ->addColumn('category', fn($row) => $row->category?->name ?? '-')
                ->editColumn('status', fn($row) => $row->status ? 1 : 0)
                ->filter(function ($query) use ($request) {

                    // 🔍 Filter by Full Name
                    if (!empty($request->columns[1]['search']['value'])) {
                        $query->where('full_name', 'like', '%' . $request->columns[1]['search']['value'] . '%');
                    }

                    // 🔍 Filter by Email
                    if (!empty($request->columns[2]['search']['value'])) {
                        $query->where('email', 'like', '%' . $request->columns[2]['search']['value'] . '%');
                    }

                    // 🔍 Filter by Mobile
                    if (!empty($request->columns[3]['search']['value'])) {
                        $query->where('mobile', 'like', '%' . $request->columns[3]['search']['value'] . '%');
                    }

                    // 🔍 Filter by Academic Year
                    if (!empty($request->columns[4]['search']['value'])) {
                        $query->whereHas('academicYear', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[4]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by University
                    if (!empty($request->columns[5]['search']['value'])) {
                        $query->whereHas('university', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[5]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by Course Type
                    if (!empty($request->columns[6]['search']['value'])) {
                        $query->whereHas('courseType', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[6]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by Course
                    if (!empty($request->columns[7]['search']['value'])) {
                        $query->whereHas('course', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[7]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by Sub Course
                    if (!empty($request->columns[8]['search']['value'])) {
                        $query->whereHas('subCourse', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[8]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by Mode
                    if (!empty($request->columns[9]['search']['value'])) {
                        $query->whereHas('mode', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[9]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by Course Mode
                    if (!empty($request->columns[10]['search']['value'])) {
                        $query->whereHas('courseMode', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[10]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by Language
                    if (!empty($request->columns[11]['search']['value'])) {
                        $query->whereHas('language', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[11]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by Blood Group
                    if (!empty($request->columns[12]['search']['value'])) {
                        $query->whereHas('bloodGroup', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[12]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by Religion
                    if (!empty($request->columns[13]['search']['value'])) {
                        $query->whereHas('religion', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[13]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by Category
                    if (!empty($request->columns[14]['search']['value'])) {
                        $query->whereHas('category', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->columns[14]['search']['value'] . '%');
                        });
                    }

                    // 🔍 Filter by Status
                    if (isset($request->columns[15]['search']['value']) && $request->columns[15]['search']['value'] !== '') {
                        $query->where('status', $request->columns[15]['search']['value']);
                    }
                })
                ->make(true);
            }
            return view('reports.student_list',[
                'academicYears' => AcademicYear::all(),
                'universities' => University::all(),
                'courseTypes' => CourseType::all(),
                'courses' => Course::all(),
                'subCourses' => SubCourse::all(),
                'modes' => AdmissionMode::all(),
                'courseModes' => CourseMode::all(),
                'languages' => Language::all(),
                'bloodGroups' => BloodGroup::all(),
                'religions' => Religion::all(),
                'categories' => Category::all(),
                'id' => $id
            ]);
        }catch(\Exception $e){
            response()->json([
                'status'=>'error',
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function incomeReport(){
        $universities = University::all();
        return view('reports.income',compact('universities'));
    }
    public function expenceReport(){

        return view('reports.expence');
    }

    public function getIncome(Request $request){
        $dates = json_decode($request->daterange);
        $mode = $request->mode;
        $university = $request->university;
        $universityUsers = Student::where('university_id',$university)->pluck('id');
        dd($universityUsers);
    }
}
