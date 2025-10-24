@extends('layouts.main')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<main class="app-wrapper">
    <div class="app-container">

        <!-- Page title -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">
                <i class="bi bi-people me-2"></i>Income Report 
            </h4>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="reportrange">Receipt Date</label>
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="ri ri-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="payment_mode">Payment Mode</label>
                        <select name="payment_mode" id="payment_mode" class="form-select" required="">
                            <option value="">-- Select Mode --</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="UPI">UPI</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="payment_mode">University</label>
                        <select name="university" id="university" class="form-select" required="">
                            <option value="">-- Select University --</option>
                            @foreach ($universities as $university)
                                <option value="{{$university->id}}">{{$university->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="payment_mode">Fee Type</label>
                        <select name="fee_type" id="fee_type" class="form-select" required="">
                            <option value="">-- Select Fee Type --</option>
                            <option value="student_fee">Student Fee</option>
                            <option value="miscellaneous_fee">Miscellaneous Fee</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-primary mt-5" onclick="applyFilter()">
                            Generate
                        </button>
                    </div>
                </div>
                <table id="student-table" class="table table-hover align-middle table-bordered table-striped w-100">
                    <thead class="bg-light">
                        <tr>
                            <th>Receipt No</th>
                            <th>Student Name</th>
                            <th>Receipt Date</th>
                            <th>Receipt Mode</th>
                            <th>Payment Type</th>
                            <th>Amount</th>
                        </tr>

                    </thead>
                    <tbody id="incomeTable">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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

function applyFilter(){
    var daterange = $('#reportrange span').html();
    var daterange = JSON.stringify(daterange.split(' to '));
    var mode = $('#payment_mode').val();
    var university = $('#university').val();
    var fee_type = $('#fee_type').val();

    $.ajax({
        url:"/reports/getIncome",
        type:"get",
        data:{daterange:daterange,mode:mode,university:university,fee_type:fee_type},
        success:function(res){
            console.log(res.length);
            
            if(res.length>0){
                html ="";
                $.each(res,function(key,val){
                    html +=`
                        <tr>
                            <td>${val.id}</td>
                            <td>${val.student.full_name}</td>
                            <td>${val.transaction_date}</td>
                            <td>${val.payment_mode}</td>
                            <td>${val.miscellaneous_id==''?'Student Fee':'Miscellaneous Fee'}</td>
                            <td>${val.amount}</td>
                        </tr>
                    `;
                });
                $('#incomeTable').html(html);
            }else{
                html =`
                        <tr style="text-align:center">
                            <td colspan="6">No Data Available According To Search Criteria</td>
                        </tr>
                    `;

                    $('#incomeTable').html(html);
            }
        }
    })
}
</script>
@endsection
