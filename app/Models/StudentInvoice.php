<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class StudentInvoice extends Model
{
    use HasFactory;

    protected $table = 'student_invoices';
    protected $fillable = ['ledger_id', 'invoice_no', 'receipt_file'];

    public function ledger()
    {
        return $this->belongsTo(StudentLedger::class, 'ledger_id');
    }
}
