<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Rules\JabuEmailRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
       

        // $users = User::whereHas('roles', function($q) {
        //     $q->where('name', '!=', 'admin');
        // })->get();

        return Inertia::render('Admin/Lecturer/NewStaff', ['staffs' => $users]);
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
            'title' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'othername' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new JabuEmailRule()],
            'password' => ['required', 'confirmed', 'string', 'min:8'],
        ]);

        $hodstaff = null;

        if($request->input('hod') == 1){
            $hodstaff = Role::where('name', 'lecturer')->first();
        }

        if($request->input('hod') == 2){
            $hodstaff = Role::where('name', 'hod')->first();
        }

        $newuser = User::create([
            'staffid' => $request->input('staffid'),
            'title' => $request->input('title'),            
            'name' => $request->input('name'),
            'othername' => $request->input('othername'),
            'is_admin' => 0,
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $newuser->roles()->attach($hodstaff);

        return redirect(route('admin.staffs.index'))->withSuccess('New Staff Created successfully!');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sethod(Request $request, $id)
    {
        $hodRole = Role::where('name', 'hod')->first();

        $staff = User::find($id);

        $staff->roles()->attach($hodRole);
        return redirect(route('admin.staffs.index'))->withSuccess('Staff Updated successfully!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function removehod(Request $request, $id)
    {
        $hodRole = Role::where('name', 'hod')->first();

        $staff = User::find($id);

        $staff->roles()->detach($hodRole);
        return redirect(route('admin.staffs.index'))->withSuccess('Staff Updated successfully!');
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
    public function edit($id)
    {
        $user = User::find($id);
        return Inertia::render('Admin/Lecturer/EditStaff', ['staff' => $user]);
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
        dd($request);
        
        // $request->validate([
        //     'staffid' => 'required',
        //     'title' => 'required',
        //     'name' => 'required',
        //     'othername' => 'required',
        //     'email' => 'required',
        //     'department' => 'required|numeric|min:1',
        // ]);

        
        // User::find($id)->update([
        //     'staffid' => $request->input('staffid'),            
        //     'title' => $request->input('title'),            
        //     'name' => $request->input('name'),            
        //     'othername' => $request->input('othername'),            
        //     'email' => $request->input('email'),            
        //     'department_id' => $request->input('department'),
        // ]);

        return redirect(route('admin.staffs.index'))->withSuccess('Staff Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect(route('admin.staffs.index'))->withSuccess('Staff Updated successfully!');
    }
}
