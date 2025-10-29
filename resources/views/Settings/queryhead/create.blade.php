@extends('layouts.main')
@section('content')

<main class="app-wrapper">
    <div class="app-container">
        <!-- Page Title -->
        <div class="hstack flex-wrap gap-3 mb-5">
            <div class="flex-grow-1">
                <h4 class="mb-1 fw-semibold">Student Query Portal</h4>
                <nav>
                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item">Students</li>
                        <li class="breadcrumb-item active" aria-current="page">Query Portal</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="card mb-0 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-semibold text-primary mb-4">
                            <i class="ri-question-line me-1"></i> Submit Your Query
                        </h5>

                        <!-- Step 1: Student ID -->
                        <div id="step1">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Enter Your Student ID</label>
                                        <input type="text" id="student_id" class="form-control form-control-lg" placeholder="Enter your Student ID">
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-primary px-4" id="fetchStudent">
                                            <i class="ri-arrow-right-line me-1"></i> Next
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Query Form -->
                        <div id="step2" class="d-none">
                            <div class="alert alert-info mt-3">
                                <i class="ri-information-line me-1"></i>
                                <strong>Note:</strong> If these details are not yours, please contact the institute.
                            </div>

                            <form id="queryForm" enctype="multipart/form-data" class="mt-4">
                                @csrf
                                <input type="hidden" name="student_id" id="student_id_hidden">

                                <div class="row g-3 mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Name</label>
                                        <input type="text" id="name" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Mobile</label>
                                        <input type="text" id="mobile" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Query Head</label>
                                        <select name="query_head_id" class="form-select" required>
                                            <option value="">Select Query Head</option>
                                            @foreach($queryHeads as $qh)
                                                <option value="{{ $qh->id }}">{{ $qh->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Attachment (optional)</label>
                                        <input type="file" name="attachment" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Query</label>
                                    <textarea name="query" class="form-control" rows="4" placeholder="Write your query here..." required></textarea>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success px-4 me-2">
                                        <i class="ri-send-plane-line me-1"></i> Submit Query
                                    </button>
                                    <button type="button" id="viewQueries" class="btn btn-outline-primary px-4">
                                        <i class="ri-eye-line me-1"></i> View My Queries
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

@endsection


@section('scripts')
<script>
$(function(){
    // Step 1: Fetch student
    $('#fetchStudent').click(function(){
        let id = $('#student_id').val();
        if(!id){ toastr.error('Please enter Student ID'); return; }

        $.post('{{ route("students.fetch") }}', { student_id: id, _token: '{{ csrf_token() }}' }, function(res){
            if(res.status === 'success'){
                $('#step1').addClass('d-none');
                $('#step2').removeClass('d-none');
                $('#student_id_hidden').val(res.data.student_id);
                $('#name').val(res.data.name);
                $('#email').val(res.data.email);
                $('#mobile').val(res.data.mobile);
            } else {
                toastr.error(res.message);
            }
        });
    });

    // Step 2: Submit Query
    $('#queryForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '{{ route("students.query.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                if(res.status === 'success'){
                    toastr.success(res.message);
                    $('#queryForm')[0].reset();
                    $('#step2').addClass('d-none');
                    $('#step1').removeClass('d-none');
                } else {
                    toastr.error(res.message);
                }
            }
        });
    });

    // View Queries
    $('#viewQueries').click(function(){
        let id = $('#student_id_hidden').val();
        if(id){
            window.open('/students/query/view/' + id, '_blank');
        } else {
            toastr.error('Please enter your Student ID first.');
        }
    });
});
</script>

<style>
textarea.form-control {
    resize: none;
}
.card {
    border-radius: 1rem !important;
}
</style>
@endsection
