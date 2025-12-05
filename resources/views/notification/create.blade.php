<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Notification</h3>
    </div>

    <form id="addNotification" action="{{ route('notifications.store') }}" method="POST" class="row g-3">
        @csrf

        <!-- Notification Header -->
        <div class="col-md-6">
            <label class="form-label">Notification Header <span class="text-danger">*</span></label>
            <select name="header_id" class="form-control" required>
                <option value="">-- Select --</option>
                @foreach($headers as $h)
                <option value="{{ $h->id }}">{{ $h->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Send To -->
        <div class="col-md-6">
            <label class="form-label">Send To <span class="text-danger">*</span></label>
            <select name="send_to" id="send_to" class="form-control" required>
                <option value="users">Users</option>
                <option value="students">Students</option>
            </select>
        </div>

        <!-- USERS SECTION -->
        <div class="col-12" id="users_section" style="display:none;">
            <label class="form-label">User Target</label>
            <select id="user_type" name="user_type" class="form-control">
                <option value="All">All Users</option>
                <option value="individual">Individual Users</option>
            </select>

            <div id="user_multi" class="mt-2" style="display:none;">
                <label>Select Users</label>
                <select id="user_ids" name="user_ids[]" class="form-control" multiple>
                    @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- STUDENTS SECTION -->
        <div class="col-12" id="students_section" style="display:none;">
            <div class="row g-3">

                <div class="col-md-3">
                    <label>Academic Year</label>
                    <select id="academic_year" name="academic_year" class="form-control">
                        <option value="">-- All --</option>
                        @foreach($years as $y)
                        <option value="{{ $y->id }}">{{ $y->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>University</label>
                    <select id="university_id" name="university_id" class="form-control">
                        <option value="">-- All --</option>
                        @foreach($universities as $un)
                        <option value="{{ $un->id }}">{{ $un->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Subcourse</label>
                    <select id="subcourse_id" name="subcourse_id" class="form-control">
                        <option value="">-- All --</option>
                        @foreach($subcourses as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Student Target</label>
                    <select name="student_type" id="student_type" class="form-control">
                        <option value="All">All Students</option>
                        <option value="individual">Individual Students</option>
                    </select>
                </div>

            </div>

            <div class="mt-2" id="student_list_wrap" style="display:none;">
                <label>Select Students</label>
                <select id="student_ids" name="student_ids[]" class="form-control" multiple></select>

                <button type="button" id="load_students" class="btn btn-secondary btn-sm mt-2">
                    Load Students
                </button>
            </div>
        </div>

        <!-- Title -->
        <div class="col-12">
            <label>Title <span class="text-danger">*</span></label>
            <input id="title" name="title" class="form-control" required>
        </div>

        <!-- Description -->
        <div class="col-12">
            <label>Description <span class="text-danger">*</span></label>
            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
        </div>

        <!-- Submit -->
        <div class="col-12 text-center mt-4">
            <button class="btn btn-primary" type="submit">Send Notification</button>
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
        </div>

    </form>
</div>


<script>
    $(function () {

    /* Show/Hide sections */
    function toggleSections() {
        let val = $('#send_to').val();
        $('#users_section').toggle(val === 'users');
        $('#students_section').toggle(val === 'students');
    }
    $('#send_to').change(toggleSections);
    toggleSections();


    /* Users subsection */
    $('#user_type').change(function() {
        $('#user_multi').toggle($(this).val() === 'individual');
    });


    /* Students subsection */
    $('#student_type').change(function() {
        $('#student_list_wrap').toggle($(this).val() === 'individual');
    });


    /* Load Students AJAX */
    // function loadStudents() {

    //     $.post(
    //         "{{ route('notifications.fetchStudents') }}",
    //         {
    //             academic_year: $('#academic_year').val(),
    //             university_id: $('#university_id').val(),
    //             subcourse_id: $('#subcourse_id').val(),
    //             _token: "{{ csrf_token() }}"
    //         },
    //         function(res) {

    //             /* Student list */
    //             let sList = $('#student_ids').empty();
    //             res.students.forEach(s => {
    //                 sList.append(`<option value="${s.id}">${s.name} (${s.email ?? ''})</option>`);
    //             });

    //             /* University dropdown */
    //             let uni = $('#university_id').empty()
    //                 .append(`<option value="">-- All --</option>`);
    //             res.universities.forEach(u => {
    //                 uni.append(`<option value="${u.id}">${u.name}</option>`);
    //             });

    //             /* Subcourse dropdown */
    //             let sub = $('#subcourse_id').empty()
    //                 .append(`<option value="">-- All --</option>`);
    //             res.subcourses.forEach(sc => {
    //                 sub.append(`<option value="${sc.id}">${sc.name}</option>`);
    //             });
    //         }
    //     );
    // }


    function loadStudents() {

    $.post(
        "{{ route('notifications.fetchStudents') }}",
        {
            academic_year: $('#academic_year').val(),
            university_id: $('#university_id').val(),
            subcourse_id: $('#subcourse_id').val(),
            _token: "{{ csrf_token() }}"
        },
        function (res) {

            /** ------------------------------
             *   UPDATE STUDENT LIST
             * ------------------------------ */
            if (studentChoices) {
                studentChoices.destroy();    // Destroy old instance
            }

            let sList = $('#student_ids').empty();  // add new options
            res.students.forEach(s => {
                sList.append(`<option value="${s.id}">${s.name} (${s.email ?? ''})</option>`);
            });

            // Reinitialize Choices
            studentChoices = new Choices('#student_ids', {
                removeItemButton: true,
                searchEnabled: true,
                placeholder: true
            });


            /** ------------------------------
             *   UPDATE UNIVERSITY DROPDOWN
             * ------------------------------ */
            if (filterUniversityChoices) filterUniversityChoices.destroy();
            let uni = $('#university_id').empty().append(`<option value="">-- All --</option>`);
            res.universities.forEach(u => {
                uni.append(`<option value="${u.id}">${u.name}</option>`);
            });
            filterUniversityChoices = new Choices('#university_id');


            /** ------------------------------
             *   UPDATE SUBCOURSE DROPDOWN
             * ------------------------------ */
            if (filterSubcourseChoices) filterSubcourseChoices.destroy();
            let sub = $('#subcourse_id').empty().append(`<option value="">-- All --</option>`);
            res.subcourses.forEach(sc => {
                sub.append(`<option value="${sc.id}">${sc.name}</option>`);
            });
            filterSubcourseChoices = new Choices('#subcourse_id');

        }
    );
}


    $('#academic_year, #university_id, #subcourse_id').change(loadStudents);
    $('#load_students').click(loadStudents);


    /* Submit Form AJAX */
    $('#addNotification').submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                    $('.modal').modal('hide');
                    $('#notifications-table').DataTable().ajax.reload();
                } else {
                    toastr.error(res.message);
                }
            },

            error: function (err) {
                toastr.error(err.responseJSON?.message || 'Something went wrong.');
            }
        });
    });

});
</script>
