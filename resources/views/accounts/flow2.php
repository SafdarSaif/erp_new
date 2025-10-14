Perfect! Let’s create a complete flow for the Student Fee Management System within your ERP project, integrating it with the Academics and Students modules you already have. I’ll break it into database, models, controllers, views, and routes, showing all the steps you need to implement the module fully.

Student Fee Management System – Full Flow
1️⃣ Database Tables

You already have students and academics tables. For the Accounts module, we need:

1. Student Fee Structure

Stores semester-wise fee for students.

CREATE TABLE `student_fee_structure` (
    `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `student_id` INT(11) NOT NULL,
    `semester` VARCHAR(50) NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE
);

2. Student Invoice

Records individual payments against student fees.

CREATE TABLE `student_invoice` (
    `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
    `student_id` INT(11) NOT NULL,
    `student_fee_id` INT(11) NOT NULL,
    `credit_amount` DECIMAL(10,2) DEFAULT 0,
    `date_of_transaction` DATE,
    `mode_of_payment` VARCHAR(100),
    `utr_no` VARCHAR(100),
    `receipt_file` VARCHAR(255),
    `status` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`student_fee_id`) REFERENCES `student_fee_structure`(`id`) ON DELETE CASCADE
);

2️⃣ Laravel Models & Relationships
Student.php
public function fees() {
    return $this->hasMany(StudentFeeStructure::class);
}

public function invoices() {
    return $this->hasMany(StudentInvoice::class);
}

StudentFeeStructure.php
namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class StudentFeeStructure extends Model {
    protected $fillable = ['student_id','semester','amount'];

    public function student() {
        return $this->belongsTo(\App\Models\Students\Student::class);
    }

    public function invoices() {
        return $this->hasMany(StudentInvoice::class,'student_fee_id');
    }

    public function pendingAmount() {
        return $this->amount - $this->invoices()->sum('credit_amount');
    }
}

StudentInvoice.php
namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\Model;

class StudentInvoice extends Model {
    protected $fillable = ['student_id','student_fee_id','credit_amount','date_of_transaction','mode_of_payment','utr_no','receipt_file'];

    public function student() {
        return $this->belongsTo(\App\Models\Students\Student::class);
    }

    public function fee() {
        return $this->belongsTo(StudentFeeStructure::class,'student_fee_id');
    }
}

3️⃣ Controllers
StudentFeeController

Handles semester-wise fee creation and listing.

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounts\StudentFeeStructure;
use App\Models\Students\Student;
use Yajra\DataTables\Facades\DataTables;

class StudentFeeController extends Controller {

    public function index(Request $request) {
        if($request->ajax()){
            $fees = StudentFeeStructure::with('student')->orderBy('id','desc');
            return DataTables::of($fees)
                ->addIndexColumn()
                ->addColumn('student_name', fn($fee) => $fee->student->full_name ?? '-')
                ->addColumn('semester', fn($fee) => $fee->semester)
                ->addColumn('amount', fn($fee) => $fee->amount)
                ->addColumn('pending', fn($fee) => $fee->pendingAmount())
                ->addColumn('action', fn($fee) => '<button class="btn btn-sm btn-primary" onclick="managePayment('.$fee->id.')">Manage Payment</button>')
                ->make(true);
        }
        return view('accounts.fee.index');
    }

    public function create() {
        $students = Student::where('status',1)->get();
        return view('accounts.fee.create', compact('students'));
    }

    public function store(Request $request){
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'semester' => 'required|string',
            'amount' => 'required|numeric|min:0'
        ]);

        StudentFeeStructure::create($request->all());
        return redirect()->route('accounts.fee.index')->with('success','Fee added successfully!');
    }
}

StudentInvoiceController

Handles payment creation, listing, and invoice reports.

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounts\StudentInvoice;
use App\Models\Accounts\StudentFeeStructure;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class StudentInvoiceController extends Controller {

    public function index(Request $request){
        if($request->ajax()){
            $invoices = StudentInvoice::with(['student','fee'])->orderBy('id','desc');
            return DataTables::of($invoices)
                ->addIndexColumn()
                ->addColumn('student', fn($inv) => $inv->student->full_name ?? '-')
                ->addColumn('semester', fn($inv) => $inv->fee->semester ?? '-')
                ->addColumn('amount', fn($inv) => $inv->credit_amount)
                ->addColumn('mode', fn($inv) => $inv->mode_of_payment)
                ->addColumn('status', fn($inv) => $inv->status ? 'Paid' : 'Pending')
                ->addColumn('action', fn($inv) => '<a href="'.route('accounts.invoice.download',$inv->id).'" class="btn btn-sm btn-info">Download</a>')
                ->make(true);
        }
        return view('accounts.invoice.index');
    }

    public function create($student_fee_id){
        $fee = StudentFeeStructure::with('student')->findOrFail($student_fee_id);
        return view('accounts.invoice.create', compact('fee'));
    }

    public function store(Request $request){
        $request->validate([
            'student_fee_id'=>'required|exists:student_fee_structure,id',
            'credit_amount'=>'required|numeric|min:0',
            'date_of_transaction'=>'required|date',
            'mode_of_payment'=>'required|string',
            'utr_no'=>'required|string',
            'receipt_file'=>'nullable|file|mimes:jpg,png,pdf'
        ]);

        if($request->hasFile('receipt_file')){
            $path = $request->file('receipt_file')->store('receipts','public');
            $request->merge(['receipt_file'=>$path]);
        }

        StudentInvoice::create($request->all());
        return redirect()->route('accounts.invoice.index')->with('success','Payment added successfully!');
    }
}

4️⃣ Blade Views
1. Student Fee Listing (accounts/fee/index.blade.php)

Show student name, semester, total fee, pending fee, and Manage Payment button.

Use DataTables for sorting/search.

2. Add Student Fee (accounts/fee/create.blade.php)

Dropdown to select student

Semester input

Fee amount input

3. Manage Payment / Add Invoice (accounts/invoice/create.blade.php)

Show pending fee

Input credit amount

Select payment mode

Upload receipt

Date picker

UTR/Reference input

Submit via AJAX (optional)

5️⃣ Routes
Route::prefix('accounts')->group(function(){
    Route::resource('fee', StudentFeeController::class);
    Route::resource('invoice', StudentInvoiceController::class)->only(['index','create','store']);
    Route::get('invoice/download/{id}', [StudentInvoiceController::class,'download'])->name('accounts.invoice.download');
});

6️⃣ Key Features / Flow

Create Semester Fee

Admin selects student + semester + fee amount

Data stored in student_fee_structure

View Fee

List all students with fee

Show total fee, paid amount, pending fee

Add Payment (Invoice)

Admin clicks “Manage Payment”

Fill credit amount, date, mode, UTR, receipt

Data stored in student_invoice

Pending Fee Calculation

pendingAmount() method calculates unpaid fee

Invoice Reports

List all payments, show status Paid / Pending

Download PDF / Excel / CSV

Integration

Linked with students table

Semester-wise fee for multi-course / multi-semester support
