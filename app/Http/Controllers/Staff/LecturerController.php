<?php

namespace App\Http\Controllers\Staff;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lecturers = User::where('department_id', Auth::user()->department->id)->get();

        return Inertia::render('Lecturer/LecturerView', ['thelecturers' => $lecturers]);
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
            'staffid' => ['required', 'string', 'max:255', 'unique:users'],
            'title' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'othername' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'department' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $theRole = Role::where('name', 'lecturer')->first();

        $newstaff = User::create([
            'staffid' => $request->input('staffid'),
            'title' => $request->input('title'),
            'name' => $request->input('name'),
            'othername' => $request->input('othername'),
            'email' => $request->input('email'),
            'remember_token' => Str::random(10),
            'department_id' => $request->input('department'),
            'password' => Hash::make($request->input('password')),
        ]);

        $newstaff->roles()->attach($theRole);

        return redirect(route('staff.newlecturer'))->withSuccess('New Lecturer Registered Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return Inertia::render('Lecturer/EditLecturer', ['thelecturers' => $user]);
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
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'staffid' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'othername' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        
        User::find($id)->update([
            'staffid' => $request->input('staffid'),
            'title' => $request->input('title'),
            'name' => $request->input('name'),
            'othername' => $request->input('othername'),
            'email' => $request->input('email'),
        ]);

        return redirect(route('staff.newlecturer'))->withSuccess('Lecturer Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
    }
}
