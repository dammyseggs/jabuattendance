<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Student;
use App\Models\Department;
use App\Models\Acadsession;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use App\Imports\StudentsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

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
        $dept = Department::all();               
        return Inertia::render('Student/NewStudent', ['thedept'=> $dept, 'currentsession'=> $currentsession,]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        return Inertia::render('Student/UploadStudent');
    }
       

    /**
     * Display a listing of the resource.  
     *
     * @return \Illuminate\Http\Response    
     */
    public function updateStudent()
    {
        $acadsessions = Acadsession::all();
        return Inertia::render('Student/UpdateStudent', ['acadsessions'=> $acadsessions, 'studentsavailable'=> false,  'allstudents'=> null, ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Student/UploadStudent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getStudentLevel(Request $request)
    {               
        $request->validate([
            'stdlevel' => ['required', 'string', 'max:255'],
            'csession' => ['required'],
            'college' => ['required'],
            'department' => ['required'],
        ]);

        $std = Student::where('acadsession_id', $request->input('csession'))
            ->where('department_id', $request->input('department'))
            ->where('stdlevel', $request->input('stdlevel'))->get();

        $acadsessions = Acadsession::all();

        if ($std->isEmpty()) {
            return Inertia::render('Student/UpdateStudent', ['acadsessions'=> $acadsessions, 'studentsavailable'=> false,  'allstudents'=> $std, ]);
        }else {
            return Inertia::render('Student/UpdateStudent', ['acadsessions'=> $acadsessions, 'studentsavailable'=> true,  'allstudents'=> $std, ]);
        }        
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStudentList(Request $request)
    {  
        $stdids = $request->input('captureStudent');

        if (count($request->input('captureStudent')) >= 1) {
            for ($i=0; $i < count($stdids); $i++) { 
                $std = Student::find($stdids[$i]);
                $std->update(['stdlevel' == $this->changeLevel($std->stdlevel)]);
                // $std->update(['stdlevel' == '200']);
            }
            return Redirect::back()->withSuccess('Students Level Updated successfully!');
        }else{
            return Redirect::back()->withSuccess('No Students to Updated!');
        }


        // return redirect()->back()->with('success', 'your message,here');   
        // dd(gettype($request->input('captureStudent')));
        // dd($request);
        //dd(request()->isMethod(''));
    }

    




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $request->validate([
            'matric_no' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'othername' => ['required', 'string', 'max:255'],
            'stdlevel' => ['required', 'string', 'max:255'],
            //'department' => ['required'],
        ]);

        $currentsession = Acadsession::where('current', 1)->first();

        if (Student::where('matric_no', $request->input('matric_no'))->exists()) {
             $std = Student::where('matric_no', $request->input('matric_no'))->get();

                Student::where('matric_no', $request->input('matric_no'))
                ->update([
                    'matric_no' => $request->input('matric_no'),
                    'name' => $request->input('name'),
                    'othername' => $request->input('othername'),
                    'stdlevel' => $request->input('stdlevel'),
                    'department_id' => $request->input('department'),
                    'acadsession_id' => $currentsession->id,
                ]);

             if ($request->input('from') == 'admin') {
                return redirect(route('admin.students.index'))->withSuccess('New Student Updated successfully!');
             }else {
                return redirect(route('staff.newstudent'))->withSuccess('New Student Updated successfully!');
             }
        }

        $newstd = Student::firstOrCreate([
            'matric_no' => $request->input('matric_no'),
            'name' => $request->input('name'),
            'othername' => $request->input('othername'),
            'stdlevel' => $request->input('stdlevel'),
            'department_id' => $request->input('department'),
            'acadsession_id' => $currentsession->id,
        ]);

        if ($request->input('from') == 'admin') {
            return redirect(route('admin.students.index'))->withSuccess('New Student Added successfully!');
        }else {
            return redirect(route('staff.newstudent'))->withSuccess('New Student Added successfully!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadStudent(Request $request)
    {       
        $input = Input::file('stdrecord');
        $file = $request->file('stdrecord');

        dd( $input);


        // $path = $request->file($request->all())->getRealPath();
        // dd($path);
        //  Excel::import(new StudentImport, 'users.xlsx');
        // $file = $request->input('stdrecord');

        // (new StudentsImport)->import($file);
        // return back()->withStatus('Students Records Imported Successfully !');
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


    public function changeLevel($level){
        if ($level == '100') {
            return '200';
        }elseif ($level == '200') {
            return '300';
        }elseif ($level == '300') {
            return '400';
        }elseif ($level == '400') {
            return '500';
        }else{
            return '600';
        }
    }
}
