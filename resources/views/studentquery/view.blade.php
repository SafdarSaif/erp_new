<div class="modal-body position-relative">
    <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"
        aria-label="Close"></button>

    <style>
        .modal-body h3 {
            font-weight: 700;
        }

        .card {
            border-radius: 1rem;
            transition: 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 8px 24px rgba(0, 123, 255, 0.15);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-control[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
            border-color: #dee2e6;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #0d6efd;
        }

        .form-section {
            margin-bottom: 1.25rem;
        }

        .list-unstyled a {
            text-decoration: none;
            color: #0d6efd;
        }

        .list-unstyled a:hover {
            text-decoration: underline;
        }

        .badge-status {
            font-size: 0.8rem;
            border-radius: 0.4rem;
            padding: 0.3rem 0.6rem;
        }
    </style>

    <div class="text-center mb-4">
        <h3 class="text-primary">🎓 Student Query Details</h3>
        <p class="text-muted">View all queries submitted by this student.</p>
    </div>

    {{-- ✅ Student Info --}}
    @if ($student)
    <div class="text-center mb-4">
        <h5 class="text-primary">👤 <strong>{{ $student->full_name }}</strong></h5>
        <p class="text-muted mb-0">
            📞 {{ $student->mobile ?? 'N/A' }} <br>
            📧 {{ $student->email ?? 'N/A' }}
        </p>
    </div>
    @endif

    {{-- ✅ Queries --}}
    @if ($queries->count() > 0)
    <div class="row g-4">
        @foreach ($queries as $query)
        {{-- 🟦 Left: Query Card --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="mb-2">#{{ $loop->iteration }}
                        <span class="float-end text-muted small">
                            {{ $query->created_at->format('d M Y') }}
                        </span>
                    </h5>
                    <p class="text-secondary small mb-2">
                        Head: <strong>{{ $query->queryHead->name ?? 'N/A' }}</strong>
                    </p>

                    <div class="form-section">
                        <label class="form-label">Student Query</label>
                        <textarea class="form-control" rows="4" readonly>{{ $query->query }}</textarea>
                    </div>

                    @if ($query->attachment)
                    <div class="form-section">
                        <label class="form-label">Attachment</label>
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ asset($query->attachment) }}" target="_blank" class="attachment-link">📎 {{
                                    basename($query->attachment) }}</a>
                            </li>
                        </ul>
                    </div>
                    @endif

                    <div class="mt-3">
                        <span class="badge bg-{{ $query->status == 1 ? 'success' : 'warning text-dark' }} badge-status">
                            {{ $query->status == 1 ? 'Answered' : 'Pending' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 🟩 Right: Answer View --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="form-section">
                        <label class="form-label">Answer</label>
                        <textarea class="form-control" rows="4"
                            readonly>{{ $query->answer ?? 'No answer provided yet.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-4">
        <img src="{{ asset('assets/images/empty-state.svg') }}" height="100" class="mb-3">
        <h6 class="text-muted">No queries found for this student.</h6>
    </div>
    @endif
</div>

<div class="modal-footer justify-content-end">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
