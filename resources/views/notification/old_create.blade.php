<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Add Notification</h3>
    </div>

    <form id="addNotification" action="{{ route('notifications.store') }}" method="POST" class="row g-3">
        @csrf

        <!-- Notification Header -->
        <div class="col-md-6">
            <label for="header_id" class="form-label">Notification Header <span class="text-danger">*</span></label>
            <select name="header_id" id="header_id" class="form-control" required>
                <option value="">-- Select --</option>
                @foreach($headers as $h)
                <option value="{{ $h->id }}">{{ $h->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Send To -->
        <div class="col-md-6">
            <label for="send_to" class="form-label">Send To <span class="text-danger">*</span></label>
            <select name="send_to" id="send_to" class="form-control" required>
                <option value="users">Users</option>
                <option value="students">Students</option>
            </select>
        </div>

        <!-- USERS SECTION -->
        <div class="col-12" id="users_section" style="display:none;">
            <label class="form-label">User Target</label>
            <select id="user_type" name="user_type" class="form-control">
                <option value="all">All Users</option>
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

                <!-- Academic Year -->
                <div class="col-md-3">
                    <label>Academic Year</label>
                    <select id="academic_year" name="academic_year" class="form-control">
                        <option value="">-- all --</option>
                        @foreach($years as $y)
                        <option value="{{ $y->id }}">{{ $y->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- University -->
                <div class="col-md-3">
                    <label>University</label>
                    <select id="university_id" name="university_id" class="form-control">
                        <option value="">-- all --</option>
                        @foreach($universities as $un)
                        <option value="{{ $un->id }}">{{ $un->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Subcourse -->
                <div class="col-md-3">
                    <label>Subcourse</label>
                    <select id="subcourse_id" name="subcourse_id" class="form-control">
                        <option value="">-- all --</option>
                        @foreach($subcourses as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Student Type -->
                <div class="col-md-3">
                    <label>Student Target</label>
                    <select name="student_type" id="student_type" class="form-control">
                        <option value="all">All Students</option>
                        <option value="individual">Individual Students</option>
                    </select>
                </div>
            </div>

            <!-- Student List -->
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

    /* -------------------------------
     * SHOW / HIDE USERS / STUDENTS
     * ------------------------------- */
    function toggleSections() {
        $('#users_section').toggle($('#send_to').val() === 'users');
        $('#students_section').toggle($('#send_to').val() === 'students');
    }
    $('#send_to').change(toggleSections);
    toggleSections();

    /* USERS SUBSECTION */
    $('#user_type').change(() => {
        $('#user_multi').toggle($('#user_type').val() === 'individual');
    });

    /* STUDENTS SUBSECTION */
    $('#student_type').change(() => {
        $('#student_list_wrap').toggle($('#student_type').val() === 'individual');
    });


    /* ======================================================
     *     🔥 FINAL WORKING loadStudents() FUNCTION
     * ====================================================== */
    function loadStudents() {

        const selectedYear = $('#academic_year').val();
        const selectedUni  = $('#university_id').val();
        const selectedSub  = $('#subcourse_id').val();

        $.post("{{ route('notifications.fetchStudents') }}", {
            academic_year: selectedYear,
            university_id: selectedUni,
            subcourse_id: selectedSub,
            _token: "{{ csrf_token() }}"
        }, function(res) {

            /* ----------------------------------------
             * 1. UPDATE STUDENT LIST
             * ---------------------------------------- */
            const sList = $('#student_ids').empty();
            res.students.forEach(s => {
                sList.append(`<option value="${s.id}">${s.name} (${s.email ?? ''})</option>`);
            });

            /* ----------------------------------------
             * 2. UPDATE UNIVERSITY DROPDOWN
             * ---------------------------------------- */
            const uni = $('#university_id').empty()
                .append(`<option value="">-- All Universities --</option>`);

            res.universities.forEach(u => {
                uni.append(`
                    <option value="${u.id}" ${u.id == selectedUni ? 'selected' : ''}>
                        ${u.name}
                    </option>
                `);
            });

            /* ----------------------------------------
             * 3. UPDATE SUBCOURSE DROPDOWN (DEPENDENT)
             * ---------------------------------------- */
            const sub = $('#subcourse_id').empty()
                .append(`<option value="">-- All Subcourses --</option>`);

            if (selectedUni === "") {
                // No university selected → show all subcourses
                res.subcourses.forEach(sc => {
                    sub.append(`
                        <option value="${sc.id}" ${sc.id == selectedSub ? 'selected' : ''}>
                            ${sc.name}
                        </option>
                    `);
                });
            } else {
                // Show only subcourses linked to selected university
                res.subcourses
                    .filter(sc => sc.university_id == selectedUni)
                    .forEach(sc => {
                        sub.append(`
                            <option value="${sc.id}" ${sc.id == selectedSub ? 'selected' : ''}>
                                ${sc.name}
                            </option>
                        `);
                    });
            }
        });
    }


    /* ----------------------------------------
     *  AUTO LOAD WHEN FILTER CHANGES
     * ---------------------------------------- */
    $('#academic_year, #university_id, #subcourse_id').change(loadStudents);
    $('#load_students').click(loadStudents);


    /* ======================================================
     *     SUBMIT FORM — AJAX POST
     * ====================================================== */
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



{{-- <script>
$(function () {

    // -------------------------------
    // SHOW / HIDE USERS / STUDENTS
    // -------------------------------
    function toggleSections() {
        $('#users_section').toggle($('#send_to').val() === 'users');
        $('#students_section').toggle($('#send_to').val() === 'students');
    }
    $('#send_to').change(toggleSections);
    toggleSections();

    // USERS SUBSECTION
    $('#user_type').change(() => {
        $('#user_multi').toggle($('#user_type').val() === 'individual');
    });

    // STUDENTS SUBSECTION
    $('#student_type').change(() => {
        $('#student_list_wrap').toggle($('#student_type').val() === 'individual');
    });




    // INIT ON PAGE LOAD
    initFilterChoices();


    /* ======================================================
     * 🔥 FINAL WORKING loadStudents() FUNCTION
     * ====================================================== */
    function loadStudents() {

        const selectedYear = $('#academic_year').val();
        const selectedUni  = $('#university_id').val();
        const selectedSub  = $('#subcourse_id').val();

        $.post("{{ route('notifications.fetchStudents') }}", {
            academic_year: selectedYear,
            university_id: selectedUni,
            subcourse_id: selectedSub,
            _token: "{{ csrf_token() }}"
        }, function(res) {

            /* ----------------------------------------
             * 1. UPDATE STUDENT LIST
             * ---------------------------------------- */
            const sList = $('#student_ids').empty();
            res.students.forEach(s => {
                sList.append(`<option value="${s.id}">${s.name} (${s.email ?? ''})</option>`);
            });

            /* ----------------------------------------
             * 2. UPDATE UNIVERSITY DROPDOWN
             * ---------------------------------------- */
            const uni = $('#university_id').empty()
                .append(`<option value="">-- All Universities --</option>`);

            res.universities.forEach(u => {
                uni.append(`
                    <option value="${u.id}" ${u.id == selectedUni ? 'selected' : ''}>
                        ${u.name}
                    </option>
                `);
            });

            /* ----------------------------------------
             * 3. UPDATE SUBCOURSE DROPDOWN (DEPENDENT)
             * ---------------------------------------- */
            const sub = $('#subcourse_id').empty()
                .append(`<option value="">-- All Subcourses --</option>`);

            if (selectedUni === "") {
                // No university selected → show all subcourses
                res.subcourses.forEach(sc => {
                    sub.append(`
                        <option value="${sc.id}" ${sc.id == selectedSub ? 'selected' : ''}>
                            ${sc.name}
                        </option>
                    `);
                });
            } else {
                // Show only subcourses linked to selected university
                res.subcourses
                    .filter(sc => sc.university_id == selectedUni)
                    .forEach(sc => {
                        sub.append(`
                            <option value="${sc.id}" ${sc.id == selectedSub ? 'selected' : ''}>
                                ${sc.name}
                            </option>
                        `);
                    });
            }

            // 🔄 Re-initialize Choices for updated selects
            initFilterChoices();
        });
    }


    /* ----------------------------------------
     *  AUTO LOAD WHEN FILTER CHANGES
     * ---------------------------------------- */
    $('#academic_year, #university_id, #subcourse_id').change(loadStudents);
    $('#load_students').click(loadStudents);


    /* ======================================================
     *     SUBMIT FORM — AJAX POST
     * ====================================================== */
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
</script> --}}

