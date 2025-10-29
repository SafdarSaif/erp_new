<?php

namespace App\Http\Controllers;

use App\Models\StudentQuery;
use Illuminate\Http\Request;
use App\Models\Settings\QueryHead;
use App\Models\Student;

class StudentQueryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }

    public function index()
    {
        $queryHeads = QueryHead::where('status', 1)->get();
        return view('studentquery.create', compact('queryHeads'));
    }

    public function fetchStudent(Request $request)
    {
        $student = Student::where('student_id', $request->student_id)->first();

        if (!$student) {
            return response()->json(['status' => 'error', 'message' => 'Student not found!']);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'student_id' => $student->student_id,
                'name' => $student->name,
                'email' => $student->email,
                'mobile' => $student->mobile
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'query_head_id' => 'required|exists:query_heads,id',
            'query' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048'
        ]);

        $path = $request->hasFile('attachment')
            ? $request->file('attachment')->store('student_queries', 'public')
            : null;

        StudentQuery::create([
            'student_id' => $request->student_id,
            'query_head_id' => $request->query_head_id,
            'query' => $request->query,
            'attachment' => $path,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Your query has been submitted successfully!']);
    }

    public function view($student_id)
    {
        $queries = StudentQuery::where('student_id', $student_id)
            ->with(['queryHead'])
            ->latest()
            ->get();

        $student = Student::where('student_id', $student_id)->first();

        return view('studentquery.view', compact('queries', 'student'));
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
