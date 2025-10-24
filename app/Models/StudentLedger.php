<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Student;
use App\Models\Accounts\StudentFeeStructure;
use App\Models\StudentInvoice;

class StudentLedger extends Model
{
    use HasFactory;

    protected $table = 'student_ledgers';
    protected $fillable = [
        'student_id', 'student_fee_id', 'transaction_type',
        'amount', 'transaction_date', 'payment_mode',
        'utr_no', 'gateway_response', 'remarks','miscellaneous_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function fee()
    {
        return $this->belongsTo(StudentFeeStructure::class, 'student_fee_id');
    }

    public function invoice()
    {
        return $this->hasOne(StudentInvoice::class, 'ledger_id');
    }


     public function feeStructure()
    {
        return $this->belongsTo(StudentFeeStructure::class, 'student_fee_id');
    }
}
