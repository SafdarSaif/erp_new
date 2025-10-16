@extends('layouts.main')

@push('styles')
    <style>
        .education-dashboard .card {
            transition: transform 0.2s ease-in-out;
        }

        .education-dashboard .card:hover {
            transform: translateY(-2px);
        }

        .avatar-item {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-light-primary {
            background-color: rgba(93, 135, 255, 0.1);
        }

        .bg-light-success {
            background-color: rgba(19, 222, 185, 0.1);
        }

        .bg-light-warning {
            background-color: rgba(255, 174, 31, 0.1);
        }

        .bg-light-info {
            background-color: rgba(73, 190, 255, 0.1);
        }
    </style>
@endpush

@section('content')
    <main class="app-wrapper">
        <div class="app-container">
            <!-- start page title -->
            <div class="hstack flex-wrap gap-3 mb-5">
                <div class="flex-grow-1">
                    <h4 class="mb-1 fw-semibold">Education Management Dashboard</h4>
                    <nav>
                        <ol class="breadcrumb breadcrumb-arrow mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Overview</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex my-xl-auto align-items-center flex-wrap flex-shrink-0">
                    <a href="{{ route('students.create') }}" class="btn btn-sm btn-light-primary">
                        <i class="ri-user-add-line me-1"></i>Add Student
                    </a>
                </div>
            </div>
            <!-- end page title -->

            <div class="education-dashboard">
                <!-- Key Metrics Row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="card card-h-100 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                                    <div class="flex-grow-1">
                                        <div class="hstack gap-3 mb-3">
                                            <div class="bg-primary-subtle text-primary avatar avatar-item rounded-2">
                                                <i class="ri-user-2-line fs-18 fw-medium"></i>
                                            </div>
                                            <h6 class="mb-0 fs-13">Total Students</h6>
                                        </div>
                                        <h4 class="fw-semibold fs-5 mb-0">
                                            {{ App\Models\Student::count() }}
                                        </h4>
                                        <p class="text-muted mb-0 fs-12">Active students</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <div class="d-flex align-items-end justify-content-end gap-3">
                                            <span class="text-success">
                                                <i class="ri-arrow-right-up-line fs-12"></i>
                                                {{ App\Models\Student::whereDate('created_at', '>=', now()->subDays(30))->count() }}
                                            </span>
                                        </div>
                                        <div class="text-muted fs-12">+new this month</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card card-h-100 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                                    <div class="flex-grow-1">
                                        <div class="hstack gap-3 mb-3">
                                            <div class="bg-success-subtle text-success avatar avatar-item rounded-2">
                                                <i class="ri-book-open-line fs-18 fw-medium"></i>
                                            </div>
                                            <h6 class="mb-0 fs-13">Total Courses</h6>
                                        </div>
                                        <h4 class="fw-semibold fs-5 mb-0">
                                            {{ \App\Models\Academics\Course::count() }}
                                        </h4>
                                        <p class="text-muted mb-0 fs-12">Active courses</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <div class="d-flex align-items-end justify-content-end gap-3">
                                            <span class="text-success">
                                                <i class="ri-arrow-right-up-line fs-12"></i>
                                                {{ \App\Models\Academics\SubCourse::count() }}
                                            </span>
                                        </div>
                                        <div class="text-muted fs-12">Sub-courses</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card card-h-100 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                                    <div class="flex-grow-1">
                                        <div class="hstack gap-3 mb-3">
                                            <div class="bg-warning-subtle text-warning avatar avatar-item rounded-2">
                                                <i class="ri-money-dollar-circle-line fs-18 fw-medium"></i>
                                            </div>
                                            <h6 class="mb-0 fs-13">Total Revenue</h6>
                                        </div>
                                        <h4 class="fw-semibold fs-5 mb-0">
                                            ₹{{ number_format(\App\Models\StudentLedger::sum('amount')) }}
                                        </h4>
                                        <p class="text-muted mb-0 fs-12">All time collection</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        @php
                                            $monthlyRevenue = \App\Models\StudentLedger::whereMonth(
                                                'created_at',
                                                now()->month,
                                            )->sum('amount');
                                            $lastMonthRevenue = \App\Models\StudentLedger::whereMonth(
                                                'created_at',
                                                now()->subMonth()->month,
                                            )->sum('amount');
                                            $revenueGrowth =
                                                $lastMonthRevenue > 0
                                                    ? (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
                                                    : 0;
                                        @endphp
                                        <div class="d-flex align-items-end justify-content-end gap-3">
                                            <span class="{{ $revenueGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                                <i
                                                    class="ri-arrow-right-{{ $revenueGrowth >= 0 ? 'up' : 'down' }}-line fs-12"></i>
                                                {{ number_format(abs($revenueGrowth), 1) }}%
                                            </span>
                                        </div>
                                        <div class="text-muted fs-12">this month</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="card card-h-100 overflow-hidden">
                            <div class="card-body p-4">
                                <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                                    <div class="flex-grow-1">
                                        <div class="hstack gap-3 mb-3">
                                            <div class="bg-info-subtle text-info avatar avatar-item rounded-2">
                                                <i class="ri-building-2-line fs-18 fw-medium"></i>
                                            </div>
                                            <h6 class="mb-0 fs-13">Universities</h6>
                                        </div>
                                        <h4 class="fw-semibold fs-5 mb-0">
                                            {{ \App\Models\Academics\University::count() }}
                                        </h4>
                                        <p class="text-muted mb-0 fs-12">Partner universities</p>
                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <div class="d-flex align-items-end justify-content-end gap-3">
                                            <span class="text-success">
                                                <i class="ri-arrow-right-up-line fs-12"></i>
                                                {{ \App\Models\Academics\Department::count() }}
                                            </span>
                                        </div>
                                        <div class="text-muted fs-12">Departments</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Analytics Row -->
                <div class="row g-4 mb-4">
                    <!-- Revenue Chart -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">Revenue Analytics</h5>
                                    <p class="mb-0 card-subtitle">Monthly revenue trends</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <select class="form-select form-select-sm" id="revenue-period">
                                        <option value="1M">1 Month</option>
                                        <option value="6M">6 Months</option>
                                        <option value="1Y">1 Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="revenue-analytics-chart" style="min-height: 300px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Quick Statistics</h5>
                            </div>
                            <div class="card-body">
                                <div class="vstack gap-3">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <div>
                                            <h6 class="mb-0">Pending Fees</h6>
                                            <small class="text-muted">This month</small>
                                        </div>
                                        <span class="badge bg-warning">₹{{ number_format(0) }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <div>
                                            <h6 class="mb-0">New Admissions</h6>
                                            <small class="text-muted">This month</small>
                                        </div>
                                        <span
                                            class="badge bg-success">{{ App\Models\Student::whereMonth('created_at', now()->month)->count() }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <div>
                                            <h6 class="mb-0">Active Courses</h6>
                                            <small class="text-muted">Currently running</small>
                                        </div>
                                        <span
                                            class="badge bg-info">{{ \App\Models\Academics\Course::where('status', true)->count() }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <div>
                                            <h6 class="mb-0">Total Subjects</h6>
                                            <small class="text-muted">Across all courses</small>
                                        </div>
                                        <span class="badge bg-primary">{{ \App\Models\Academics\Subject::count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity and Students Row -->
                <div class="row g-4">
                    <!-- Recent Students -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Recent Students</h5>
                                <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-primary">View
                                    All</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Course</th>
                                                <th>Join Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $recentStudents = App\Models\Student::with([
                                                    'subCourse',
                                                    'academicYear',
                                                ])
                                                    ->latest()
                                                    ->take(5)
                                                    ->get();
                                            @endphp
                                            @foreach ($recentStudents as $student)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="avatar avatar-sm bg-light-primary rounded-circle me-2">
                                                                {{ substr($student->full_name, 0, 1) }}
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0 fs-13">{{ $student->full_name }}</h6>
                                                                <small class="text-muted">{{ $student->email }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $student->subCourse->name ?? 'N/A' }}</td>
                                                    <td>{{ $student->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Distribution -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Course Distribution</h5>
                            </div>
                            <div class="card-body">
                                <div id="course-distribution-chart" style="min-height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- University and Department Overview -->
                <div class="row g-4 mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">University Overview</h5>
                                <a href="{{ route('university.index') }}" class="btn btn-sm btn-outline-primary">Manage
                                    Universities</a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @php
                                        $universities = \App\Models\Academics\University::withCount('departments')
                                            ->take(4)
                                            ->get();
                                    @endphp
                                    @foreach ($universities as $university)
                                        <div class="col-lg-3 col-md-6">
                                            <div class="card bg-light border-0">
                                                <div class="card-body text-center">
                                                    <div
                                                        class="avatar avatar-lg bg-primary-subtle text-primary rounded-circle mb-3 mx-auto">
                                                        <i class="ri-building-2-line fs-24"></i>
                                                    </div>
                                                    <h6 class="fw-semibold">{{ $university->name }}</h6>
                                                    <p class="text-muted mb-2">{{ $university->departments_count }}
                                                        Departments</p>
                                                    <span class="badge bg-success">Active</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

{{-- @push('scripts')
    <script>
        // Revenue Analytics Chart
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue Chart
            var revenueOptions = {
                series: [{
                    name: 'Revenue',
                    data: [{
                        {!! \App\Models\StudentLedger::selectRaw('MONTH(created_at) as month, SUM(amount) as total')->whereYear('created_at', now()->year)->groupBy('month')->orderBy('month')->get()->map(function ($item) {
                                return $item->total;
                            })->toJson() !!}
                    }]
                }],
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#5D87FF'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ]
                },
                tooltip: {
                    x: {
                        format: 'MMM'
                    }
                }
            };

            var revenueChart = new ApexCharts(document.querySelector("#revenue-analytics-chart"), revenueOptions);
            revenueChart.render();

            // Course Distribution Chart
            var courseOptions = {
                series: [{
                    {!! \App\Models\Student::selectRaw('sub_course_id, COUNT(*) as count')->with('subCourse')->groupBy('sub_course_id')->get()->map(function ($item) {
                            return $item->count;
                        })->toJson() !!}
                }],
                chart: {
                    type: 'donut',
                    height: 350
                },
                labels: {
                    {!! \App\Models\Student::selectRaw('sub_courses.name as course_name')->join('sub_courses', 'students.sub_course_id', '=', 'sub_courses.id')->groupBy('sub_courses.name')->pluck('course_name')->toJson() !!}
                },
                colors: ['#5D87FF', '#49BEFF', '#13DEB9', '#FFAE1F', '#FA896B'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

            var courseChart = new ApexCharts(document.querySelector("#course-distribution-chart"), courseOptions);
            courseChart.render();
        });
    </script>
@endpush --}}


{{-- @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make sure ApexCharts library is available
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts is not loaded. Include ApexCharts JS before this script.');
        return;
    }

    // Data pulled from Laravel controller (already formatted)
    var monthlyRevenue = {!! json_encode($monthlyRevenue) !!}; // array of 12 numbers
    var courseLabels = {!! json_encode($courseDistribution['labels'] ?? []) !!}; // array of names
    var courseCounts = {!! json_encode($courseDistribution['counts'] ?? []) !!}; // array of numbers

    // Revenue Chart
    var revenueOptions = {
        series: [{
            name: 'Revenue',
            data: monthlyRevenue
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: {
            categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    // Format value as rupee with comma (simple)
                    return '₹' + Number(val).toLocaleString();
                }
            }
        }
    };

    var revenueChartEl = document.querySelector("#revenue-analytics-chart");
    if (revenueChartEl) {
        var revenueChart = new ApexCharts(revenueChartEl, revenueOptions);
        revenueChart.render();
    }

    // Course Distribution Chart (donut)
    var courseOptions = {
        series: courseCounts,
        chart: {
            type: 'donut',
            height: 350
        },
        labels: courseLabels,
        legend: { position: 'bottom' },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 200 },
                legend: { position: 'bottom' }
            }
        }]
    };

    var courseChartEl = document.querySelector("#course-distribution-chart");
    if (courseChartEl) {
        var courseChart = new ApexCharts(courseChartEl, courseOptions);
        courseChart.render();
    }
});
</script>
@endpush --}}


