<?php

namespace App\Http\Controllers\Staff;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\College;
use App\Models\Lecture;
use App\Models\Student;
use App\Models\Department;
use App\Models\Acadsession;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentexists = Acadsession::where('current', 1)->exists();
        $currentses = Acadsession::where('current', 1)->first();

        $cour = auth()->user()->courses()->get();
        $courexist = auth()->user()->courses()->count() > 0 ? true: false;

        $yourlectures = auth()->user()->lectures()->get();
        $lectexist = auth()->user()->courses()->count() > 0 ? true: false;

        $thelectures = collect();

        if($currentexists){
            foreach ($yourlectures as $yourlecture) {
                if ($yourlecture->acadsession_id == $currentses->id) {
                    $thelectures->add($yourlecture);
                }
            }
        }

        if ($thelectures) {
            $lectexist = true;
        }else{
            $lectexist = false;
        } 
        
        return Inertia::render('Lecturer/Lecture', ['yourcourses'=> $cour, 'courexist'=> $courexist, 'yourlectures'=> $yourlectures, 
        'lectexist'=> $lectexist, 'currentexists'=> $currentexists, 'currentses'=> $currentses,]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allocatePage()
    {
        // dd('sdasfasfasfasfasfasfaf');
       
        $csession = Acadsession::where('current', 1)->exists();

       $lectu = auth()->user()->lectures()->get();
       $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

    //    dd(User::find(4)->lectures()->get());

       $searchStd = Student::all();
       $stdexist = false;

       return Inertia::render('Lecturer/Attendance/AllocateStudent', 
        ['csession'=> $csession, 'stdexist'=> $stdexist, 
        'availableStd'=> $searchStd, 'lectuexist'=> $lectuexist, 'lectu'=> $lectu,]);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getavailableStudent(Request $request)
    {
        $csession = Acadsession::where('current', 1)->exists();
        $current = Acadsession::where('current', 1)->first();
        $lectu = auth()->user()->lectures()->get();
        $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

        $stdexist = false;
       
        $searchStd = Lecture::find($request->input('thelectu'))->students;

        if ($searchStd->count() > 0) {
            $stdexist = true;
        }
               
        return Inertia::render('Lecturer/Attendance/AllocateStudent', 
          ['csession'=> $csession, 'stdexist'=> $stdexist, 'availableStd'=> $searchStd, 
          'lectuexist'=> $lectuexist, 'lectu'=> $lectu,]);
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
    public function store(Request $request)
    {   
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:lectures'],
            'course' => ['required'],
        ]);

        $currentses = Acadsession::where('current', 1)->first();

        $course = Course::find($request->input('course'));
     
        $newlect = Lecture::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-'),
            'course_id' => $request->input('course'),
            'acadsession_id' => $currentses->id,
            'department_id' => $course->department_id,
            'addinfo' => $request->input('addinfo'),
        ]);

        foreach ($course->users as $staff) {
            $staff->lectures()->attach($newlect);
        }


        // auth()->user()->lectures()->attach($newlect);

        return redirect(route('staff.newlecture'))->withSuccess('New Class Created successfully!');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchStd(Request $request)
    {         
        $csession = Acadsession::where('current', 1)->exists();
        $current = Acadsession::where('current', 1)->first();
        $lectu = auth()->user()->lectures()->get();
        $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

        $searchStd = Student::where('stdlevel', '=', $request->input('stdlevel'))
                    ->where('department_id', '=', $request->input('department'))
                    ->where('acadsession_id', '=', $current->id)
                    ->get();


        $stdexist = Student::where('stdlevel', '=', $request->input('stdlevel'))
                    ->where('department_id', '=', $request->input('department'))
                    ->where('acadsession_id', '=', $current->id)
                    ->count() > 0 ? true : false;

        
        return Inertia::render('Lecturer/Attendance/AllocateStudent', 
          ['csession'=> $csession, 'stdexist'=> $stdexist, 'availableStd'=> $searchStd, 
          'lectuexist'=> $lectuexist, 'lectu'=> $lectu,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function allocateStd(Request $request)
    { 
        
        $request->validate([
            'thelectu' => ['required', 'numeric', 'min:1'],
            'captureStudent' => ['required', 'array', 'min:1'],
        ]);

        $lecture = Lecture::find($request->input('thelectu')); 

        $allstd = $lecture->students;

        foreach($request->input('captureStudent') as $theid){
            $student = Student::find($theid);

            if(!$allstd->contains($student)){
                $student->lectures()->attach($lecture);
            }
        }

        return redirect(route('staff.allocatestudent'))->withSuccess('Students Allocated Successfully!');
        
     }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewlecture()
    {
        $lectu = auth()->user()->lectures()->get();
        $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

        $student = null;
        $stdexist= false;
        
        return Inertia::render('Lecturer/Attendance/ViewLectureClass', 
          ['lectu'=> $lectu, 'lectuexist'=> $lectuexist, 'stdexist'=> $stdexist, 'students'=> $student,]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function show(Lecture $lecture)
    {
        $lectu = auth()->user()->lectures()->get();
        $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

        $stdexist = $lecture->students->count() > 0 ? true: false;
        
        return Inertia::render('Lecturer/Attendance/ViewLectureClass', 
          ['lectu'=> $lectu, 'lectuexist'=> $lectuexist, 'stdexist'=> $stdexist, 'students'=> $lecture->students,]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function edit(Lecture $lecture)
    {
        $cour = auth()->user()->courses()->get();

        return Inertia::render('Lecturer/Attendance/EditClass', ['lectureclass'=> $lecture, 'yourcourses'=> $cour,]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lecture $lecture)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'course' => ['required'],
        ]);     
        
        $lecture->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-'),
            'course_id' => $request->input('course'),
            'addinfo' => $request->input('addinfo'),
        ]);

        return redirect(route('staff.newlecture'))->withSuccess('Class Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lecture  $lecture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lecture $lecture)
    {
        //
    }
}
