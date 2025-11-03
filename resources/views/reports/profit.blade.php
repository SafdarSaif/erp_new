@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<main class="app-wrapper">
    <div class="app-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">
                <i class="bi bi-graph-up-arrow me-2"></i>Income and Expense  Report
            </h4>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Date Range</label>
                        <div id="reportrange"
                            style="background:#fff;cursor:pointer;padding:5px 10px;border:1px solid #ccc;width:100%">
                            <i class="ri ri-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label>University</label>
                        <select id="university" class="form-select">
                            <option value="">-- All Universities --</option>
                            @foreach($universities as $university)
                            <option value="{{ $university->id }}">{{ $university->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100" onclick="loadProfitReport()">Generate</button>
                    </div>

                    <div class="col-md-3 text-end d-flex align-items-end justify-content-end">
                        <button class="btn btn-primary me-2" onclick="downloadCSV()">Download CSV</button>
                        <button class="btn btn-primary" onclick="exportPDF()">Download PDF</button>
                    </div>
                </div>

                <table id="profit-table" class="table table-bordered table-striped align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>University</th>
                            <th>Student Count</th>
                            <th>Income (₹)</th>
                            <th>Expense (₹)</th>
                            <th>Profit (₹)</th>
                        </tr>
                    </thead>
                    <tbody id="profitTable"></tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

<script>
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
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')]
        }
    }, cb);

    cb(start, end);
});

function loadProfitReport() {
    var daterange = $('#reportrange span').html();
    var daterange = JSON.stringify(daterange.split(' to '));
    var university = $('#university').val();

    $.ajax({
        url: "/reports/getProfitReport",
        type: "POST",
        data: {
            daterange: daterange,
            university: university,
            _token: "{{ csrf_token() }}"
        },
        success: function(res) {
            let html = "";
            if (res.data && res.data.length > 0) {
                $.each(res.data, function(key, val) {
                    html += `
                        <tr>
                            <td>${key + 1}</td>
                            <td>${val.university}</td>
                            <td>${val.student_count}</td>
                            <td>${val.income}</td>
                            <td>${val.expense}</td>
                            <td><b>${val.profit >= 0 ? +val.profit : '<span class="text-success">'+val.profit+'</span>'}</b></td>

                        </tr>
                    `;
                });
                $('#profitTable').html(html);
            } else {
                $('#profitTable').html(`
                    <tr><td colspan="7" class="text-center">No Data Found</td></tr>
                `);
            }
        }
    });
}

function downloadCSV(){
    let table = document.getElementById("profit-table");
    let workbook = XLSX.utils.table_to_book(table);
    XLSX.writeFile(workbook, 'profit_report.xlsx');
}

function exportPDF(){
    const { jsPDF } = window.jspdf;
    var doc = new jsPDF();
    doc.autoTable({ html: '#profit-table' });
    doc.save('profit_report.pdf');
}

function downloadSingle(university){
    alert('You clicked to download report for: ' + university);
}
</script>
@endsection