<!-- 1) load ApexCharts (ensure this appears before the chart init) -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    try {
        // 2) Ensure we have PHP variables (fallback to computing them in the view)
        @php
            // Monthly revenue fallback (12 months array)
            if (!isset($monthlyRevenue) || !is_array($monthlyRevenue)) {
                $rows = \App\Models\StudentLedger::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                    ->whereYear('created_at', now()->year)
                    ->groupBy('month')
                    ->pluck('total','month')
                    ->toArray();
                $tmp = [];
                for ($m = 1; $m <= 12; $m++) {
                    $tmp[] = isset($rows[$m]) ? (float) $rows[$m] : 0;
                }
                $monthlyRevenue = $tmp;
            }

            // Course distribution fallback
            if (!isset($courseDistribution) || !is_array($courseDistribution)) {
                $rows = \App\Models\Student::selectRaw('sub_courses.name as course_name, COUNT(*) as count')
                    ->join('sub_courses', 'students.sub_course_id', '=', 'sub_courses.id')
                    ->groupBy('sub_courses.name')
                    ->orderByDesc('count')
                    ->get();

                $labels = $rows->pluck('course_name')->toArray();
                $counts = $rows->pluck('count')->map(function($v){ return (int)$v; })->toArray();

                $courseDistribution = [
                    'labels' => $labels,
                    'counts' => $counts,
                ];
            }
        @endphp

        // 3) Pass PHP arrays to JS safely (guaranteed arrays now)
        var monthlyRevenue = {!! json_encode($monthlyRevenue ?? array_fill(0,12,0)) !!};
        var courseLabels     = {!! json_encode($courseDistribution['labels'] ?? []) !!};
        var courseCounts     = {!! json_encode($courseDistribution['counts'] ?? []) !!};

        // Debug logs — open browser console (F12) to inspect
        console.log('monthlyRevenue:', monthlyRevenue);
        console.log('courseLabels:', courseLabels);
        console.log('courseCounts:', courseCounts);

        // 4) Verify ApexCharts is available
        if (typeof ApexCharts === 'undefined') {
            console.error('ApexCharts not loaded. Chart will not render.');
            return;
        }

        // 5) Revenue Area Chart
        var revenueChartEl = document.querySelector("#revenue-analytics-chart");
        if (revenueChartEl) {
            var revenueOptions = {
                series: [{ name: 'Revenue', data: monthlyRevenue }],
                chart: { height: 350, type: 'area', toolbar: { show: false } },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                xaxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
                tooltip: {
                    y: {
                        formatter: function(val) { return '₹' + Number(val).toLocaleString(); }
                    }
                }
            };

            try {
                var revenueChart = new ApexCharts(revenueChartEl, revenueOptions);
                revenueChart.render();
            } catch (err) {
                console.error('Revenue chart render error:', err);
            }
        } else {
            console.warn('#revenue-analytics-chart element not found');
        }

        // 6) Course Distribution Donut
        var courseChartEl = document.querySelector("#course-distribution-chart");
        if (courseChartEl) {
            var courseOptions = {
                series: courseCounts,
                chart: { type: 'donut', height: 350 },
                labels: courseLabels,
                legend: { position: 'bottom' },
                responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }]
            };

            try {
                var courseChart = new ApexCharts(courseChartEl, courseOptions);
                courseChart.render();
            } catch (err) {
                console.error('Course distribution chart render error:', err);
            }
        } else {
            console.warn('#course-distribution-chart element not found');
        }

    } catch (e) {
        console.error('Unexpected error initializing charts:', e);
    }
});
</script>


