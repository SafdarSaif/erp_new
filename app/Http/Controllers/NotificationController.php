<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Academics\University;
use App\Models\Academics\Subcourse;
use App\Models\NotificationTarget;
use App\Models\Student;
use App\Mail\SendNotificationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendNotificationJob;
use Illuminate\Support\Facades\Validator;


class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $notifications = Notification::with(['header', 'creator'])->orderBy('id', 'desc');

            return datatables()->of($notifications)
                ->addIndexColumn()
                ->addColumn('header_name', function ($row) {
                    return $row->header ? $row->header->name : '-';
                })
                ->addColumn('creator_name', function ($row) {
                    return $row->creator ? $row->creator->name : '-';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<button class="btn btn-sm btn-light-primary" onclick="edit(\'' . route('notifications.edit', $row->id) . '\', \'modal-lg\')">
                                <i class="ri-pencil-line"></i>
                            </button>';
                    $buttons .= '<button class="btn btn-sm btn-light-danger delete-item" onclick="destry(\'' . route('notifications.destroy', $row->id) . '\', \'notifications-table\')">
                                <i class="ri-delete-bin-line"></i>
                             </button>';
                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $headers = \App\Models\Settings\NotificationHeader::where('status', 1)->get();
        $users = User::get();
        $years = \App\Models\Settings\AcademicYear::all();
        $universities = \App\Models\Academics\University::all();
        $subcourses = \App\Models\Academics\Subcourse::all();

        return view('notification.index', compact('headers', 'users', 'years', 'universities', 'subcourses'));
    }



    /**
     * Show the form for creating a new resource.
     */
    //    public function create()
    // {
    //     $headers = \App\Models\Settings\NotificationHeader::where('status', 1)->get();
    //     $users = User::get();
    //     $years = \App\Models\Settings\AcademicYear::all();
    //     $universities = \App\Models\Academics\University::all();
    //     $subcourses = \App\Models\Academics\Subcourse::all();

    //     return view('notification.create', compact('headers', 'users', 'years', 'universities', 'subcourses'));
    // }




    /**
     * Fetch students based on filters for AJAX.
     */


    // public function fetchStudents(Request $request)
    // {
    //     $query = \App\Models\Student::query();

    //     // FILTERS ------------------------

    //     if ($request->academic_year) {
    //         $query->where('academic_year_id', $request->academic_year);
    //     }

    //     if ($request->university_id) {
    //         $query->where('university_id', $request->university_id);
    //     }

    //     if ($request->subcourse_id) {
    //         $query->where('sub_course_id', $request->subcourse_id);
    //     }

    //     // FINAL STUDENT LIST
    //     $students = $query->where('status', 1)->get();

    //     // DYNAMIC UNIVERSITIES FILTER
    //     $universities = \App\Models\Student::select('university_id')
    //         ->where('academic_year_id', $request->academic_year)
    //         ->distinct()
    //         ->with('university')
    //         ->get()
    //         ->map(fn($u) => [
    //             'id' => $u->university_id,
    //             'name' => $u->university->name
    //         ]);

    //     // DYNAMIC SUBCOURSE FILTER
    //     $subcourses = \App\Models\Student::select('sub_course_id')
    //         ->when($request->academic_year, fn($q) => $q->where('academic_year_id', $request->academic_year))
    //         ->when($request->university_id, fn($q) => $q->where('university_id', $request->university_id))
    //         ->distinct()
    //         ->with('subcourse')
    //         ->get()
    //         ->map(fn($s) => [
    //             'id' => $s->sub_course_id,
    //             'name' => $s->subcourse->name
    //         ]);

    //     return response()->json([
    //         'students'     => $students->map(fn($s) => [
    //             'id' => $s->id,
    //             'name' => $s->full_name,
    //             'email' => $s->email
    //         ]),
    //         'universities' => $universities,
    //         'subcourses'   => $subcourses,
    //     ]);
    // }


    public function create()
    {
        $headers = \App\Models\Settings\NotificationHeader::where('status', 1)->get();
        $users = User::get();
        $years = \App\Models\Settings\AcademicYear::all();
        $universities = \App\Models\Academics\University::all();
        $subcourses = \App\Models\Academics\Subcourse::all();

        return view('notification.create', compact('headers', 'users', 'years', 'universities', 'subcourses'));
    }



    /**
     * Fetch Students + Dependent Filters (AJAX)
     */


    public function fetchStudents(Request $request)
    {
        $query = \App\Models\Student::query()->where('status', 1);

        // APPLY FILTERS WHEN SELECTED
        if ($request->academic_year) {
            $query->where('academic_year_id', $request->academic_year);
        }
        if ($request->university_id) {
            $query->where('university_id', $request->university_id);
        }
        if ($request->subcourse_id) {
            $query->where('sub_course_id', $request->subcourse_id);
        }

        // --------------------------
        //     STUDENT LIST
        // --------------------------
        $students = $query->orderBy('full_name')->get()
            ->map(fn($s) => [
                'id'    => $s->id,
                'name'  => $s->full_name,
                'email' => $s->email
            ]);

        // --------------------------
        // UNIVERSITIES (Depends on Academic Year only)
        // --------------------------
        $universities = \App\Models\Student::select('university_id')
            ->when($request->academic_year, fn($q) => $q->where('academic_year_id', $request->academic_year))
            ->distinct()
            ->with('university:id,name')
            ->orderBy('university_id')
            ->get()
            ->map(fn($u) => [
                'id'   => $u->university_id,
                'name' => $u->university?->name
            ]);

        // --------------------------
        // SUBCOURSES (Depends on Academic Year + University)
        // --------------------------
        $subcourses = \App\Models\Student::select('sub_course_id')
            ->when($request->academic_year, fn($q) => $q->where('academic_year_id', $request->academic_year))
            ->when($request->university_id, fn($q) => $q->where('university_id', $request->university_id))
            ->distinct()
            ->with('subcourse:id,name')
            ->orderBy('sub_course_id')
            ->get()
            ->map(fn($s) => [
                'id'   => $s->sub_course_id,
                'name' => $s->subcourse?->name
            ]);

        return response()->json([
            'students'     => $students,
            'universities' => $universities,
            'subcourses'   => $subcourses,
        ]);
    }







    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        // 1️⃣ Validation rules
        $validator = Validator::make($request->all(), [
            'header_id'   => 'required|exists:notification_headers,id',
            'send_to'     => 'required|in:users,students',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // 2️⃣ Create notification
            $notification = Notification::create([
                'header_id'   => $request->header_id,
                'send_to'     => $request->send_to,
                'title'       => $request->title,
                'description' => $request->description,
                'added_by'    => auth()->id(),
            ]);

            $emails = [];

            // 3️⃣ Users
            if ($request->send_to == 'users') {
                $users = $request->user_type === 'all'
                    ? User::all()
                    : User::whereIn('id', $request->user_ids ?? [])->get();

                foreach ($users as $user) {
                    NotificationTarget::create([
                        'notification_id' => $notification->id,
                        'target_type'     => 'user',
                        'target_id'       => $user->id,
                        'email'           => $user->email,
                    ]);

                    if ($user->email) $emails[] = $user->email;
                }
            }

            // 4️⃣ Students
            if ($request->send_to === 'students') {
                $studentsQ = Student::query()->where('status', 1);

                if ($request->academic_year) $studentsQ->where('academic_year_id', $request->academic_year);
                if ($request->university_id) $studentsQ->where('university_id', $request->university_id);
                if ($request->subcourse_id) $studentsQ->where('sub_course_id', $request->subcourse_id);
                if ($request->student_type === 'individual' && !empty($request->student_ids)) {
                    $studentsQ->whereIn('id', $request->student_ids);
                }

                $studentsQ->select('id', 'email')->chunk(200, function ($students) use ($notification, &$emails) {
                    foreach ($students as $student) {
                        NotificationTarget::create([
                            'notification_id' => $notification->id,
                            'target_type'     => 'student',
                            'target_id'       => $student->id,
                            'email'           => $student->email,
                        ]);

                        if ($student->email) $emails[] = $student->email;
                    }
                });
            }

            // 5️⃣ Dispatch emails to Redis queue
            $emails = array_unique($emails);
            foreach (array_unique($emails) as $email) {
                    SendNotificationJob::dispatch($notification->id, $email)
                        ->onQueue('notifications');
                }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Notification queued successfully!',
                'data'    => $notification
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Notification dispatch error: ' . $e->getMessage());

            return response()->json([
                'status'  => 0,
                'message' => 'Failed to queue notifications: ' . $e->getMessage()
            ], 500);
        }
    }


    // public function store(Request $request)
    // {
    //     // 1️⃣ Validation rules
    //     $validator = Validator::make($request->all(), [
    //         'header_id'   => 'required|exists:notification_headers,id',
    //         'send_to'     => 'required|in:users,students',
    //         'title'       => 'required|string|max:255',
    //         'description' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 0,
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     DB::beginTransaction();

    //     try {

    //         // 2️⃣ Create notification
    //         $notification = Notification::create([
    //             'header_id'   => $request->header_id,
    //             'send_to'     => $request->send_to,
    //             'title'       => $request->title,
    //             'description' => $request->description,
    //             'added_by'    => auth()->id(),
    //         ]);

    //         $emails = [];

    //         // 3️⃣ Users
    //         if ($request->send_to == 'users') {
    //             $users = $request->user_type === 'all'
    //                 ? User::all()
    //                 : User::whereIn('id', $request->user_ids ?? [])->get();

    //             foreach ($users as $user) {
    //                 NotificationTarget::create([
    //                     'notification_id' => $notification->id,
    //                     'target_type'     => 'user',
    //                     'target_id'       => $user->id,
    //                     'email'           => $user->email,
    //                 ]);

    //                 if ($user->email) $emails[] = $user->email;
    //             }
    //         }

    //         // 4️⃣ Students
    //         if ($request->send_to === 'students') {
    //             $studentsQ = Student::query()->where('status', 1);

    //             if ($request->academic_year)  $studentsQ->where('academic_year_id', $request->academic_year);
    //             if ($request->university_id)  $studentsQ->where('university_id', $request->university_id);
    //             if ($request->subcourse_id)   $studentsQ->where('sub_course_id', $request->subcourse_id);
    //             if ($request->student_type === 'individual' && !empty($request->student_ids)) {
    //                 $studentsQ->whereIn('id', $request->student_ids);
    //             }

    //             $studentsQ->select('id', 'email')->chunk(200, function ($students) use ($notification, &$emails) {
    //                 foreach ($students as $student) {
    //                     NotificationTarget::create([
    //                         'notification_id' => $notification->id,
    //                         'target_type'     => 'student',
    //                         'target_id'       => $student->id,
    //                         'email'           => $student->email,
    //                     ]);

    //                     if ($student->email) $emails[] = $student->email;
    //                 }
    //             });
    //         }

    //         // 5️⃣ Send emails directly + LOGGING
    //         $emails = array_unique($emails);

    //         foreach ($emails as $email) {
    //             try {

    //                 Mail::to($email)->send(new SendNotificationMail($notification));

    //                 // Log for success
    //                 \Log::info('Notification email sent successfully', [
    //                     'notification_id' => $notification->id,
    //                     'email' => $email,
    //                     'title' => $notification->title
    //                 ]);
    //             } catch (\Exception $e) {

    //                 // Log for failure
    //                 \Log::error('Failed to send notification email', [
    //                     'notification_id' => $notification->id,
    //                     'email' => $email,
    //                     'error' => $e->getMessage()
    //                 ]);
    //             }
    //         }

    //         // 6️⃣ COMMIT
    //         DB::commit();

    //         return response()->json([
    //             'status'  => 'success',
    //             'message' => 'Notification sent successfully!',
    //             'data'    => $notification
    //         ]);
    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return response()->json([
    //             'status'  => 0,
    //             'message' => 'Failed: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }





    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $notification = Notification::destroy($id);
            return ['status' => 'success', 'message' => 'NotificationHeader deleted successfully!'];
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
