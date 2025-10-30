<form id="answerForm" method="POST" action="{{ route('students.query.storeAnswer', $query->id) }}">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Answer Query</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        {{--  --}}

         <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" id="name" class="form-control" value="{{$query->student->full_name }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" id="studentemail" class="form-control" value="{{$query->student->email}}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Mobile</label>
                        <input type="text" id="mobile" class="form-control" value="{{$query->student->mobile }}" readonly>
                    </div>
                </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Query</label>
            <textarea class="form-control" rows="3" readonly>{{ $query->query }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Your Answer <span class="text-danger">*</span></label>
            <textarea name="answer" class="form-control" rows="4" placeholder="Type your answer here...">{{ $query->answer }}</textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit Answer</button>
    </div>
</form>

<script>
$('#answerForm').on('submit', function(e) {
    e.preventDefault();
    var form = $(this);
    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: form.serialize(),
        success: function(response) {
            if (response.status === 'success') {
                toastr.success(response.message);
                $('#globalModal').modal('hide');
                $('#query-table').DataTable().ajax.reload(null, false);
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr) {
            toastr.error('Something went wrong. Please try again.');
        }
    });
});
</script>
