<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Miscellaneous Payment</h3>
        <p class="text-muted">Fill in the payment details below</p>
    </div>

    <form id="miscellaneousFee" action="{{ route('accounts.updateMiscellaneous') }}" method="POST" class="row g-3">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <!-- Semester Selection -->
        <div class="col-md-6">
            <label for="head" class="form-label">Fee Head <span class="text-danger">*</span></label>
            <input type="text" name="head" id="head" class="form-control" placeholder="Ex: Tution Fee" value="{{$mescellaneousFee->head}}">
        </div>
        <div class="col-md-6">
            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="Ex: 10000" value="{{$mescellaneousFee->amount}}">
        </div>
        <div class="col-md-6">
            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
           <input type="text" name="semester" id="semester" class="form-control" placeholder="Ex: Semester 1" value="{{$mescellaneousFee->semester}}" readonly>
        </div>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i
                    class="bi bi-x-circle me-1"></i>Cancel</button>
        </div>
    </form>
</div>


<script>
$(function() {

    // AJAX submit
    $("#miscellaneousFee").submit(function(e) {
        e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                $(':input[type="submit"]').prop('disabled', false);
                if (response.status === 'success') {
                    toastr.success(response.message);
                    $(".modal").modal('hide');
                    location.reload();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                $(':input[type="submit"]').prop('disabled', false);
                toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
            }
        });
    });
});
</script>


