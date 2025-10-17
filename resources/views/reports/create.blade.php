<div class="modal-body">
    <div class="text-center mb-3">
        <h3 class="mb-2 text-primary">Generate Student Reports</h3>
        {{-- <p class="text-muted">Fill in the menu details below</p> --}}
    </div>

    <form id="addReportFilter" action="{{ route('reports.students.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
        <div class="col-md-6">
            <label for="name" class="form-label">Report Tag</label>
            <input type="text" name="tag" id="tag" class="form-control" placeholder="ex: January Report">
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Student Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="ex: January Report">
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Mobile Number</label>
            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="ex: January Report">
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Academic Year</label>
            <select name="academic_year_id" id="academic_year_id" class="form-control">
                <option value=""></option>
                @foreach ($academicYears as $academicYear)
                    <option value="{{$academicYear->id}}">{{$academicYear->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">University</label>
            {{-- <input type="text" name="university_id" id="university_id" class="form-control" placeholder="ex: January Report"> --}}
            <select name="university_id" id="university_id" class="form-control">
                <option value=""></option>
                @foreach ($universities as $university)
                    <option value="{{$university->id}}">{{$university->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Course Type</label>
            {{-- <input type="text" name="course_type_id" id="course_type_id" class="form-control" placeholder="ex: January Report"> --}}
            <select name="course_type_id" id="course_type_id" class="form-control">
                <option value=""></option>
                @foreach ($courseTypes as $courseType)
                    <option value="{{$courseType->id}}">{{$courseType->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Course</label>
            {{-- <input type="text" name="course_id" id="course_id" class="form-control" placeholder="ex: January Report"> --}}
            <select name="course_id" id="course_id" class="form-control">
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Sub Course</label>
            {{-- <input type="text" name="sub_course_id" id="sub_course_id" class="form-control" placeholder="ex: January Report"> --}}
            <select name="sub_course_id" id="sub_course_id" class="form-control">
                <option value=""></option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Mode</label>
            {{-- <input type="text" name="admissionmode_id" id="admissionmode_id" class="form-control" placeholder="ex: January Report"> --}}
            <select name="admissionmode_id" id="admissionmode_id" class="form-control">
                <option value=""></option>
                @foreach ($admissionModes as $addMode)
                    <option value="{{$addMode->id}}">{{$addMode->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Course Mode</label>
            {{-- <input type="text" name="course_mode_id" id="course_mode_id" class="form-control" placeholder="ex: January Report"> --}}
            <select name="course_mode_id" id="course_mode_id" class="form-control">
                <option value=""></option>
                @foreach ($courseModes as $courseMode)
                    <option value="{{$courseMode->id}}">{{$courseMode->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Language</label>
            {{-- <input type="text" name="language_id" id="language_id" class="form-control" placeholder="ex: January Report"> --}}
            <select name="language_id" id="language_id" class="form-control">
                <option value=""></option>
                @foreach ($languages as $language)
                    <option value="{{$language->id}}">{{$language->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Blood Group</label>
            {{-- <input type="text" name="blood_group_id" id="blood_group_id" class="form-control" placeholder="ex: January Report"> --}}
            <select name="blood_group_id" id="blood_group_id" class="form-control">
                <option value=""></option>
                @foreach ($bloodGroups as $bloodGroup)
                    <option value="{{$bloodGroup->id}}">{{$bloodGroup->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Religion</label>
            {{-- <input type="text" name="religion_id" id="religion_id" class="form-control" placeholder="ex: January Report"> --}}
            <select name="religion_id" id="religion_id" class="form-control">
                <option value=""></option>
                @foreach ($religions as $religion)
                    <option value="{{$religion->id}}">{{$religion->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Category</label>
            {{-- <input type="text" name="category_id" id="category_id" class="form-control" placeholder="ex: January Report"> --}}
            <select name="category_id" id="category_id" class="form-control">
                <option value=""></option>
                @foreach ($categories as $categorie)
                    <option value="{{$categorie->id}}">{{$categorie->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Semester</label>
            <input type="text" name="semester" id="semester" class="form-control" placeholder="ex: January Report">
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Gender</label>
            <input type="text" name="gender" id="gender" class="form-control" placeholder="ex: January Report">
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Fee</label>
            <input type="text" name="total_fee" id="total_fee" class="form-control" placeholder="ex: January Report">
        </div>
        <div class="col-md-6">
            <label for="name" class="form-label">Status</label>
            <input type="text" name="status" id="status" class="form-control" placeholder="ex: January Report">
        </div>

        <div class="col-12 text-center mt-5">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>




<script>
    $(document).ready(function(){
        $('#university_id').on('change',function(){
            var university_id = $(this).val();
            var courseType = $('#course_type_id').val();
            $.ajax({
                url:"{{route('getCourseByUniversityAndCourseType')}}",
                type:'get',
                data:{universityId:university_id,courseType:courseType},
                success:function(res){
                    if(res.status=="success"){
                        option = "<option></option>";
                        $.each(res.message,function(key,val){
                            option += "<option value="+val.id+">"+val.name+"</option>";
                        });
                        $('#course_id').html(option);
                    }else{
                        toastr.success(res.message);
                    }                    
                }
            })
        });
        $('#course_type_id').on('change',function(){
            var university_id = $('#university_id').val();
            var courseType = $(this).val();
            $.ajax({
                url:"{{route('getCourseByUniversityAndCourseType')}}",
                type:'get',
                data:{universityId:university_id,courseType:courseType},
                success:function(res){
                    if(res.status=="success"){
                        option = "<option></option>";
                        $.each(res.message,function(key,val){
                            option += "<option value="+val.id+">"+val.name+"</option>";
                        });
                        $('#course_id').html(option);
                    }else{
                        toastr.success(res.message);
                    }
                }
            })
        });
        $('#course_id').on('change',function(){
            var courseId = $(this).val();
            $.ajax({
                url:"{{route('getSubCourseByCourseId')}}",
                type:'get',
                data:{courseId:courseId},
                success:function(res){
                    if(res.status=="success"){
                        option = "<option></option>";
                        $.each(res.message,function(key,val){
                            option += "<option value="+val.id+">"+val.name+"</option>";
                        });
                        $('#sub_course_id').html(option);
                    }else{
                        toastr.success(res.message);
                    }
                }
            })
        });
    })
  $(function() {
    $("#addReportFilter").submit(function(e) {
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
