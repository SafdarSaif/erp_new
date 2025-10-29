<!-- 🎓 Student Query Modal -->
<div class="modal fade" id="studentQueryModal" tabindex="-1" aria-labelledby="studentQueryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-3">
            <div class="modal-header bg-primary text-white py-2">
                <h5 class="modal-title fw-semibold" id="studentQueryModalLabel">
                    <i class="ri-question-line me-2"></i> Student Query Portal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Step 1 -->
                <div id="step1">
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Enter Your Student ID</label>
                        <input type="text" id="student_id" class="form-control form-control-lg"
                            placeholder="Enter your Student ID">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary px-4" id="fetchStudent">
                            <i class="ri-arrow-right-line me-1"></i> Next
                        </button>
                    </div>
                </div>

                <!-- Step 2 -->
                <div id="step2" class="d-none">
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="ri-information-line fs-4 me-2"></i>
                        <div><strong>Note:</strong> If these details are not yours, please contact the institute.</div>
                    </div>

                    <form id="queryForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="student_id" id="student_id_hidden">

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input type="text" id="name" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Mobile</label>
                                <input type="text" id="mobile" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Query Head</label>
                                <select name="query_head_id" class="form-select" required>
                                    <option value="">Select Query Head</option>
                                    @foreach($queryHeads as $qh)
                                        <option value="{{ $qh->id }}">{{ $qh->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Attachment (optional)</label>
                                <input type="file" name="attachment" class="form-control">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Query</label>
                            <textarea name="query" class="form-control" rows="4" required
                                placeholder="Write your query in detail..."></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-4 me-2">
                                <i class="ri-send-plane-line me-1"></i> Submit Query
                            </button>
                            <button type="button" id="viewQueries" class="btn btn-outline-primary px-4">
                                <i class="ri-eye-line me-1"></i> View My Queries
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
