<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Attend;
use App\Models\Lecture;
use App\Models\Student;
use App\Models\Attenddate;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class TestController extends Controller
{
    
    private $stdid;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $std = Attend::all();

        dd($std);
        //return Inertia::render('Test');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2()
    {
        //$std = Attend::all();
        $allAttends = Attend::where('lecture_id', 1)->get();
        $attdates = Attenddate::where('lecture_id', 1)->get();
        $stdslectu = Lecture::find(1)->students;

        $columnhead = array();
        $theattend = array();

        // $columnhead = Arr::add(['Student' => 'Student']);
        $columnhead = Arr::add($columnhead, 'Student', 'Student');
        $i = 1;

        foreach ($attdates as $attdate){ 
            //$columnhead = Arr::add(['Day'.$i => $attdate->created_at]);
            $columnhead = Arr::add($columnhead, 'Day'.$i, $attdate->created_at);
            $i++;
        }

        $stdArray = collect();

        foreach ($stdslectu as $std) {
            $this->stdid = $std->id;
            $avastds = $allAttends->filter(function ($item) {
                return data_get($item, 'student_id') == $this->stdid;
            });

            $stdArray->add($this->addToArray($avastds));
            //$this->addToArray($avastds);
        }
        
        return response()->json($stdArray);
        //return Inertia::render('Test2');// $ttend = Attend::all();
    }


    public function addToArray($avastds){
        $data = array($avastds->first()->student->matric_no);
        foreach ($avastds as $std){
            array_push($data, $std->attend);
            
            //Arr::add($data, $std->attend);

        }
        return $data;
    }

}
