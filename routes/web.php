<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', [App\Http\Controllers\GeneralController::class, 'checkLogin']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\GeneralController::class, 'showDashboard'])->name('dashboard');
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
});

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    $limiter = config('fortify.limiters.login');
  
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:'.config('fortify.guard'),
            $limiter ? 'throttle:'.$limiter : null,
        ]));
});

Route::get('/test', [App\Http\Controllers\TestController::class, 'index'])->name('test');
Route::get('/test2', [App\Http\Controllers\TestController::class, 'index2'])->name('test2');

Route::get('get_all_session', [App\Http\Controllers\GeneralController::class, 'getSession']);
Route::get('get_all_college', [App\Http\Controllers\GeneralController::class, 'getCollege']);
Route::get('get_dept', [App\Http\Controllers\GeneralController::class, 'getDepartment']);
Route::get('getstaffdata', [App\Http\Controllers\GeneralController::class, 'getStaff']);


Route::get('/student/attendance', [App\Http\Controllers\GeneralController::class, 'getAttendance']);


Route::group(['middleware' => 'auth:sanctum', 'verified', 'checkStatus'], function(){

    Route::group(['prefix' => 'admin', 'middleware' => 'is_admin', 'as' => 'admin.'], function(){ 
        Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');

        Route::resource('roles', App\Http\Controllers\Admin\RoleController::class)->except([
            'create', 'destroy'
        ]);

        Route::patch('/admin/staffs/removehod/{staff}', [App\Http\Controllers\Admin\StaffController::class, 'removehod'])->name('staffs.removeHOD');
        Route::patch('/admin/staffs/sethod/{staff}', [App\Http\Controllers\Admin\StaffController::class, 'sethod'])->name('staffs.setHOD');
        Route::resource('staffs', App\Http\Controllers\Admin\StaffController::class)->except([
            'create'
        ]);
        
        Route::post('/students/upload', [App\Http\Controllers\Admin\StudentController::class, 'uploadStudent'])->name('students.upload');
        Route::get('/students/updatelevel', [App\Http\Controllers\Admin\StudentController::class, 'updateStudent'])->name('students.updatelevel');
        Route::post('/students/updatelevel', [App\Http\Controllers\Admin\StudentController::class, 'getStudentLevel'])->name('students.getStudentLevel');
        Route::patch('/students/updatelevel/store', [App\Http\Controllers\Admin\StudentController::class, 'updateStudentList'])->name('students.updateStudent.store');
        Route::resource('students', App\Http\Controllers\Admin\StudentController::class)->except([
            'destroy'
        ]);

        Route::post('/acadsession/closecurrent/{acadsession}', [App\Http\Controllers\Admin\AcadsessionController::class, 'closecurrent'])->name('acadsession.closecurrent');
        Route::post('/acadsession/setcurrent/{acadsession}', [App\Http\Controllers\Admin\AcadsessionController::class, 'setcurrent'])->name('acadsession.setcurrent');
        
        Route::resource('acadsession', App\Http\Controllers\Admin\AcadsessionController::class)->except([
            'destroy'
        ]);

        Route::resource('college', App\Http\Controllers\Admin\CollegeController::class)->except([
            'create'
        ]);

        // Route::get('/newcollege', [App\Http\Controllers\Admin\CollegeController::class, 'index'])->name('newcollege');
        // Route::post('/newcollege', [App\Http\Controllers\Admin\CollegeController::class, 'store'])->name('storecollege');
        // Route::get('/college/{college}', [App\Http\Controllers\Admin\CollegeController::class, 'show'])->name('college.show');
        // Route::patch('/college/{college}', [App\Http\Controllers\Admin\CollegeController::class, 'update'])->name('college.update');
        // Route::delete('/college/{college}', [App\Http\Controllers\Admin\CollegeController::class, 'destroy'])->name('college.destroy');

        // //Department
        // Route::get('/newdepartment', [App\Http\Controllers\Admin\DepartmentController::class, 'index'])->name('newdepartment');
        // Route::post('/newdepartment', [App\Http\Controllers\Admin\DepartmentController::class, 'store'])->name('storedepartment');
        // Route::get('/department/{department}', [App\Http\Controllers\Admin\DepartmentController::class, 'show'])->name('department.show');
        // Route::patch('/department/{department}', [App\Http\Controllers\Admin\DepartmentController::class, 'update'])->name('department.update');
        // Route::delete('/department/{department}', [App\Http\Controllers\Admin\DepartmentController::class, 'destroy'])->name('department.destroy');

        // Attendance
        Route::get('/attendance', [App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('attendance.index');
        

    });

    Route::group(['prefix' => 'staff',  'as' => 'staff.'], function(){ 
        Route::get('/dashboard', [App\Http\Controllers\Staff\StaffController::class, 'index'])->name('dashboard');

       Route::get('/student/newstudent', [App\Http\Controllers\Staff\StudentController::class, 'index'])->name('newstudent');
       Route::get('/student/uploadstudent', [App\Http\Controllers\Staff\StudentController::class, 'studentUpload'])->name('uploadstudent');
       Route::post('/student/uploadstudent', [App\Http\Controllers\Staff\StudentController::class, 'store'])->name('uploadallstudent');
       Route::get('/student/searchstudent', [App\Http\Controllers\Staff\StudentController::class, 'searchstudent'])->name('searchstudent');
       Route::post('/student/searchstudent', [App\Http\Controllers\Staff\StudentController::class, 'searchstudent2'])->name('searchstudent2');


       //Courses
       Route::get('/lecturer/newcourse', [App\Http\Controllers\Staff\CourseController::class, 'index'])->name('newcourse');
       Route::post('/lecturer/newcourse', [App\Http\Controllers\Staff\CourseController::class, 'store'])->name('newcourse.store');
       Route::get('/lecturer/showcourse/{course}', [App\Http\Controllers\Staff\CourseController::class, 'show'])->name('course.show');
       Route::patch('/lecturer/showcourse/{course}', [App\Http\Controllers\Staff\CourseController::class, 'update'])->name('course.update');
       Route::delete('/lecturer/showcourse/{course}/delete', [App\Http\Controllers\Staff\CourseController::class, 'destroy'])->name('course.delete');

       //HOD Courses Allocation
       Route::get('/course/allocate', [App\Http\Controllers\Staff\CourseController::class, 'allocate'])->name('course.allocate');
       Route::post('/course/allocate', [App\Http\Controllers\Staff\CourseController::class, 'processAllocate'])->name('course.allocate.store');
       Route::get('/course/allocate/{lecturer}', [App\Http\Controllers\Staff\CourseController::class, 'resetAllocate'])->name('course.allocate.reset');

       //HOD Class Controller
       Route::get('/class/index', [App\Http\Controllers\Hod\ClassControler::class, 'index'])->name('hod.viewclass');


       //Students
       Route::get('/students/updatelevel', [App\Http\Controllers\Admin\StudentController::class, 'updateStudent'])->name('students.updatelevel');


       //Lecturer
       Route::get('/lecturer/lecturer', [App\Http\Controllers\Staff\LecturerController::class, 'index'])->name('newlecturer');
       Route::post('/lecturer/lecturer', [App\Http\Controllers\Staff\LecturerController::class, 'store'])->name('register');
       Route::get('/lecturer/lecturer/{lecturer}', [App\Http\Controllers\Staff\LecturerController::class, 'show'])->name('lecturer.show');
       Route::patch('/lecturer/showlecturer/{lecturer}', [App\Http\Controllers\Staff\LecturerController::class, 'update'])->name('lecturer.update');
       Route::delete('/lecturer/showlecturer/{lecturer}/delete', [App\Http\Controllers\Staff\LecturerController::class, 'destroy'])->name('lecturer.delete');
 
       //Lectures
       Route::get('/lecturer/newlecture', [App\Http\Controllers\Staff\LectureController::class, 'index'])->name('newlecture');
       Route::post('/lecturer/newlecture', [App\Http\Controllers\Staff\LectureController::class, 'store'])->name('newlecture.store');
       Route::get('/lecturer/lectureclass/{lecture}', [App\Http\Controllers\Staff\LectureController::class, 'edit'])->name('newlecture.show');
       Route::patch('/lecturer/lectureclass/{lecture}', [App\Http\Controllers\Staff\LectureController::class, 'update'])->name('newlecture.update');
       Route::get('/lecturer/attendance/allocatestudent', [App\Http\Controllers\Staff\LectureController::class, 'allocatePage'])->name('allocatestudent');
       Route::post('/lecturer/attendance/allocatestudent', [App\Http\Controllers\Staff\LectureController::class, 'getavailableStudent'])->name('allocatestudent.get');

       Route::post('/lecturer/attendance/saveallocatestudent', [App\Http\Controllers\Staff\LectureController::class, 'searchStd'])->name('allocatestudent.searchStd');
       Route::post('/lecturer/attendance/allocate', [App\Http\Controllers\Staff\LectureController::class, 'allocateStd'])->name('allocatestudent.allocateStd');
        
       Route::get('/lecturer/attendance/viewlecture', [App\Http\Controllers\Staff\LectureController::class, 'viewlecture'])->name('viewlecture');
       Route::post('/lecturer/attendance/lecture/{lecture}', [App\Http\Controllers\Staff\LectureController::class, 'show'])->name('viewlecture.loadstudent');
       
       //Attendance
       Route::get('/lecturer/attendance/loadattendance', [App\Http\Controllers\Staff\AttendanceController::class, 'index'])->name('loadattendance');
       Route::post('/lecturer/attendance/loadattendance', [App\Http\Controllers\Staff\AttendanceController::class, 'loadstudent'])->name('loadattendance.loadstudent');

       Route::post('/lecturer/attendance/markattendance', [App\Http\Controllers\Staff\AttendanceController::class, 'markattendance'])->name('student.markattendance');

       Route::get('/lecturer/attendance/viewattendance', [App\Http\Controllers\Staff\AttendanceController::class, 'viewattendance'])->name('viewattendance');
       Route::post('/lecturer/attendance/viewattendance', [App\Http\Controllers\Staff\AttendanceController::class, 'viewattendancetable'])->name('viewattendance.table');
       Route::get('/lecturer/attendance/viewallattendance', [App\Http\Controllers\Staff\AttendanceController::class, 'viewallattendance'])->name('viewallattendance');


       Route::get('/attendancepdf', [App\Http\Controllers\Staff\AttendanceController::class, 'attendancepdf']);
       Route::post('/lecturer/attendance/exportatendance', [App\Http\Controllers\Staff\AttendanceController::class, 'exportatendance'])->name('attendance.export');
    });

    // Route::group(['prefix' => 'hod', 'as' => 'hod.'], function(){
    //     Route::get('/dashboard', [App\Http\Controllers\Hod\HodController::class, 'index'])->name('dashboard');
    // });

   

    // Route::group(['prefix' => 'student', 'as' => 'student.'], function(){ 

    // });

});