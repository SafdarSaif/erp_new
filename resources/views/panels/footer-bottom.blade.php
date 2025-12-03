<div class="modal fade" id="modal-md" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" id="modal-md-content">
        </div>
    </div>
</div>

<div class="modal fade" id="modal-lg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="modal-lg-content">
        </div>
    </div>
</div>

<div class="modal fade" id="modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content" id="modal-xl-content">
        </div>
    </div>
</div>
<script>
    function toTitleCase(str) {
        return str
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
            .join(' ');
    }
    function add(url, modal) {
        if (modal.length > 0) {
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    $('#' + modal + '-content').html(data);
                    $('#' + modal).modal('show');
                }
            })
        } else {
            window.location.href = url
        }
    }

    function edit(url, modal) {
        $(".modal").modal('hide');
        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                $('#' + modal + '-content').html(data);
                $('#' + modal).modal('show');
            }
        })
    }



    // function updateActiveStatus(url, table) {
    //     $.ajax({
    //         url: url,
    //         type: "GET",
    //         processData: false,
    //         contentType: false,
    //         dataType: 'json',
    //         success: function (response) {

    //             if (response.status == 'success') {
    //                 toastr.success(response.message);
    //             } else {
    //                 window.location.href = url
    //             }
    //         }
    //     });
    // }



    function edit(url, modal) {
        $(".modal").modal('hide');
        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                $('#' + modal + '-content').html(data);
                $('#' + modal).modal('show');
            }
        })
    }


     function view(url, modal) {
        $(".modal").modal('hide');
        $.ajax({
            url: url,
            type: "GET",
            success: function (data) {
                $('#' + modal + '-content').html(data);
                $('#' + modal).modal('show');
            }
        })
    }

    function updateActiveStatus(url, table) {
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                if (response.status == 'success') {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
                $('#' + table).DataTable().ajax.reload();
            }
        })
    }

    function destry(url, table) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it!',
            customClass: {
                confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect waves-light'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "GET",
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            toastr.success(response.message);
                            if (table.length > 0) {
                                $('#' + table).DataTable().ajax.reload();
                            } else {
                                window.location.reload();
                            }
                        } else {
                            toastr.error(response.message);
                        }
                    }
                })
            }
        });
    }


    function destryStatus(url, table) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it!',
            customClass: {
                confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect waves-light'
            },
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: url,
                    type: "GET",
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            toastr.success(response.message);
                            if (table.length > 0) {
                                $('#' + table).DataTable().ajax.reload();
                            } else {
                                window.location.reload();
                            }
                        } else {
                            toastr.error(response.message);
                        }
                    }
                })
            }
        });
    }
</script>

<script>
    function allot(url, modal) {
        alert(url);
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                $('#' + modal + '-content').html(data);
                $('#' + modal).modal('show');
            }
        })
    }
</script>



<script>
    //     let eligibilityChoices = null;

// $(document).on('shown.bs.modal', function () {

//     if (document.querySelector('#eligibility')) {

//         if (eligibilityChoices) {
//             eligibilityChoices.destroy();
//         }

//         eligibilityChoices = new Choices('#eligibility', {
//             removeItemButton: true,
//             placeholder: true,
//             placeholderValue: "Select eligibility criteria",
//             searchEnabled: true
//         });
//     }

// });
//     let universityChoices = null;




let eligibilityChoices = null;
let universityChoices = null;
let universityChoicesEdit = null;
let acceptableTypeChoices = null;
let acceptableTypeChoicesEdit = null;

$(document).on('shown.bs.modal', function () {

    /** --------------------------
     *  ELIGIBILITY
     * -------------------------- */
    if (document.querySelector('#eligibility')) {
        if (eligibilityChoices) eligibilityChoices.destroy();

        eligibilityChoices = new Choices('#eligibility', {
            removeItemButton: true,
            placeholder: true,
            searchEnabled: true
        });
    }

    /** --------------------------
     *  UNIVERSITY - CREATE
     * -------------------------- */
    if (document.querySelector('#university_id')) {
        if (universityChoices) universityChoices.destroy();

        universityChoices = new Choices('#university_id', {
            removeItemButton: true,
            searchEnabled: true
        });
    }

    /** --------------------------
     *  UNIVERSITY - EDIT
     * -------------------------- */
    if (document.querySelector('#edit_university_id')) {
        if (universityChoicesEdit) universityChoicesEdit.destroy();

        universityChoicesEdit = new Choices('#edit_university_id', {
            removeItemButton: true,
            searchEnabled: true
        });
    }

    /** --------------------------
     *  ACCEPTABLE TYPES - CREATE
     * -------------------------- */
    if (document.querySelector('#acceptable_type')) {
        if (acceptableTypeChoices) acceptableTypeChoices.destroy();

        acceptableTypeChoices = new Choices('#acceptable_type', {
            removeItemButton: true,
            searchEnabled: true
        });
    }

    /** --------------------------
     *  ACCEPTABLE TYPES - EDIT
     * -------------------------- */
    if (document.querySelector('#edit_acceptable_type')) {
        if (acceptableTypeChoicesEdit) acceptableTypeChoicesEdit.destroy();

        acceptableTypeChoicesEdit = new Choices('#edit_acceptable_type', {
            removeItemButton: true,
            searchEnabled: true
        });
    }

});






</script>



<script>
    $(document).on("click", ".generateID", function () {
    let id = $(this).data("id");
    let btn = $(this);

    btn.html("Please wait...").prop("disabled", true);

    $.post(`/students/generate-id/${id}`, {_token: "{{ csrf_token() }}"}, function(response){
        if(response.status){
            btn.parent().html(response.unique_id);
            $('#student-table').DataTable().ajax.reload(null, false);
        } else {
            btn.html("Generate").prop("disabled", false);
            alert(response.message);
        }
    });
});

</script>


@if(auth()->check() && isset($sessionExpiry))
<div id="session-countdown" style="font-weight:bold;color:red;font-size:14px;"></div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let expiry = {{ $sessionExpiry }} * 1000;
    let now = new Date().getTime();
    let remaining = expiry - now;

    // 1️⃣ Show POPUP (not toaster) 1 minute before expiry
    let warningBefore = 60000; // 1 minute

    if (remaining > warningBefore) {
        setTimeout(function () {
            Swal.fire({
                icon: 'warning',
                title: 'Session Expiring Soon',
                text: 'Your session will expire in 1 minute. Please save your work.',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            });
        }, remaining - warningBefore);
    }

    // 2️⃣ Countdown timer (your original code)
    function countdown() {
        let now = new Date().getTime();
        let diff = expiry - now;

        if (diff <= 0) {
            document.getElementById("session-countdown").innerHTML = "Session Expired";
            window.location.reload();
            return;
        }

        let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((diff % (1000 * 60)) / 1000);

        document.getElementById("session-countdown").innerHTML =
            "Session Expires In: " + minutes + "m " + seconds + "s";
    }

    setInterval(countdown, 1000);
    countdown();
</script>
@endif








</body>

</html>
