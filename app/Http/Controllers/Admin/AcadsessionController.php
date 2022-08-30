<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Acadsession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AcadsessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $acadsession = Acadsession::all();              
        return Inertia::render('Admin/Acadsession/Acadsession', ['acadsession'=> $acadsession,]);
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
    public function closecurrent(Request $request, Acadsession $acadsession)
    {
        $acadsession->current = 0;
        $acadsession->save();    
        return Redirect::back()->withSuccess('Academic Session clossed!');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setcurrent(Request $request, Acadsession $acadsession)
    {
        if (Acadsession::where('current', 1)->exists()) {
            return Redirect::back()->withErrors('One Current Academic Session exist!. You need to close it first');
        }

        $acadsession->current = 1;
        $acadsession->save();    
        return Redirect::back()->withSuccess('Academic Session has been set to Current!');
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
            'name' => ['required', 'string', 'max:255', 'unique:acadsessions'],
        ]);

       if ( Acadsession::where('current', 1)->count() > 0) {
            return redirect(route('admin.acadsession.index'))->withErrors('You have unclosed Scademic Session!!!');
       }

        DB::table('acadsessions')->update(['current' => 0]);
        
        $acasess = Acadsession::create([
            'name' => $request->input('name'),
            'current' => $request->input('current'),
        ]);

        return redirect(route('admin.acadsession.index'))->withSuccess('New Academic Session Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Acadsession  $acadsession
     * @return \Illuminate\Http\Response
     */
    public function show(Acadsession $acadsession)
    {
        return Inertia::render('Admin/Acadsession/EditAcadsession', ['acadsession'=> $acadsession,]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Acadsession  $acadsession
     * @return \Illuminate\Http\Response
     */
    public function edit(Acadsession $acadsession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Acadsession  $acadsession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acadsession $acadsession)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:acadsessions'],
        ]);

        $acadsession->update([
            'name' => $request->input('name'),            
        ]);

        return redirect(route('admin.acadsession.index'))->withSuccess('Academic Session Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Acadsession  $acadsession
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acadsession $acadsession)
    {
        //
    }
}
