<?php

namespace App\Http\Controllers\Staff;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {     
        $deptcourses = Course::where('department_id', Auth::user()->department->id)->get();
        
        return Inertia::render('Lecturer/Course', ['deptcourses'=> $deptcourses,]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allocate()
    {     
        $allstaff = User::where('department_id', Auth::user()->department->id)->get();
        $allcourses = Course::where('department_id', Auth::user()->department->id)->orderBy('courselevel', 'ASC')->get();

        // dd($allcourses);
        
        return Inertia::render('Courses/AllocateCourse', ['allstaff'=> $allstaff, 'allcourses'=> $allcourses,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processAllocate(Request $request)
    {  
        $request->validate([
            'lecturer' => ['required'],
            'courses' => ['required', 'array', 'distinct', 'min:1'],
        ]);

        $lecturer = User::find($request->input('lecturer'));
        $thecourses = $request->input('courses');
        $thecourse = '';

        // dd($thecourses);

        for ($i = 0; $i < count($request->input('courses')); $i++){            
            $thecourse = Course::find($thecourses[$i]);

            if($lecturer->courses->contains($thecourse)){
                continue;
            }
         
            $lecturer->courses()->attach($thecourse);
        }

        return redirect()->back()->with('success', 'Course(s)  Allocated Successfully !'); 
     }


     /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetAllocate($id)
    {
        $lecturer = User::find($id);

        foreach ($lecturer->courses as $lcourse){
            $lecturer->courses()->detach($lcourse);
        }

        return redirect()->back()->with('success', 'Course(s) Deallocated Successfully !'); 
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
            'coursename' => ['required', 'string', 'max:255', 'unique:courses'],
            'coursecode' => ['required', 'string', 'max:255', 'unique:courses'],
            'courselevel' => ['required', 'string', 'max:255'],
        ]);
       
        $newcorse = Course::create([
            'coursename' => $request->input('coursename'),
            'coursecode' => $request->input('coursecode'),
            'courselevel' => $request->input('courselevel'),
            'department_id' => $request->input('department'),
            'description' => $request->input('description'),
        ]);

        // auth()->user()->courses()->attach($newcorse);

        //$newuser->roles()->attach($theRole);

        return redirect(route('staff.newcourse'))->withSuccess('New Course Added successfully!');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return Inertia::render('Courses/EditCourse', ['thecourses' => $course]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'coursename' => ['required', 'string', 'max:255'],
            'coursecode' => ['required', 'string', 'max:255'],
            'courselevel' => ['required', 'string', 'max:255'],
        ]);     
        
        $course->update([
            'coursename' => $request->input('coursename'),
            'coursecode' => $request->input('coursecode'),
            'courselevel' => $request->input('courselevel'),
            'description' => $request->input('description'),
        ]);

        return redirect(route('staff.newcourse'))->withSuccess('Course Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect(route('staff.newcourse'))->withSuccess('Course Updated successfully!');
    }
}
