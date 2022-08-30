<?php

namespace App\Http\Controllers\Staff;

use Inertia\Inertia;
use App\Models\Student;
use App\Models\Department;
use App\Models\Acadsession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentsession = Acadsession::where('current', 1)->first();
        $csessionexist = Acadsession::where('current', 1)->exists();
        

        $thedept = Department::all();

        return Inertia::render('Lecturer/Student/NewStudent', ['thedept' => $thedept, 'currentsession' => $currentsession,
            'csessionexist' => $csessionexist]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchstudent()
    {
        $acadsession = Acadsession::all();

        return Inertia::render('Lecturer/Student/SearchStudent', ['acadsessions' => $acadsession, 'students' => null,]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentUpload()
    {
        return Inertia::render('Lecturer/Student/UploadStudent');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchstudent2(Request $request)
    {
        $acadsession = Acadsession::all();

        $students = Student::where('stdlevel', $request->input('level'))
            ->where('department_id', $request->input('department'))
            ->where('acadsession_id', $request->input('acadsession'))->get();

        return Inertia::render('Lecturer/Student/SearchStudent', ['acadsessions' => $acadsession, 'students' => $students,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'stdrecord' => ['required', 'mimes:csv,xlsx'],
        // ]);

        Excel::import(new StudentsImport(), $request->input('stdrecord'));     
 
        dd($request->input('stdrecord'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
