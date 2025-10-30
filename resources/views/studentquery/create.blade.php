<!-- 🎓 Student Query Modal -->
<div class="modal-header bg-primary text-white py-2">
    <h5 class="modal-title fw-semibold">
        <i class="ri-question-line me-2"></i> Student Query Portal
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body bg-light">
    <div class="container py-3">

        {{-- STEP 1: Enter Student ID --}}
        <div id="step1">
            <div class="mb-3">
                <label class="form-label fw-semibold">Enter Your Student ID</label>
                <input type="text" id="student_id" class="form-control" placeholder="Enter your Student ID">
            </div>
            <div class="text-center">
                <button class="btn btn-primary" id="fetchStudent">Next</button>
            </div>
        </div>

        {{-- STEP 2: Query Form --}}
        <div id="step2" class="d-none">
            <div class="alert alert-info">
                <strong>Note:</strong> If these details are not yours, please contact the institute.
            </div>

            <form id="queryForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="student_id" id="student_id_hidden">

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" id="name" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" id="studentemail" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Mobile</label>
                        <input type="text" id="mobile" class="form-control" readonly>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Query Head <span class="text-danger">*</span></label>
                        <select name="query_head_id" class="form-select" required>
                            <option value="">Select Query Head</option>
                            @foreach($queryHeads as $qh)
                            <option value="{{ $qh->id }}">{{ $qh->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Attachment (optional)</label>
                        <input type="file" name="attachment" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Query Details <span class="text-danger">*</span></label>
                    <textarea name="query" rows="4" class="form-control" placeholder="Write your query in detail..."
                        required></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4 me-2 shadow-sm">
                        <i class="ri-send-plane-line me-1"></i> Submit Query
                    </button>
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i> Cancel
                    </button>
                    {{-- <a href="#" id="viewQueries" class="btn btn-link">View My Queries</a> --}}
                    <button type="button"
    class="btn btn-outline-info btn-sm mt-3"
    onclick="viewQueries(studentId)">
    <i class="ri-eye-line me-1"></i> View My Queries
</button>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function(){

    // Step 1: Fetch Student Info
    $('#fetchStudent').click(function(){
        let id = $('#student_id').val().trim();
        if(!id){
            toastr.error('Please enter Student ID');
            return;
        }

        $.ajax({
            url: '{{ route("students.fetch") }}',
            type: 'POST',
            data: {
                student_id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(res){
                if(res.status === 'success'){
                    $('#step1').addClass('d-none');
                    $('#step2').removeClass('d-none');
                    $('#student_id_hidden').val(res.data.student_id);
                    $('#name').val(res.data.name);
                    $('#studentemail').val(res.data.studentemail);
                    $('#mobile').val(res.data.mobile);
                    toastr.success('Student verified successfully!');
                } else {
                    toastr.error(res.message || 'Student not found!');
                }
            },
            error: function(xhr){
                console.error(xhr.responseText);
                toastr.error('Unable to fetch student data. Please try again.');
            }
        });
    });

    // Step 2: Submit Query Form
    // $('#queryForm').submit(function(e){
    //     e.preventDefault();
    //     var formData = new FormData(this);

    //     $.ajax({
    //         url: '{{ route("students.query.store") }}',
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function(res){
    //             if(res.status === 'success'){
    //                 toastr.success(res.message);
    //                 $('#queryForm')[0].reset();
    //                 $('#studentQueryModal').modal('hide');
    //             } else {
    //                 toastr.error(res.message);
    //             }
    //         },
    //         error: function(xhr){
    //             console.error(xhr.responseText);
    //             toastr.error('Something went wrong. Try again.');
    //         }
    //     });
    // });

    // Step 2: Submit Query Form
$('#queryForm').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: '{{ route("students.query.store") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res){
            if(res.status === 'success'){
                toastr.success(res.message);

                // Reset form and steps
                $('#queryForm')[0].reset();
                $('#step2').addClass('d-none');
                $('#step1').removeClass('d-none');

                // Hide modal (Bootstrap 5 compatible)
                const modalElement = document.getElementById('studentQueryModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                modalInstance.hide();
            } else {
                toastr.error(res.message);
            }
        },
        error: function(xhr){
            console.error(xhr.responseText);
            toastr.error('Something went wrong. Try again.');
        }
    });
});


    // View My Queries
    // $('#viewQueries').click(function(e){
    //     e.preventDefault();
    //     let id = $('#student_id_hidden').val();
    //     if(!id){
    //         toastr.warning('Please enter your Student ID first.');
    //         return;
    //     }
    //     window.location.href = '{{ url("/student/query/view") }}/' + id;
    // });

    // View My Queries inside modal
// $('#viewQueries').click(function(e){
//     e.preventDefault();
//     let id = $('#student_id_hidden').val();

//     if(!id){
//         toastr.warning('Please enter your Student ID first.');
//         return;
//     }

//     // Show loading indicator
//     // $('.modal-body').html('<div class="text-center py-5"><div class="spinner-border text-primary"></div><p class="mt-2">Loading queries...</p></div>');

//     // Fetch view via AJAX
//     $.ajax({
//         url: '{{ url("/students/query/view/") }}/' + id,
//         type: 'GET',
//         success: function(response){
//             // Replace modal content with fetched HTML
//             $('#studentQueryModal .modal-content').html(response);
//         },
//         error: function(xhr){
//             console.error(xhr.responseText);
//             toastr.error('Failed to load student queries. Please try again.');
//         }
//     });
// });


// View Queries Button Click
$(document).on('click', '#viewQueriesBtn', function () {
    let studentId = $('#student_id_hidden').val(); // get ID from hidden field

    if (!studentId) {
        toastr.warning('Please verify your Student ID first.');
        return;
    }

    // Build URL using your Laravel route pattern
    let url = `/students/query/view/${studentId}`;

    $.ajax({
        url: url,
        type: 'GET',
        beforeSend: function () {
            toastr.info('Loading student queries...');
        },
        success: function (response) {
            // If you're using the global modal
            $('#modal-lg-content').html(response);
            $('#modal-lg').modal('show');
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            toastr.error('Unable to fetch student queries. Please try again.');
        }
    });
});


});
</script>
