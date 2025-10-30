<?php

namespace App\Http\Controllers;

use App\Models\StudentQuery;
use Illuminate\Http\Request;
use App\Models\Settings\QueryHead;
use App\Models\Student;
use Yajra\DataTables\Facades\DataTables;

class StudentQueryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }

    public function index1(Request $request)
    {
        if ($request->ajax()) {
            $data = StudentQuery::with(['student', 'queryHead'])->select('student_queries.*');
            // dd($data);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('student_name', fn($q) => $q->student->full_name ?? '-')
                ->addColumn('query_head', fn($q) => $q->queryHead->name ?? '-')
                ->addColumn('status', fn($q) => $q->status)
                ->addColumn('action', fn($q) => '')
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('studentquery.index');
    }



   



    public function index()
    {
        $queryHeads = QueryHead::where('status', 1)->get();
        return view('studentquery.create', compact('queryHeads'));
    }

    // public function fetchStudent(Request $request)
    // {
    //     $student = Student::where('student_id', $request->student_id)->first();

    //     if (!$student) {
    //         return response()->json(['status' => 'error', 'message' => 'Student not found!']);
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => [
    //             'student_id' => $student->student_id,
    //             'name' => $student->name,
    //             'email' => $student->email,
    //             'mobile' => $student->mobile
    //         ]
    //     ]);
    // }

    public function fetchStudent(Request $request)
    {
        $student = Student::where('student_unique_id', $request->student_id)->first();
        // dd($student->email);

        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Student not found!']);
        }


        // dd($student);
        return response()->json([
            'status' => 'success',
            'data' => [
                'student_id' => $student->id,
                'name' => $student->full_name,
                'studentemail' => $student->email,
                'mobile' => $student->mobile,
            ]
        ]);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'student_id' => 'required|exists:students,id',
    //         'query_head_id' => 'required|exists:query_heads,id',
    //         'query' => 'required|string',
    //         'attachment' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048'
    //     ]);

    //     $path = $request->hasFile('attachment')
    //         ? $request->file('attachment')->store('student_queries', 'public')
    //         : null;

    //     StudentQuery::create([
    //         'student_id' => $request->student_id,
    //         'query_head_id' => $request->query_head_id,
    //         'query' => $request->query,
    //         'attachment' => $path,
    //     ]);

    //     return response()->json(['status' => 'success', 'message' => 'Your query has been submitted successfully!']);
    // }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'student_id' => 'required|exists:students,id',
    //         'query_head_id' => 'required|exists:query_heads,id',
    //         'query' => 'required|string',
    //         'attachment' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048'
    //     ]);

    //     // Get student details
    //     $student = Student::find($request->input('student_id'));

    //     if (!$student) {
    //         return response()->json(['status' => 'error', 'message' => 'Invalid student ID!']);
    //     }



    //     // Handle attachment upload (like your logo example)
    //     $attachmentPath = null;
    //     if ($request->hasFile('attachment')) {
    //         $file = $request->file('attachment');
    //         $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
    //         $file->move(public_path('uploads/student_queries'), $filename);
    //         $attachmentPath = 'uploads/student_queries/' . $filename;
    //     }
    //     // Create new record
    //     StudentQuery::create([
    //         'student_id'   => $student->id,
    //         'name'         => $student->full_name,
    //         'email'        => $student->email,
    //         'mobile'       => $student->mobile,
    //         'query_head_id' => $request->input('query_head_id'),
    //         'query'        => $request->input('query'),
    //         'attachment'   => $attachmentPath,
    //     ]);

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Your query has been submitted successfully!'
    //     ]);
    // }

    public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'query_head_id' => 'required|exists:query_heads,id',
        'query' => 'required|string',
        'attachment' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048'
    ]);

    // Get student details
    $student = Student::find($request->input('student_id'));

    if (!$student) {
        return response()->json(['status' => 'error', 'message' => 'Invalid student ID!']);
    }

    // Handle attachment upload
    $attachmentPath = null;
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $file->move(public_path('uploads/student_queries'), $filename);
        $attachmentPath = 'uploads/student_queries/' . $filename;
    }

    // Create new student query record
    StudentQuery::create([
        'student_id'    => $student->id,
        'added_by'      => $student->added_by, // 👈 Automatically linked to creator of student
        'name'          => $student->full_name,
        'email'         => $student->email,
        'mobile'        => $student->mobile,
        'query_head_id' => $request->input('query_head_id'),
        'query'         => $request->input('query'),
        'attachment'    => $attachmentPath,
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Your query has been submitted successfully!'
    ]);
}



    // public function view($student_id)
    // {
    //     $queries = StudentQuery::where('student_id', $student_id)
    //         ->with(['queryHead'])
    //         ->latest()
    //         ->get();

    //     $student = Student::where('student_id', $student_id)->first();

    //     return view('studentquery.view', compact('queries', 'student'));
    // }


    public function viewQueries($studentId)
{
    $student = Student::find($studentId);
    $queries = StudentQuery::with('queryHead')->where('student_id', $studentId)->get();

    return view('studentquery.view', compact('student', 'queries'));
}




    // public function answer($id)
    // {
    //     $query = StudentQuery::with(['student', 'queryHead'])->findOrFail($id);

    //     return view('studentquery.answer', compact('query'));
    // }

    public function answer($id)
{
    $query = StudentQuery::with(['student', 'queryHead'])->findOrFail($id);
    return view('studentquery.answer', compact('query'));
}




    public function storeAnswer(Request $request, $id)
    {
        $request->validate([
            'answer' => 'required|string|max:5000'
        ]);

        $query = StudentQuery::findOrFail($id);
        $query->answer = $request->input('answer');
        $query->status = 1; // Mark as answered
        // $query->answered_by = auth()->id();
        $query->answered_at = now();
        $query->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Answer submitted successfully!'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(StudentQuery $studentQuery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentQuery $studentQuery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentQuery $studentQuery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StudentQuery $studentQuery)
    {
        //
    }
}
