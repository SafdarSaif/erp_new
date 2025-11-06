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
                    </div>

                    <!-- Generate Button -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" onclick="applyFilter()">Generate</button>
                    </div>

                    <!-- Download Buttons -->
                    <div class="col-md-3 text-end">
                        <button class="btn btn-primary mt-5" onclick="downloadCSV()">Download CSV</button>
                        <button class="btn btn-danger mt-5" onclick="exportPDF()">Download PDF</button>
                    </div>
                </div>

                <!-- Expense Table -->
                <table id="expense-table" class="table table-hover align-middle table-bordered table-striped w-100">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Source</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>University / Expense Category</th>
                            <th>Expense Date</th>
                            <th>Payment Mode</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="expenseTable"></tbody>
                </table>

                <!-- Total -->
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

function applyFilter() {
    var daterange = $('#reportrange span').html();
    var daterange = JSON.stringify(daterange.split(' to '));
    var mode = $('#payment_mode').val();
    var university = $('#university').val();
    var student = $('#student').val();
    var course = $('#course').val();

    $.ajax({
        url: "/reports/getExpense",
        type: "POST",
        data: {
            daterange: daterange,
            mode: mode,
            university: university,
            student: student,
            course: course,
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
                $('#expenseTable').html(`
                    <tr style="text-align:center">
                        <td colspan="8">No Data Available According To Search Criteria</td>
                    </tr>
                `);
                $('#totalExpense').text('0.00');
            }
        },
        // error: function(err) {
        //     alert("Error fetching data. Check console for details.");
        //     console.error(err);
        // }
        error: function (err) {
    toastr.error("Error fetching data. Please check the console for more details.", "Error");
    console.error("AJAX Error:", err);
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
