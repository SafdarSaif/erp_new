@extends('layouts.main')

@section('content')
<main class="app-wrapper">
    <div class="app-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">
                <i class="bi bi-hourglass-split me-2"></i>Pending Fee Report
            </h4>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="university">University</label>
                        <select name="university" id="university" class="form-select">
                            <option value="">-- All --</option>
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}">{{ $university->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="course">Course</label>
                        <select name="course" id="course" class="form-select">
                            <option value="">-- All --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="student">Student</label>
                        <select name="student" id="student" class="form-select">
                            <option value="">-- All --</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100" onclick="loadPendingFees()">Generate</button>
                    </div>
                </div>

                <table class="table table-bordered table-striped w-100" id="pending-fees-table">
                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Semester Balances</th>
                            <th>Miscellaneous Balances</th>
                            <th>Total Pending</th>
                        </tr>
                    </thead>
                    <tbody id="pendingFeesBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
// function loadPendingFees() {
//     let university = $('#university').val();
//     let course = $('#course').val();
//     let student = $('#student').val();

//     $.ajax({
//         url: "/reports/getpendingFees",
//         method: "POST",
//         data: {
//             _token: "{{ csrf_token() }}",
//             university,
//             course,
//             student
//         },
//         success: function(res) {
//             let html = '';
//             res.data.forEach((item, index) => {
//                 let semesterStr = item.semesterBalances.map(s => `${s.semester}: ₹${s.balance}`).join('<br>');
//                 let miscStr     = item.miscBalances.map(m => `${m.head}: ₹${m.balance}`).join('<br>');
//                 html += `
//                     <tr>
//                         <td>${index + 1}</td>
//                         <td>${item.student.full_name}</td>
//                         <td>${semesterStr || '-'}</td>
//                         <td>${miscStr || '-'}</td>
//                         <td>₹${item.total_due.toFixed(2)}</td>
//                     </tr>
//                 `;
//             });
//             $('#pendingFeesBody').html(html);
//         }
//     });
// }

function loadPendingFees() {
    let university = $('#university').val();
    let course = $('#course').val();
    let student = $('#student').val();

    $.ajax({
        url: "/reports/getpendingFees",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            university,
            course,
            student
        },
        success: function(res) {
            let html = '';

            if (res.data.length > 0) {
                res.data.forEach((item, index) => {
                    let semesterStr = item.semesterBalances.map(s => `${s.semester}: ₹${s.balance}`).join('<br>');
                    let miscStr     = item.miscBalances.map(m => `${m.head}: ₹${m.balance}`).join('<br>');
                    html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.student.full_name}</td>
                            <td>${semesterStr || '-'}</td>
                            <td>${miscStr || '-'}</td>
                            <td>₹${item.total_due.toFixed(2)}</td>
                        </tr>
                    `;
                });
            } else {
                html = `
                    <tr style="text-align:center">
                        <td colspan="5">No Data Available According To Search Criteria</td>
                    </tr>
                `;
            }

            $('#pendingFeesBody').html(html);
        }
    });
}

</script>
@endsection
