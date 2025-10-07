Perfect 👍 You want a complete CRUD setup for a students module — similar to your previous subjects and sub_courses modules.

Let’s create this step by step.
We’ll generate:

Migration

Model

Controller (with try/catch + DataTables)

Views (index, create, edit)

🧩 1. Migration — create_students_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('university_id');
            $table->unsignedBigInteger('course_type_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('sub_course_id');
            $table->unsignedBigInteger('mode_id');
            $table->unsignedBigInteger('course_mode_id');
            $table->string('semester')->nullable();
            $table->string('course_duration')->nullable();
            $table->string('full_name', 150);
            $table->string('father_name', 150)->nullable();
            $table->string('mother_name', 150)->nullable();
            $table->string('aadhaar_no', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->unsignedBigInteger('passout_year_id')->nullable();
            $table->unsignedBigInteger('passout_month_id')->nullable();
            $table->unsignedBigInteger('language_id')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender', 10)->nullable();
            $table->unsignedBigInteger('blood_group_id')->nullable();
            $table->unsignedBigInteger('religion_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->decimal('income', 10, 2)->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('current_address')->nullable();
            $table->decimal('total_fee', 10, 2)->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}

🧠 2. Model — app/Models/Academics/Student.php
namespace App\Models\Academics;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'university_id',
        'course_type_id',
        'course_id',
        'sub_course_id',
        'mode_id',
        'course_mode_id',
        'semester',
        'course_duration',
        'full_name',
        'father_name',
        'mother_name',
        'aadhaar_no',
        'email',
        'mobile',
        'passout_year_id',
        'passout_month_id',
        'language_id',
        'dob',
        'gender',
        'blood_group_id',
        'religion_id',
        'category_id',
        'income',
        'permanent_address',
        'current_address',
        'total_fee',
        'status'
    ];

    // Relationships (example)
    public function subcourse()
    {
        return $this->belongsTo(SubCourse::class, 'sub_course_id');
    }
}

⚙️ 3. Controller — app/Http/Controllers/Academics/StudentController.php
namespace App\Http\Controllers\Academics;

use App\Http\Controllers\Controller;
use App\Models\Academics\Student;
use App\Models\Academics\SubCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $students = Student::with('subcourse')->orderBy('id', 'desc')->get();

            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('subcourse', fn($student) => $student->subcourse->name ?? '-')
                ->editColumn('status', fn($student) => $student->status ? 1 : 0)
                ->addColumn('action', fn($student) => '')
                ->make(true);
        }

        return view('academics.students.index');
    }

    public function create()
    {
        $subcourses = SubCourse::where('status', 1)->get();
        return view('academics.students.create', compact('subcourses'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:150',
            'sub_course_id' => 'required|exists:sub_courses,id',
            'email' => 'nullable|email|max:100',
            'mobile' => 'nullable|string|max:15',
            'dob' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        try {
            $student = Student::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Student added successfully!',
                'data' => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $subcourses = SubCourse::where('status', 1)->get();
        return view('academics.students.edit', compact('student', 'subcourses'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:150',
            'sub_course_id' => 'required|exists:sub_courses,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        try {
            $student->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Student updated successfully!',
                'data' => $student
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Student deleted successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
}

🧾 4. Create Form (Blade: resources/views/academics/students/create.blade.php)

Example minimal form (like your subcourse & subject style):

<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Student</h3>
        <p class="text-muted">Fill in the student details below</p>
    </div>

    <form id="student-form" action="{{ route('students.store') }}" method="POST" class="row g-3">
        @csrf

        <div class="col-md-6">
            <label class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="full_name" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Mobile</label>
            <input type="text" name="mobile" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Sub Course <span class="text-danger">*</span></label>
            <select name="sub_course_id" class="form-select" required>
                <option value="">-- Select Sub Course --</option>
                @foreach($subcourses as $subcourse)
                    <option value="{{ $subcourse->id }}">{{ $subcourse->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control">
        </div>

        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
$(function() {
    $("#student-form").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        let formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    $('#student-table').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false);
                toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
            }
        });
    });
});
</script>
