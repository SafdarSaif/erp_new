<?php

use App\Http\Controllers\Settings\AcademicYearController;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubCourseController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Settings\CourseTypeController;
use App\Http\Controllers\Settings\AdmissionModeController;
use App\Http\Controllers\Settings\CourseModeController;
use App\Http\Controllers\Settings\LanguageController;
use App\Http\Controllers\Settings\BloodGroupController;
use App\Http\Controllers\Settings\CategoryController;
use App\Http\Controllers\Settings\ReligionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Accounts\StudentFeeStructureController;
use App\Http\Controllers\StudentLedgerController;
use App\Http\Controllers\UniversityFeesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MiscellaneousFeeController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/demo', function () {
    return view('content.datatable');
});

Route::get('/', function () {
    return view('content.index');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('content.home');
//     })->name('dashboard');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



Route::get('menu', function () {
    return view('menu.index');
});



Route::prefix('settings')->group(function () {
    Route::get('/academicyears', [AcademicYearController::class, 'index'])->name('academicyears');
    Route::post('/academicyears', [AcademicYearController::class, 'store'])->name('academicyears');
    Route::put('/academicyears/{id}', [AcademicYearController::class, 'update'])->name('academicyears.update');
    Route::get('/academicyears/create', [AcademicYearController::class, 'create'])->name('academicyears.create');
    Route::get('/academicyears/edit/{id}', [AcademicYearController::class, 'edit'])->name('academicyears.edit');
    Route::get('/academicyears/status/{id}', [AcademicYearController::class, 'status'])->name('academicyears.status');
    Route::delete('/academicyears/delete/{id}', [AcademicYearController::class, 'delete'])->name('academicyears.delete');


    // Course Types
    Route::get('/coursetypes', [CourseTypeController::class, 'index'])->name('coursetypes');
    Route::post('/coursetypes', [CourseTypeController::class, 'store'])->name('coursetypes.store');
    // Route::post('/coursetypes/{id}', [CourseTypeController::class, 'update'])->name('coursetypes.update');
    Route::get('/coursetypes/create', [CourseTypeController::class, 'create'])->name('coursetypes.create');
    Route::get('/coursetypes/edit/{id}', [CourseTypeController::class, 'edit'])->name('coursetypes.edit');
    Route::post('/coursetypes/update/{id}', [CourseTypeController::class, 'update'])->name('coursetypes.update');
    Route::get('/coursetypes/status/{id}', [CourseTypeController::class, 'status'])->name('coursetypes.status');
    Route::delete('/coursetypes/delete/{id}', [CourseTypeController::class, 'destroy'])->name('coursetypes.delete');

    // admission mode
    Route::get('/admissionmodes', [AdmissionModeController::class, 'index'])->name('admissionmodes');
    Route::post('/admissionmodes', [AdmissionModeController::class, 'store'])->name('admissionmodes.store');
    Route::get('/admissionmodes/create', [AdmissionModeController::class, 'create'])->name('admissionmodes.create');
    Route::get('/admissionmodes/edit/{id}', [AdmissionModeController::class, 'edit'])->name('admissionmodes.edit');
    Route::post('/admissionmodes/update/{id}', [AdmissionModeController::class, 'update'])->name('admissionmodes.update');
    Route::get('/admissionmodes/status/{id}', [AdmissionModeController::class, 'status'])->name('admissionmodes.status');
    Route::delete('/admissionmodes/delete/{id}', [AdmissionModeController::class, 'destroy'])->name('admissionmodes.delete');

    // course mode
    Route::get('coursemodes', [CourseModeController::class, 'index'])->name('coursemodes');
    Route::get('coursemodes/create', [CourseModeController::class, 'create'])->name('coursemodes.create');
    Route::post('coursemodes/store', [CourseModeController::class, 'store'])->name('coursemodes.store');
    Route::get('coursemodes/edit/{id}', [CourseModeController::class, 'edit'])->name('coursemodes.edit');
    Route::post('coursemodes/update/{id}', [CourseModeController::class, 'update'])->name('coursemodes.update');
    Route::delete('coursemodes/delete/{id}', [CourseModeController::class, 'destroy'])->name('coursemodes.delete');
    Route::get('coursemodes/status/{id}', [CourseModeController::class, 'status'])->name('coursemodes.status');

    //Languages
    Route::get('languages', [LanguageController::class, 'index'])->name('languages.index');
    Route::get('languages/create', [LanguageController::class, 'create'])->name('languages.create');
    Route::post('languages/store', [LanguageController::class, 'store'])->name('languages.store');
    Route::get('languages/edit/{id}', [LanguageController::class, 'edit'])->name('languages.edit');
    Route::post('languages/update/{id}', [LanguageController::class, 'update'])->name('languages.update');
    Route::delete('languages/delete/{id}', [LanguageController::class, 'destroy'])->name('languages.delete');
    Route::get('languages/status/{id}', [LanguageController::class, 'status'])->name('languages.status');

    // Blood Groups
    Route::get('bloodgroups', [BloodGroupController::class, 'index'])->name('bloodgroups.index');
    Route::get('bloodgroups/create', [BloodGroupController::class, 'create'])->name('bloodgroups.create');
    Route::post('bloodgroups/store', [BloodGroupController::class, 'store'])->name('bloodgroups.store');
    Route::get('bloodgroups/edit/{id}', [BloodGroupController::class, 'edit'])->name('bloodgroups.edit');
    Route::post('bloodgroups/update/{id}', [BloodGroupController::class, 'update'])->name('bloodgroups.update');
    Route::delete('bloodgroups/delete/{id}', [BloodGroupController::class, 'destroy'])->name('bloodgroups.delete');
    Route::get('bloodgroups/status/{id}', [BloodGroupController::class, 'status'])->name('bloodgroups.status');

    // Categories
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/delete/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');
    Route::get('categories/status/{id}', [CategoryController::class, 'status'])->name('categories.status');

    // Religions
    Route::get('religions', [ReligionController::class, 'index'])->name('religions.index');
    Route::get('religions/create', [ReligionController::class, 'create'])->name('religions.create');
    Route::post('religions/store', [ReligionController::class, 'store'])->name('religions.store');
    Route::get('religions/edit/{id}', [ReligionController::class, 'edit'])->name('religions.edit');
    Route::post('religions/update/{id}', [ReligionController::class, 'update'])->name('religions.update');
    Route::delete('religions/delete/{id}', [ReligionController::class, 'destroy'])->name('religions.delete');
    Route::get('religions/status/{id}', [ReligionController::class, 'status'])->name('religions.status');
});


Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
Route::get('/menu/edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
Route::post('/menu/update/{id}', [MenuController::class, 'update'])->name('menu.update');
Route::delete('/menu/destroy/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
Route::get('menu/status/{id}', [MenuController::class, 'status'])->name('menu.status');

Route::get('/theme', [ThemeController::class, 'index'])->name('theme.index');
Route::get('/theme/create', [ThemeController::class, 'create'])->name('theme.create');
Route::post('/theme/store', [ThemeController::class, 'store'])->name('theme.store');
Route::get('/theme/edit/{id}', [ThemeController::class, 'edit'])->name('theme.edit');
Route::post('/theme/update/{id}', [ThemeController::class, 'update'])->name('theme.update');
Route::delete('/theme/destroy/{id}', [ThemeController::class, 'destroy'])->name('theme.destroy');
Route::get('theme/status/{id}', [ThemeController::class, 'status'])->name('theme.status');



// Users
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users');
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');


// Roles & Permissions
Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
Route::get('/users/permissions/create', [PermissionController::class, 'create'])->name('users.permissions.create');
Route::post('/users/permissions', [PermissionController::class, 'store'])->name('users.permissions');



// Roles
Route::get('/users/roles', [RoleController::class, 'index'])->name('users.roles');
Route::get('/users/roles/create', [RoleController::class, 'create'])->name('users.roles.create');
Route::post('/users/roles', [RoleController::class, 'store'])->name('users.roles');
Route::get('/users/roles/edit/{id}', [RoleController::class, 'edit'])->name('users.roles.edit');
Route::post('/users/roles/update', [RoleController::class, 'update'])->name('users.roles.update');



Route::prefix('academics')->group(function () {
    // Universities
    Route::get('/university', [UniversityController::class, 'index'])->name('university.index');
    Route::get('/university/create', [UniversityController::class, 'create'])->name('university.create');
    Route::post('/university/store', [UniversityController::class, 'store'])->name('university.store');
    Route::get('/university/edit/{id}', [UniversityController::class, 'edit'])->name('university.edit');
    Route::post('/university/update/{id}', [UniversityController::class, 'update'])->name('university.update');
    Route::delete('/university/destroy/{id}', [UniversityController::class, 'destroy'])->name('university.destroy');
    Route::get('/university/status/{id}', [UniversityController::class, 'status'])->name('university.status');

    // Departments
    Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
    Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/department/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/department/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::post('/department/update/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::delete('/department/destroy/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');
    Route::get('/department/status/{id}', [DepartmentController::class, 'status'])->name('department.status');

    // Courses
    Route::get('/course', [CourseController::class, 'index'])->name('course.index');
    Route::get('/course/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
    Route::get('/course/edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::post('/course/update/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::delete('/course/destroy/{id}', [CourseController::class, 'destroy'])->name('course.destroy');
    Route::get('/course/status/{id}', [CourseController::class, 'status'])->name('course.status');


    // Sub Courses
    Route::get('/subcourse', [SubCourseController::class, 'index'])->name('subcourse.index');
    Route::get('/subcourse/create', [SubCourseController::class, 'create'])->name('subcourse.create');
    Route::post('/subcourse/store', [SubCourseController::class, 'store'])->name('subcourse.store');
    Route::get('/subcourse/edit/{id}', [SubCourseController::class, 'edit'])->name('subcourse.edit');
    Route::post('/subcourse/update/{id}', [SubCourseController::class, 'update'])->name('subcourse.update');
    Route::delete('/subcourse/destroy/{id}', [SubCourseController::class, 'destroy'])->name('subcourse.destroy');
    Route::get('/subcourse/status/{id}', [SubCourseController::class, 'status'])->name('subcourse.status');
    // Subjects
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects/store', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/edit/{id}', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::post('/subjects/update/{id}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/destroy/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    Route::get('/subjects/status/{id}', [SubjectController::class, 'status'])->name('subjects.status');
});



// Students CRUD routes (outside the academics group)
Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('students.index');           // List all students
    Route::get('/create', [StudentController::class, 'create'])->name('students.create');   // Show form
    Route::post('/store', [StudentController::class, 'store'])->name('students.store');     // Save new student
    Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('students.edit');    // Edit student
    Route::put('/update/{id}', [StudentController::class, 'update'])->name('students.update'); // Update
    Route::delete('/destroy/{id}', [StudentController::class, 'destroy'])->name('students.destroy'); // Delete
    Route::get('/status/{id}', [StudentController::class, 'status'])->name('students.status');     // Toggle status
    Route::get('/view/{id}', [StudentController::class, 'show'])->name('students.view');
    Route::get('/{id}/print', [StudentController::class, 'print'])->name('students.print');
    Route::get('/{id}/pdf', [StudentController::class, 'pdf'])->name('students.pdf');
    Route::get('/{id}/idcard', [StudentController::class, 'idCard'])->name('students.idcard');
    Route::get('/idcardpdf/{id}', [StudentController::class, 'generateIdCardPDF'])->name('students.idcardpdf');
});


// =========================
//  Accounts Module Routes
// =========================
Route::prefix('accounts')->group(function () {

    Route::resource('university-fee', UniversityFeesController::class);
    Route::get('/university-fee/{studentId}', [UniversityFeesController::class, 'show'])->name('university-fee.show');
    Route::post('/university-fee/update-fee/{studentId}', [UniversityFeesController::class, 'updateFee'])->name('university-fee.updateFee');
    Route::get('/university-payments', [UniversityFeesController::class, 'UnversityFeeTransactionHistory'])
        ->name('university-payments.index');
    // Student Fee Management
    Route::get('/fees', [StudentFeeStructureController::class, 'index'])->name('fees.index');
    Route::get('/fees/create', [StudentFeeStructureController::class, 'create'])->name('fees.create');
    Route::post('/fees/store', [StudentFeeStructureController::class, 'store'])->name('fees.store');
    Route::get('/fees/edit/{id}', [StudentFeeStructureController::class, 'edit'])->name('fees.edit');
    Route::post('/fees/update/{id}', [StudentFeeStructureController::class, 'update'])->name('fees.update');
    Route::delete('/fees/destroy/{id}', [StudentFeeStructureController::class, 'destroy'])->name('fees.destroy');


    Route::get('/student-fee-info/{id}', [StudentFeeStructureController::class, 'getStudentFeeInfo'])->name('fees.info');

    // Additional routes for invoices and payments can be added here

    Route::get('/studentindex', [StudentFeeStructureController::class, 'studentindex'])->name('fees.studentindex');
    Route::get('/fees/add', [StudentFeeStructureController::class, 'add'])->name('fees.add');
    Route::get('/ledger/{studentId}', [StudentLedgerController::class, 'ledger'])
        ->name('accounts.ledger');

    Route::post('/student/save-payment', [StudentLedgerController::class, 'savePayment'])
        ->name('student.savePayment');

    Route::get('/students/{studentId}/payment-modal', [StudentLedgerController::class, 'loadPaymentModal'])
        ->name('student.paymentModal');

    Route::post('/students/fee/confirm', [StudentLedgerController::class, 'confirmFeeStructure'])
        ->name('student.fee.confirm');


    Route::get('/student/{id}/semester-balance', [StudentLedgerController::class, 'getSemesterBalance'])
        ->name('student.semester.balance');

    Route::get('/student/payment/{id}/edit', [StudentLedgerController::class, 'editPayment'])->name('student.editPayment');
    Route::get('/student/payment/{id}/receipt', [StudentLedgerController::class, 'downloadReceipt'])->name('student.downloadReceipt');
    Route::post('/student/payment/{id}/updatePayment', [StudentLedgerController::class, 'updatePayment'])
        ->name('student.updatePayment');

    Route::get('miscellaneous/{student_id}',[MiscellaneousFeeController::class,'create'])->name('accounts.miscellaneous');
    Route::post('miscellaneous/store',[MiscellaneousFeeController::class,'store'])->name('accounts.saveMiscellaneous');
    Route::post('miscellaneous/update',[MiscellaneousFeeController::class,'update'])->name('accounts.updateMiscellaneous');
    Route::get('miscellaneous/edit/{student_id}',[MiscellaneousFeeController::class,'edit'])->name('accounts.editMiscellaneousFee');
});


Route::prefix('reports')->name('reports.')->group(function(){
    Route::get('students',[ReportController::class,'studentReport'])->name('students');
    Route::get('students/create',[ReportController::class,'createStudentReport'])->name('students.create');
    Route::post('students/store',[ReportController::class,'storeStudentReport'])->name('students.store');
    Route::get('student/{id}',[ReportController::class,'viewStudentReport'])->name('students.view');
    Route::get('income',[ReportController::class,'incomeReport'])->name('income');
    Route::get('expence',[ReportController::class,'expenceReport'])->name('expence');
    Route::post('getExpense', [ReportController::class, 'getExpense'])->name('getExpense');
    Route::get('getIncome',[ReportController::class,'getIncome'])->name('getIncome');

    Route::get('pendingfees', [ReportController::class, 'PendingReport'])->name('pendingfees');

    Route::post('getpendingFees', [ReportController::class, 'pendingFeesReport'])->name('getpendingFees');
});

Route::get('getCourseByUniversityAndCourseType', [CourseController::class, 'getCourseByUniversityAndCourseType'])->name('getCourseByUniversityAndCourseType');
Route::get('getSubCourseByCourseId', [SubCourseController::class, 'getSubCourseByCourseId'])->name('getSubCourseByCourseId');
