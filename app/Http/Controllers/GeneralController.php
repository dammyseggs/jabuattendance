<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attend;
use App\Models\College;
use App\Models\Lecture;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Retrieve countries data
     *
     * @return void
     */
    public function getCollege()
    {
        $data = College::get();
        return response()->json($data);
    }

    /**
     * Retrieve countries data
     *
     * @return void
     */
    public function getSession()
    {
        $data = Acadsession::get();
        return response()->json($data);
    }

    /**
     * Retrieve states data
     *
     */
    public function getDepartment(Request $request)
    {
        $data = Department::where('college_id', $request->input('college_id'))->get();
        return response()->json($data);
    }


    /**
     * Retrieve states data
     *
     */
    public function getAttendance(Request $request)
    {
        $allattend = Attend::where('lecture_id', 1)->get();
        $stdslectu = Lecture::find(1)->students;
        $theattend = array();
        $stdArray = collect();

        foreach ($stdslectu as $std) {
            $this->stdid = $std->id;
            $avastds = $allattend->filter(function ($item) {
                return data_get($item, 'student_id') == $this->stdid;
            });

            //$this->createCollection($avastds);
            $stdArray->push($this->createCollection($avastds));
        }

        return response()->json($stdArray);
    }

    /**
     * Retrieve states data
     *
     */
    public function getStaff(Request $request)
    {
        $columns = ['staffid', 'title', 'name', 'othername', 'email', 'department'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = User::select('staffid', 'title', 'name', 'othername', 'email', 'department_id',)->orderBy($columns[$column], $dir);

        // if ($searchValue) {

        //     $query->where(funtion($query)use($searchValue){
        //         $query->where('staffid', 'like', '%'.$searchValue.'%')
        //         ->where('title', 'like', '%'.$searchValue.'%')
        //         ->where('name', 'like', '%'.$searchValue.'%')
        //         ->where('othername', 'like', '%'.$searchValue.'%')
        //         ->where('email', 'like', '%'.$searchValue.'%')
        //         ->where('name', 'like', '%'.$searchValue.'%')
        //     });
        // }
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
        //
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkLogin()
    {
        if (Auth::check()) {
            if(auth()->user()->hasRole('admin')){
                return redirect(route('admin.dashboard'));
            }
    
            if(auth()->user()->hasRole('lecturer')){
                return redirect(route('staff.dashboard'));
            }   
        }else{
            return redirect(route('login'));           
        }
        
            
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDashboard()
    {
        if(auth()->user()->hasRole('admin')){
            return redirect(route('admin.dashboard'));
        }

        if(auth()->user()->hasRole('lecturer')){
            return redirect(route('staff.dashboard'));
        }       
        
    }


    public function createCollection($avastds){
        $data = array(); 
        $attend = array();
        $a = 1;
        $data["matric"] = $avastds->first()->student->matric_no; 
        foreach ($avastds as $std){
            // $data[$std->attenddate->created_at->format('d/m/Y')] = $std->attend;
            $data['Day'.$a] = $std->attend;
            array_push($attend, $std->attend);
            $a++;
        }

        $data["total"] = $this->calPercentage($attend);

        return $data;
        
    }

    public function calPercentage($attend){
        $total = count($attend);
        $present = count(array_keys($attend, 1));
        $cal = ceil(($present/$total) * 100);
        
        return $cal."%";
    }

}
