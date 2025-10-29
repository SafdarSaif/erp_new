@extends('layouts.main')
@section('content')

<div class="container py-5">
    <div class="card p-4 shadow">
        <h4 class="text-center text-primary mb-4">
            My Queries — {{ $student->name }} ({{ $student->student_id }})
        </h4>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Query Head</th>
                    <th>Query</th>
                    <th>Attachment</th>
                    <th>Answer</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($queries as $q)
                    <tr>
                        <td>{{ $q->queryHead->name ?? '-' }}</td>
                        <td>{{ $q->query }}</td>
                        <td>
                            @if($q->attachment)
                                <a href="{{ asset('storage/'.$q->attachment) }}" target="_blank">View</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $q->answer ?? 'Pending' }}</td>
                        <td>
                            @if($q->status == 1)
                                <span class="badge bg-success">Answered</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">No queries found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
