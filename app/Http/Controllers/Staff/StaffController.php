<?php

namespace App\Http\Controllers\Staff;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Acadsession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StaffController extends Controller
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
       
        $userdept_id = Auth::user()->department->id;


        $yourcourses = 0;
        $yourclasses = 0;
        $lecturecount = 0;

        if ($currentexists) {
            $yourcourses = auth()->user()->courses->count();
            $yourclasses = auth()->user()->lectures->count();
            $lecturecount = Lecture::where('department_id', $userdept_id)
               ->where('acadsession_id', $currentses->id)->count();
        }else{
            $yourcourses = 0;
            $yourclasses = 0;
            $lecturecount = 0;
        }

        $deptcoursecount = Course::where('department_id', $userdept_id)->count();
        $stafcount = User::where('department_id', $userdept_id)->count();

        
        return Inertia::render('Lecturer/Dashboard', ['currentses' => $currentses, 'yourcourses' => $yourcourses, 
            'yourclasses' => $yourclasses, 'deptcoursecount' => $deptcoursecount, 'stafcount' => $stafcount, 
            'lecturecount' => $lecturecount,]);
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
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
