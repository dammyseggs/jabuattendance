<?php

namespace App\Http\Controllers\Staff;

use PDF;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Attend;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Attendance;
use App\Models\Attenddate;
use App\Models\Acadsession;
use Illuminate\Http\Request;
use App\Models\Markattendance;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    private $stdid;
    public $attarray = array();
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lectu = auth()->user()->lectures()->get();
        $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

        $student = null;
        $stdexist= false;

        $currentses = $currentsession = Acadsession::where('current', 1)->exists();
        
        return Inertia::render('Lecturer/Attendance/Attendance', 
          ['lectu'=> $lectu, 'lectuexist'=> $lectuexist, 'stdexist'=> $stdexist, 'students'=> $student, 
          'currentses'=> $currentses,]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadstudent(Request $request)
    {
        $lectu = auth()->user()->lectures()->get();
        $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

        $selectLecture = Lecture::find($request->input('theclass'));
        $currentses = $currentsession = Acadsession::where('current', 1)->exists(); 

        $students = $selectLecture->students;
        $stdexist= $selectLecture->students->count() > 0 ? true: false;

        
        return Inertia::render('Lecturer/Attendance/Attendance', 
          ['lectu'=> $lectu, 'lectuexist'=> $lectuexist, 'stdexist'=> $stdexist, 'students'=> $students, 'currentses'=> $currentses,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markattendance(Request $request)
    {
        $lectStd = Lecture::find($request->input('theclass'))->students;
        
        $attdate = Attenddate::create([
            'lecture_id' => $request->input('theclass'),
        ]);

        foreach ($lectStd as $student) {
           if (in_array($student->id, $request->input('captureStudent')) ) {
                $markatt = Attend::create([
                    'student_id' => $student->id,
                    'attenddate_id' => $attdate->id,
                    'lecture_id' => $request->input('theclass'),
                    'attend' => 1,
                ]);
           }else{
                $markatt = Attend::create([
                    'student_id' => $student->id,
                    'attenddate_id' => $attdate->id,
                    'lecture_id' => $request->input('theclass'),
                    'attend' => 0,
                ]);
           }
            
        }

        return redirect(route('staff.dashboard'))->withSuccess('Attendance marked successfully!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewattendance()
    {
        
        
        
        $currentses = Acadsession::where('current', 1)->first();
        // $lectu = auth()->user()->lectures()->where('acadsession_id', $currentses->id)->get();
        $lectu = auth()->user()->lectures()->orderBy('acadsession_id', 'desc')->get();
        $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

        $attendexist = false;
        $allattend = null;
        $attdates = null;

        return Inertia::render('Lecturer/Attendance/ViewAttendance', 
          ['lectus'=> $lectu, 'lectuexist'=> $lectuexist, 'attendexist'=> $attendexist, 
          'allattends'=> $allattend, 'attdates'=> $attdates,]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewallattendance()
    {     
        $currentses = Acadsession::where('current', 1)->first();
        // $lectu = auth()->user()->lectures()->where('acadsession_id', $currentses->id)->get();
        $lectu = auth()->user()->lectures()->orderBy('acadsession_id', 'desc')->get();
        $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

        $attendexist = false;
        $allattend = null;
        $attdates = null;

        $allsessions = Acadsession::all();
        $courses = Course::where('department_id', auth()->user()->department->id)->get();
        $allclasses = Lecture::where('department_id', auth()->user()->department->id)->get();

        // dd($allclasses);

        return Inertia::render('Lecturer/Attendance/ViewAllAttendance', ['courses'=> $courses, 'allsessions'=> $allsessions]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewattendancetable(Request $request)
    {
        
        $currentses = Acadsession::where('current', 1)->first();
        $lectu = auth()->user()->lectures()->where('acadsession_id', $currentses->id)->get();
        $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

        
        $attendexist = Attend::where('lecture_id', $request->input('theclass'))->count() > 0 ? true: false;
        $allattend = Attend::where('lecture_id', $request->input('theclass'))->get();
        $attendancedates = Attenddate::where('lecture_id', $request->input('theclass'))->get();
        
        //process Attendance Date Array
        $attdates = array();
        $percentage = array();
        array_push($attdates, 'Matric Number');

        foreach($attendancedates as $item) {
            array_push($attdates, $item->created_at->format('d/m/Y'));
        }

        array_push($attdates, 'Percentage');
        
        $atttest = Attend::orderBy('student_id')->get();

        $attt = $allattend->groupBy('student_id');

        $count = 0;
        $perc = 0;

        foreach ($attt as $stds){
            $count = 0;
            foreach($stds as $std){
                if($std->attend == 1){
                    $count = $count + 1;
                }
            }

            $perc = (int)(($count / $stds->count()) * 100);
            $percentage[$stds[0]->student->id] = $perc.'%';
        }
        
        // dd($percentage);
        
        return Inertia::render('Lecturer/Attendance/ViewAttendance', 
          ['lectus'=> $lectu, 'lectuexist'=> $lectuexist, 'attendexist'=> $attendexist, 
          'allattends'=> $attt, 'attdates'=> $attdates, 'percentages'=> $percentage]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewattendancetable2(Request $request)
    {
        
        $currentses = Acadsession::where('current', 1)->first();
        $lectu = auth()->user()->lectures()->where('acadsession_id', $currentses->id)->get();
        $lectuexist = auth()->user()->lectures()->count() > 0 ? true: false;

        
        $attendexist = Attend::where('lecture_id', $request->input('theclass'))->count() > 0 ? true: false;
        $allattend = Attend::where('lecture_id', $request->input('theclass'))->get();
        $attendancedates = Attenddate::where('lecture_id', $request->input('theclass'))->get();
        
        //process Attendance Date Array
        $attdates = array();
        array_push($attdates, 'Matric Number');

        foreach($attendancedates as $item) {
            array_push($attdates, $item->created_at->format('d/m/Y'));
        }

        //Students in lecture
        $stdslectu = Lecture::find($request->input('theclass'))->students;   //->where('id', $request->input('theclass'))->get();

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
        
        // dd($stdArray);
        
        return Inertia::render('Lecturer/Attendance/ViewAttendance', 
          ['lectus'=> $lectu, 'lectuexist'=> $lectuexist, 'attendexist'=> $attendexist, 
          'allattend'=> $allattend, 'attdates'=> $attdates, 'stdsattendance'=> $stdArray]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function attendancepdf()
    {
        // $data = [
        //     'title' => 'Welcome to AB Test.com',
        //     'author' => 'Abey JAVA',
        //     'date' => date('m/d/Y')
        // ];

        // $pdf = PDF::loadView('pdf.studentAttendance', $data);

        // return $pdf->download('studentAttendance.pdf');

        return view('pdf.studentAttendance');
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportatendance(Request $request)
    {
        $currentses = Acadsession::where('current', 1)->first();
        $selectclass = Lecture::find($request->input('theclass'));

        $attendancedates = Attenddate::where('lecture_id', $request->input('theclass'))->get();
        $attt = Attend::where('lecture_id', $request->input('theclass'))->get();
        $allattends = $attt->groupBy('student_id');
        
        // dd($sellectures->department);



        $attdates = array();
        array_push($attdates, 'Matric Number');

        foreach($attendancedates as $item) {
            array_push($attdates, $item->created_at->format('d/m/Y'));
        }
        array_push($attdates, 'Percentage');





        $data = compact('currentses', 'selectclass', 'attdates', 'allattends');

        $pdf = PDF::loadView('pdf.studentAttendance', $data);

        return $pdf->download('studentAttendance.pdf');

        // return PDF::loadFile(public_path().'studentAttendance')
        //     ->save('studentAttendance.pdf')->stream('download.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
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
