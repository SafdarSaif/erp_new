{{-- <div class="modal-header">
    <h5 class="modal-title">Add / Edit User</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div> --}}

<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">User Details</h3>
        <p class="text-muted">Fill in the user details below</p>
    </div>

    <form id="user-form" action="{{ route('users') }}" method="POST" class="row g-3" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" id="user_id">

        <!-- Name -->
        <div class="col-md-6">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name"
                oninput="createInitials()" required>
        </div>

        <!-- Avatar -->
        <div class="col-md-6">
            <label for="avatar" class="form-label">Avatar</label>
            <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*"
                onchange="previewAvatar(event)">
            <div class="mt-2 d-flex align-items-center">
                <span id="nameInitials" class="avatar-initial rounded-circle bg-label-success"
                    style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">UN</span>
                <img id="avatarImage" src="" alt="Avatar" class="rounded-circle"
                    style="width:40px;height:40px;display:none;">
            </div>
        </div>


        <!-- Address -->
        <div class="col-md-12">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" id="address" class="form-control" placeholder="Enter Address"
                rows="2">{{ old('address') }}</textarea>
        </div>

        <!-- Email -->
        <div class="col-md-6">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
        </div>

        <!-- Mobile -->
        <div class="col-md-6">
            <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
            <input type="tel" name="mobile" id="mobile" class="form-control" placeholder="Enter Mobile" required>
        </div>



        <!-- Role -->
        <div class="col-md-6">
            <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
            <select name="role_id" id="role_id" class="form-select" required>
                <option value="">Choose Role</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        {{-- Reporting Person --}}
        <div class="col-md-6">
            <label for="role_id" class="form-label">Reporting Manager <span class="text-danger">*</span></label>
            <select name="reporting_user_id" id="reporting_user_id" class="form-select" required>
                <option value="">Choose Reporting Manager</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Password -->
        <div class="col-md-6 form-password-toggle">
            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
            <div class="input-group input-group-merge">
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password"
                    required minlength="8">
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
            </div>
        </div>



        <!-- Submit -->
        <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

{{-- <script>
    // Avatar preview
    function previewAvatar(event) {
        const avatarImage = document.getElementById('avatarImage');
        const nameInitials = document.getElementById('nameInitials');
        avatarImage.src = URL.createObjectURL(event.target.files[0]);
        avatarImage.style.display = 'flex';
        nameInitials.style.display = 'none';
    }

    // Create initials from name
    function createInitials() {
        const name = $('#name').val();
        const initials = (name.match(/\b\w/g) || []).slice(0, 2).join('').toUpperCase();
        $('#nameInitials').text(initials);
        $('#nameInitials').css('display', 'flex');
        $('#avatarImage').css('display', 'none');
    }

    // Toggle password visibility
    $('.form-password-toggle i').on('click', function() {
        const input = $(this).closest('.form-password-toggle').find('input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).removeClass('ti-eye-off').addClass('ti-eye');
        } else {
            input.attr('type', 'password');
            $(this).removeClass('ti-eye').addClass('ti-eye-off');
        }
    });

    // AJAX submit
    $(function() {
        $("#user-form").submit(function(e) {
            e.preventDefault();
            if (!$(this).valid()) return;
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
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $(".modal").modal('hide');
                        $('#users-datatable').DataTable().ajax.reload();
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

        // Select2 for Role
        // $("#role_id").select2({
        //     placeholder: 'Choose Role',
        //     dropdownParent: $('#modal-lg')
        // });
    });
</script> --}}
<script>
    // Avatar preview
    function previewAvatar(event) {
        const avatarImage = document.getElementById('avatarImage');
        const nameInitials = document.getElementById('nameInitials');
        avatarImage.src = URL.createObjectURL(event.target.files[0]);
        avatarImage.style.display = 'flex';
        nameInitials.style.display = 'none';
    }

    // Create initials from name
    function createInitials() {
        const name = $('#name').val();
        const initials = (name.match(/\b\w/g) || []).slice(0, 2).join('').toUpperCase();
        $('#nameInitials').text(initials);
        $('#nameInitials').css('display', 'flex');
        $('#avatarImage').css('display', 'none');
    }

    // Toggle password visibility
    $('.form-password-toggle i').on('click', function() {
        const input = $(this).closest('.form-password-toggle').find('input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).removeClass('ti-eye-off').addClass('ti-eye');
        } else {
            input.attr('type', 'password');
            $(this).removeClass('ti-eye').addClass('ti-eye-off');
        }
    });

    // AJAX submit
    $(function() {
        $("#user-form").submit(function(e) {
            e.preventDefault();

            // Removed: if (!$(this).valid()) return;

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
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        $(".modal").modal('hide');
                        $('#users-datatable').DataTable().ajax.reload();
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

        // Optional: initialize Select2
        // $("#role_id").select2({
        //     placeholder: 'Choose Role',
        //     dropdownParent: $('#modal-lg')
        // });
    });
</script>
