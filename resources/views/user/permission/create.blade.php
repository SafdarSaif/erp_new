<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Permission</h3>
        <p class="text-muted">Permissions you may assign to users</p>
    </div>

    <form id="addPermissionForm" action="{{ url('users/permissions') }}" method="POST" class="row g-3" enctype="multipart/form-data">
         @csrf
        <div class="col-md-12">
            <label for="name" class="form-label">Permission Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" placeholder="ex: view academic year" required>
        </div>

        <div class="col-12 text-center mt-5">
            <button type="submit" class="btn btn-primary">Create Permission</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

{{-- <script>
  $("#addPermissionForm").validate({
    rules: {
      name: {
        required: true
      }
    },
    messages: {
      name: {
        required: "Please enter permission name"
      }
    }
  });

  $("#addPermissionForm").submit(function (e) {
    e.preventDefault();
    if ($("#addPermissionForm").valid()) {
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
        success: function (response) {
          $(':input[type="submit"]').prop('disabled', false);
          if (response.status == 'success') {
            toastr.success(response.message);
            $(".modal").modal('hide');
            $('#permissions-table').DataTable().ajax.reload();
          } else {
            toastr.error(response.message);
          }
        },
        error: function (response) {
          $(':input[type="submit"]').prop('disabled', false);
          toastr.error(response.responseJSON.message);
        }
      });
    }
  })

</script> --}}


<script>
$(function() {
    $("#addPermissionForm").submit(function(e) {
        e.preventDefault();

        $(':input[type="submit"]').prop('disabled', true);
        var formData = new FormData(this);
        formData.append("_token", "{{ csrf_token() }}"); // CSRF token

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
                    toastr.success(response.message); // show success toast
                    $(".modal").modal('hide');
                    $('#permissions-table').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message); // show error toast
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
