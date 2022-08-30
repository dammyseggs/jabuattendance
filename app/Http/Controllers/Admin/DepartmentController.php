<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colls = College::all();
        $alldept = Department::all();
        return Inertia::render('Admin/College/Department', ['thecoll'=> $colls, 'thedept'=> $alldept,]);
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
            'name' => ['required', 'string', 'max:255', 'unique:departments'],
        ]);
       
        $newstd = Department::create([
            'name' => $request->input('name'),
            'college_id' => $request->input('college_id'),
        ]);

        return redirect(route('admin.newdepartment'))->withSuccess('New Department Added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $colls = College::all();
        
        return Inertia::render('Admin/College/EditDepartment', ['thecoll'=> $colls, 'thedepartment' => $department]);    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $department->update([
            'name' => $request->input('name'),            
        ]);

        return redirect(route('admin.newdepartment'))->withSuccess('Department Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        dd('Delete his here');
        $department->delete();
        return redirect(route('admin.newdepartment'))->withSuccess('Department Record Deleted!');
    }
}
