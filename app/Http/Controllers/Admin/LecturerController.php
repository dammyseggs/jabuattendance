<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Department;
use App\Rules\JabuEmailRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $dept = Department::all();
        return Inertia::render('Admin/Lecturer/NewStaff', ['thedept'=> $dept]);
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
        // $request->validate([
        //     'staffid' => ['required', 'string', 'max:255', 'unique:users'],
        //     'title' => ['required', 'string', 'max:20'],
        //     'name' => ['required', 'string', 'max:255'],
        //     'othername' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users', new JabuEmailRule()],
        //     'password' => ['required', 'confirmed', 'string', 'min:8'],
        // ]);

        // $newuser = User::create([
        //     'staffid' => $request->input('staffid'),
        //     'title' => $request->input('title'),            
        //     'name' => $request->input('name'),
        //     'othername' => $request->input('othername'),
        //     'is_admin' => 0,
        //     'email' => $request->input('email'),
        //     'password' => Hash::make($request->input('password')),
        // ]);

        dd($request);

        return redirect(route('admin.staff.newstaff'))->withSuccess('Staff Record created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
