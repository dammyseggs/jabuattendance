<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JABU Attendance</title>
</head>
<style>
    .container{        
        max-width: 1000px;
        margin: 0 auto;
        font-size: 12px;
    }

    .main-head{
        font-weight: 700;
        text-align: center;
        font-size: 16px;
    }

    .main-head div{
        padding: 5px 0;
    }

    .attendtable{
        display: block;
        width: auto;         
        background-color: #eee;         
        border: 1px solid #666666;         
        border-spacing: 5px;
    }

    .thead{
        display: table-row;
        width: auto;
        clear: both;
    } 






    #resp-table {
        width: 100%;
        display: table;
    }
    #resp-table-body{
        display: table-row-group;
    }
    .resp-table-row{
        display: table-row;
    }
    .table-body-cell{
        display: table-cell;
        border: 1px solid #dddddd;
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
    }
    .bg{
        background-color: #e2bdbd;
    }

    .bb{
        border: 1px solid #434242;
    }
    
    .info{
        padding: 10px 0 0 0;
    }

    .info div{
        margin-bottom: 10px

    }

    .info div span{
        font-weight: 700;
        margin-left: 5px;
    }

</style>
<body>
    <div class="container">
        <div class="pdf-img">
            <img src="'attendance1.png'" alt="" height="30" class="">
        </div>
        <div class="main-head">
            <div>JOSEPH AYO BABALOLA UNIVERSITY</div>
            <div>IKEJI-ARAKEJI, OSUN STATE</div>
            <div>JABU ONLINE ATTENDANCE SYSTEM</div>
            <div>DEPARTMENT OF {{ Str::upper($selectclass->department->name) }} ATTENDACE</div>            
        </div>

        <div class="info">
            <div><span>Class Name:  </span>{{ $selectclass->name }}</div>      
            <div><span>Date Printed:  </span>{{ date('d-m-y h:i:s') }}</div>
            <div><span>Session:  </span>{{ $currentses->name }}</div>
        </div>


        

       
            


           {{-- <div class="attendbody">
                 @foreach ($allattends as $allattend)
                    <div class="attendline">
                        <div class="matric">{{ $allattend[0]->student->matric_no }}</div>
                        @foreach ( $allattend as $attend)
                            <div class="attend">{{ $attend->attend }}</div>
                        @endforeach
                    </div>
                   {{-- <div class="matric">{{ $allattend[0]->student->matric_no }}</div>
                    @foreach ( $allattend as $attend)
                        <div class="attend">{{ $attend->attend }}</div>
                    @endforeach
                    <div></div> --}

                @endforeach 
            </div>--}}


        <div  id="resp-table">
            <div id="resp-table-body">
                <div class="resp-table-row">
                    @foreach ($attdates as $atthead)
                        <div class="table-body-cell">{{ $atthead }}</div>
                    @endforeach
                </div>
                    @foreach ($allattends as $allattend)
                       @php ($attendcal = 0)
                       @php ($attendtotal = 0)
                       @php ($percent = 0)
                        <div class="resp-table-row bg bb">
                            <div class="table-body-cell">{{ $allattend[0]->student->matric_no }}</div>
                            @foreach ( $allattend as $attend)
                                <div class="table-body-cell">{{ $attend->attend }}</div>
                                @php ($attendtotal++)
                                @if($attend->attend == 1)
                                    @php ($attendcal++)
                                @endif
                            @endforeach
                            @php ($percent = ($attendcal/$attendtotal)*100 )
                            <div class="table-body-cell">{{ ceil($percent) }}%</div>
                        </div>
                    @endforeach
                
            </div>

        </div>


        </div>
    </div>
   
</body>
</html>