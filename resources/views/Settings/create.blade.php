<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Academic Year</h3>
        {{-- <p class="text-muted">Fill in the menu details below</p> --}}
    </div>

    <form id="addAcademicYear" action="{{ route('academicyears') }}" method="POST" class="row g-3" enctype="multipart/form-data">
        <div class="col-md-6">
            <label for="name" class="form-label">Academic Year<span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="ex: 2025-26" required>
        </div>
        <div class="col-12 text-center mt-5">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>




<script>
  $(function() {
    $("#addAcademicYear").submit(function(e) {
      e.preventDefault();
        $(':input[type="submit"]').prop('disabled', true);
        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}");
        $.ajax({
          url: $(this).attr('action'),
          type: $(this).attr('method'),
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: function(response) {
            $(':input[type="submit"]').prop('disabled', false);
            if (response.status == 'success') {
              toastr.success(response.message);
              $(".modal").modal('hide');
              $('#academic-year-table').DataTable().ajax.reload();
            } else {
              toastr.error(response.message);
            }
          },
          error: function(response) {
            $(':input[type="submit"]').prop('disabled', false);
            toastr.error(response.responseJSON.message);
          }
        });
    })
  })
</script>
