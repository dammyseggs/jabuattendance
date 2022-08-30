<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

 class CollegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colls = College::all();
        return Inertia::render('Admin/College/College', ['thecoll'=> $colls]);
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
            'name' => ['required', 'string', 'max:255', 'unique:colleges'],
        ]);
        
        $newstd = College::create([
            'name' => $request->input('name'),
        ]);

        return redirect(route('admin.newcollege'))->withSuccess('New College Added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function show(College $college)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function edit(College $college)
    {
        $colls = College::all();
        $department = Department::all();
        
        return Inertia::render('Admin/College/EditCollege', ['thecoll'=> $colls, 'thedepartment' => $department]);    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, College $college)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\College  $college
     * @return \Illuminate\Http\Response
     */
    public function destroy(College $college)
    {
        //
    }
}
