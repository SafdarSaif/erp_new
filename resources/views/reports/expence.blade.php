@extends('layouts.main')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<main class="app-wrapper">
    <div class="app-container">

        <!-- Page title -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">
                <i class="bi bi-cash-coin me-2"></i>Expense Report
            </h4>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <!-- 🔹 Filters Row -->
                <div class="row mb-3">
                    <!-- Date Range -->
                    <div class="col-md-2">
                        <label for="reportrange">Expense Date</label>
                        <div id="reportrange"
                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="ri ri-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>

                    {{--
                    <!-- Source -->
                    <div class="col-md-2">
                        <label for="source">Source</label>
                        <select id="source" name="source" class="form-select">
                            <option value="">-- All Sources --</option>
                            <option value="university_fees">University Fees</option>
                            <option value="voucher_payment">Voucher Payment</option>
                        </select>
                    </div>

                    <!-- Payment Mode -->
                    <div class="col-md-2">
                        <label for="payment_mode">Payment Mode</label>
                        <select name="payment_mode" id="payment_mode" class="form-select">
                            <option value="">-- Select Mode --</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="UPI">UPI</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>

                    <!-- Voucher Category -->
                    <div class="col-md-2">
                        <label for="voucher_category">Voucher Category</label>
                        <select id="voucher_category" name="voucher_category" class="form-select">
                            <option value="">-- Select Category --</option>
                            @foreach ($voucherCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Voucher Type -->
                    <div class="col-md-2">
                        <label for="voucher_type">Voucher Type</label>
                        <select id="voucher_type" name="voucher_type" class="form-select">
                            <option value="">-- Select Type --</option>
                            <option value="debit">Debit</option>
                            <option value="credit">Credit</option>
                        </select>
                    </div>

                    <!-- Added By -->
                    <div class="col-md-2">
                        <label for="added_by">Added By</label>
                        <select id="added_by" name="added_by" class="form-select">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- University -->
                    <div class="col-md-2">
                        <label for="university">University</label>
                        <select name="university" id="university" class="form-select">
                            <option value="">-- Select University --</option>
                            @foreach ($universities as $university)
                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Student -->
                    <div class="col-md-2">
                        <label for="student">Student</label>
                        <select name="student" id="student" class="form-select">
                            <option value="">-- Select Student --</option>
                            @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course -->
                    <div class="col-md-2">
                        <label for="course">Course</label>
                        <select name="course" id="course" class="form-select">
                            <option value="">-- Select Course --</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <!-- Source -->
                    <div class="col-md-2">
                        <label for="source">Source</label>
                        <select id="source" name="source" class="form-select">
                            <option value="">-- All Sources --</option>
                            <option value="university_fees">University Fees</option>
                            <option value="voucher_payment">Voucher Payment</option>
                        </select>
                    </div>

                    <!-- Payment Mode (common to both) -->
                    <div class="col-md-2 filter-common">
                        <label for="payment_mode">Payment Mode</label>
                        <select name="payment_mode" id="payment_mode" class="form-select">
                            <option value="">-- Select Mode --</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="UPI">UPI</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>

                    <!-- Voucher Filters -->
                    <div class="col-md-2 filter-voucher">
                        <label for="voucher_category">Voucher Category</label>
                        <select id="voucher_category" name="voucher_category" class="form-select">
                            <option value="">-- Select Category --</option>
                            @foreach ($voucherCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 filter-voucher">
                        <label for="voucher_type">Voucher Type</label>
                        <select id="voucher_type" name="voucher_type" class="form-select">
                            <option value="">-- All Type --</option>
                            <option value="Expense">Expense</option>
                            <option value="Advance">Advance</option>
                            <option value="Adjustment">Adjustment</option>
                            <option value="Reimbursement">Reimbursement</option>
                            <option value="Miscellaneous">Miscellaneous</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>


                    <div class="col-md-2 filter-voucher filter-university-common">
                        <label for="added_by">Added By</label>
                        <select id="added_by" name="added_by" class="form-select">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- University Filters -->
                    <div class="col-md-2 filter-university">
                        <label for="university">University</label>
                        <select name="university" id="university" class="form-select">
                            <option value="">-- Select University --</option>
                            @foreach ($universities as $university)
                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 filter-university">
                        <label for="student">Student</label>
                        <select name="student" id="student" class="form-select">
                            <option value="">-- Select Student --</option>
                            @foreach ($students as $student)
                            <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 filter-university">
                        <label for="course">Course</label>
                        <select name="course" id="course" class="form-select">
                            <option value="">-- Select Course --</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <!-- Generate -->
                    <div class="col-md-2 d-flex align-items-end mt-2">
                        <button class="btn btn-primary w-100" onclick="applyFilter()">Generate</button>
                    </div>

                    <!-- Download -->
                    <div class="col-md-3 d-flex align-items-end mt-2">
                        <button class="btn btn-success me-2 w-50" onclick="downloadCSV()">Download CSV</button>
                        <button class="btn btn-danger w-50" onclick="exportPDF()">Download PDF</button>
                    </div>
                </div>

                <!-- 🔹 Expense Table -->
                <table id="expense-table" class="table table-hover align-middle table-bordered table-striped w-100">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Source</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>University / Category</th>
                            <th>Expense Date</th>
                            <th>Payment Mode</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="expenseTable"></tbody>
                </table>

                <!-- 🔹 Total -->
                <div class="text-end mt-3">
                    <h5 class="fw-bold">Total Expense: ₹<span id="totalExpense">0.00</span></h5>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

<script type="text/javascript">
    $(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('D-M-Y') + ' to ' + end.format('D-M-Y'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
});

$(document).ready(function () {
    $(".filter-voucher, .filter-university").hide();

    $("#source").on("change", function () {
        const source = $(this).val();

        $(".filter-voucher, .filter-university").hide();

        if (source === "voucher_payment") {
            $(".filter-voucher").show();
            $(".filter-common, .filter-university-common").show();
        }
        else if (source === "university_fees") {
            $(".filter-university").show();
            $(".filter-common, .filter-university-common").show();
        }
        else {
            $(".filter-common, .filter-university-common").show();
        }
    });
});

function applyFilter() {
    var daterange = $('#reportrange span').html();
    var daterange = JSON.stringify(daterange.split(' to '));
    var mode = $('#payment_mode').val();
    var university = $('#university').val();
    var student = $('#student').val();
    var course = $('#course').val();
    var source = $('#source').val();
    var voucher_category = $('#voucher_category').val();
    var voucher_type = $('#voucher_type').val();
    var added_by = $('#added_by').val();

    $.ajax({
        url: "/reports/getExpense",
        type: "POST",
        data: {
            daterange: daterange,
            mode: mode,
            university: university,
            student: student,
            course: course,
            source: source,
            voucher_category: voucher_category,
            voucher_type: voucher_type,
            added_by: added_by,
            _token: "{{ csrf_token() }}"
        },
        success: function(res) {
            let html = "";
            let total = 0;

            if (res.data && res.data.length > 0) {
                $.each(res.data, function(key, val) {
                    html += `
                        <tr>
                            <td>${key + 1}</td>
                            <td>${val.source ?? '-'}</td>
                            <td>${val.student ?? '-'}</td>
                            <td>${val.course ?? '-'}</td>
                            <td>${val.university ?? '-'}</td>
                            <td>${val.date ? new Date(val.date).toLocaleDateString() : '-'}</td>
                            <td>${val.mode ?? '-'}</td>
                            <td>₹${parseFloat(val.amount).toFixed(2)}</td>
                        </tr>
                    `;
                    total += parseFloat(val.amount);
                });
                $('#expenseTable').html(html);
                $('#totalExpense').text(total.toFixed(2));
            } else {
                $('#expenseTable').html(`<tr style="text-align:center"><td colspan="8">No Data Found</td></tr>`);
                $('#totalExpense').text('0.00');
            }
        },
        error: function (err) {
            toastr.error("Error fetching data.", "Error");
            console.error(err);
        }
    });
}

function downloadCSV() {
    let table = document.getElementById("expense-table");
    let workbook = XLSX.utils.table_to_book(table);
    XLSX.writeFile(workbook, 'expense_report.xlsx');
}

function exportPDF() {
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF();
    doc.autoTable({ html: '#expense-table', startY: 10 });
    doc.save('expense_report.pdf');
}
</script>
@endsection
