@include('layouts.app')
<head>
    <meta charset="utf-8" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #section-to-print, #section-to-print * {
                visibility: visible;
            }
            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
</head>
<?php
$suger=array();
$val = array();
$count=1;
$data = DB::table('blood_sugers')->where('userId',Auth::user()->id)->where('paymentStatus',1)->get();
foreach ($data as $d){
    array_push($suger,$count);
    array_push($val,$d->bloodSuger);
    $count+=1;
}
$slps = array();
$sval = array();
$count = 1;
$data = DB::table('serums')->where('userId',Auth::user()->id)->where('paymentStatus',1)->get();
foreach ($data as $d){
    array_push($slps,$count);
    array_push($sval,$d->serum);
    $count+=1;
}
?>
   <!------ Include the above in your HEAD tag ---------->

    <div class="container emp-profile">
        @if(Session::has('delr'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Report Deleted Successfully</strong>
            </div>
            {{ Session::forget('delr') }}
        @endif
        @if(Session::has('sampleadd'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Sample Added Successfully</strong>
            </div>
            {{ Session::forget('sampleadd') }}
        @endif
            @if(Session::has('mlt'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>MLT Added Successfully</strong>
                </div>
                {{ Session::forget('mlt') }}
            @endif
            @if(Session::has('rpa'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Report Added Successfully</strong>
                </div>
                {{ Session::forget('rpa') }}
            @endif
            @if(Session::has('pa'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Patient Added Successfully</strong>
                </div>
                {{ Session::forget('pa') }}
            @endif
            @if(Session::has('em'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Employee Added Successfully</strong>
                </div>
                {{ Session::forget('em') }}
            @endif
            @if(Session::has('emdel'))
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Employee Deleted Successfully</strong>
                </div>
                {{ Session::forget('emdel') }}
            @endif
            @if(Session::has('emup'))
                <div class="alert alert-warning" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Employee Updated Successfully</strong>
                </div>
                {{ Session::forget('emup') }}
            @endif

        @if(Auth::user()->role == 'patient')

        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Payment Successfully</strong>
            </div>
            {{ Session::forget('success') }}
        @endif
            <div class="row">

                <div class="col-md-4">
                    <div class="profile-img">
                        @if(!is_file(base_path() . '/public/img/'.Auth::user()->id))
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" style="height: 200px" alt=""/>
                        @else
                            <img src="{{asset('img/'.Auth::user()->id)}}" style="height: 200px" alt=""/>
                        @endif
                            <div class="file btn btn-lg btn-primary">
                            <button type="button" class="w3-button w3-small w3-white w3-border w3-border-teal w3-round-xxlarge" data-toggle="modal" data-target="#pic">
                                <span class="fa fa-camera" align='right'> Change Profile Picture</span>
                            </button>

                        </div>
                        <div class="modal fade" id="pic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: teal">
                                        <h2 class="modal-title" id="exampleModalLabel" style="color: white;text-align: center">Upload Image</h2>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form runat="server" action="{{route('uploadPhoto')}}" method="post" enctype="multipart/form-data">

                                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                            <div class="form-inline">
                                                <input id='picture' accept="image/*" type="file"  onchange="readURL(this);" name="pic" class="form-group mb-2 w3-button w3-small w3-white w3-border w3-border-teal w3-round-xxlarge" style="padding-left: 20px;" value="Select your Photo" required/>
                                                <input type="submit" class="w3-button w3-small w3-white w3-border w3-border-teal w3-round-xxlarge" style="margin-top: 5px" value="Upload" name="btn"/><br>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="profile-head">
                        <h5>
                            {{Auth::user()->name}}
                        </h5>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#bs" role="tab" aria-controls="home" aria-selected="true">Blood Suger</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#serum" role="tab" aria-controls="home" aria-selected="true">Serum Lipid Profile</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#lp" role="tab" aria-controls="home" aria-selected="true">Lipid Profile</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#fbc" role="tab" aria-controls="home" aria-selected="true">Full Blood Count</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#lft" role="tab" aria-controls="home" aria-selected="true">Liver Function Test</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="profile" aria-selected="false">Summary</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">

                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <br>
                    <div class="profile-work">
                        <?php
                        $dob = Auth::user()->dob;
                        $date = new DateTime($dob);
                        $now = new DateTime();
                        $interval = $now->diff($date);
                        ?>
                        <span> {{Auth::user()->name}}</span><br>
                        <span > {{Auth::user()->email}}</span><br>
                        <span> {{$interval->y}}</span>

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade active in" id="bs" role="tabpanel" aria-labelledby="home-tab">

                            @foreach($sugers as $bs)
                                <div class="panel-body" style="border:solid; border-radius: 25px">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <p>Your Blood Suger of the date {{$bs->created_at}}</p>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if($bs->paymentStatus==0)
                                                        <form action="{{route('reportPayment')}}" method="post">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="amount" value="1">
                                                            <input type="submit" style="float: right" class="btn btn-warning" value="pay">
                                                        </form>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    @if($bs->paymentStatus==1)
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bs{{$bs->id}}">
                                                            View Report
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="bs{{$bs->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Blood Suger Test</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div id="section-to-print" class="modal-body section-to-print">
                                                                        <?php
                                                                        $dob = Auth::user()->dob;
                                                                        $date = new DateTime($dob);
                                                                        $now = new DateTime();
                                                                        $interval = $now->diff($date);
                                                                        ?>
                                                                        <h3 style="text-align: center" class="text-primary">Medi Lab</h3>
                                                                        <h5 style="text-align: center">Blood Suger List</h5>
                                                                        <h4 style="text-align:center ;">contact us 0717843564</h4>

                                                                        Name   : {{Auth::user()->name}}<br>
                                                                        Age    : {{$interval->y}}<br>
                                                                        Gender : {{Auth::user()->gender}}
                                                                        <table class="table borderless">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>Test</th>
                                                                                <th>Result</th>
                                                                                <th>units</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td>Blood Suger</td>
                                                                                <td>{{$bs->bloodSuger}}</td>
                                                                                <td>mg/dl</td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>


                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach


                        </div>
                        <div class="tab-pane fade" id="serum" role="tabpanel" aria-labelledby="home-tab">

                            @foreach($slp as $bs)
                            <div class="panel-body" style="border:solid; border-radius: 25px">
                            <div class="row">
                                <div class="col-md-6">

                                        <p>Your Serum Lipi Profile of the date {{$bs->created_at}}</p>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if($bs->paymentStatus==0)
                                            <form action="{{route('reportPayment')}}" method="post">
                                                {{csrf_field()}}
                                                <input type="hidden" name="amount" value="1">
                                                <input type="submit" style="float: right" class="btn btn-warning" value="pay">
                                            </form>
                                             @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if($bs->paymentStatus==1)
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bs{{$bs->id}}">
                                                View Report
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="bs{{$bs->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Blood Suger Test</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div id="section-to-print" class="modal-body section-to-print">
                                                            <?php
                                                            $dob = Auth::user()->dob;
                                                            $date = new DateTime($dob);
                                                            $now = new DateTime();
                                                            $interval = $now->diff($date);
                                                            ?>
                                                            <h3 style="text-align: center" class="text-primary">Medi Lab</h3>
                                                            <h5 style="text-align: center">Serum Lipid Profile </h5>
                                                            <h4 style="text-align:center ;">contact us 0717843564</h4>

                                                            Name   : {{Auth::user()->name}}<br>
                                                            Age    : {{$interval->y}}<br>
                                                            Gender : {{Auth::user()->gender}}
                                                                <table class="table borderless">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Test</th>
                                                                        <th>Result</th>
                                                                        <th>units</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>Serum Creatinine</td>
                                                                        <td>{{$bs->serum}}</td>
                                                                        <td>mg/dl</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>

                            @endforeach


                        </div>
                        <div class="tab-pane fade" id="lp" role="tabpanel" aria-labelledby="home-tab">
                            @foreach($lipidProfile as $lp)
                                <div class="panel-body" style="border:solid; border-radius: 25px">
                                <div class="row">
                                    <div class="col-md-6">

                                        <p>Your Lipid Profile report of the date {{$lp->created_at}}</p>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if($lp->paymentStatus==0)
                                                <form action="{{route('reportPayment')}}" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="amount" value="1">
                                                    <input type="submit" style="float: right" class="btn btn-warning" value="pay">
                                                </form>
                                                    @endif
                                            </div>
                                            <div class="col-md-6">
                                                @if($lp->paymentStatus==1)
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#lp{{$lp->id}}">
                                                    View Report
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="lp{{$lp->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Lipid Profile</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div id="section-to-print" class="modal-body section-to-print">
                                                                <?php
                                                                    $dob = Auth::user()->dob;
                                                                $date = new DateTime($dob);
                                                                $now = new DateTime();
                                                                $interval = $now->diff($date);
                                                                ?>
                                                                  <h3 style="text-align: center" class="text-primary">Medi Lab</h3>
                                                                  <h5 style="text-align: center" >Lipid Profile</h5>
                                                                  <h4 style="text-align:center ;">contact us 0717843564</h4>

                                                                Name   : {{Auth::user()->name}}<br>
                                                                Age    : {{$interval->y}}<br>
                                                                Gender : {{Auth::user()->gender}}

                                                                    <table class="table borderless">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Test</th>
                                                                            <th>Result</th>
                                                                            <th>units</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td>Serum Cholestrol</td>
                                                                            <td>{{$lp->serum}}</td>
                                                                            <td>mg/dl</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Triglycerides</td>
                                                                            <td>{{$lp->trigly}}</td>
                                                                            <td>mg/dl</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>HDL Cholestrol</td>
                                                                            <td>{{$lp->hdl}}</td>
                                                                            <td>mg/dl</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>VLDL Cholestrol</td>
                                                                            <td>{{$lp->vldl}}</td>
                                                                            <td>mg/dl</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Cholestrol/HDL Ratio</td>
                                                                            <td>{{$lp->cholestrol}}</td>
                                                                            <td>-</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach


                        </div>
                        <div class="tab-pane fade" id="fbc" role="tabpanel" aria-labelledby="home-tab">
                            @foreach($fbc as $fb)
                                <div class="panel-body" style="border:solid; border-radius: 25px">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <p>Your Full Blood Count date {{$fb->created_at}}</p>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if($fb->paymentStatus==0)
                                                        <form action="{{route('reportPayment')}}" method="post">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="amount" value="1">
                                                            <input type="submit" style="float: right" class="btn btn-warning" value="pay">
                                                        </form>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    @if($fb->paymentStatus==1)
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#fbc{{$fb->id}}">
                                                            View Report
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="fbc{{$fb->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Full Blood Count</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div id="section-to-print" class="modal-body section-to-print">
                                                                        <?php
                                                                        $dob = Auth::user()->dob;
                                                                        $date = new DateTime($dob);
                                                                        $now = new DateTime();
                                                                        $interval = $now->diff($date);
                                                                        ?>
                                                                        <h3 style="text-align: center" class="text-primary">Medi Lab</h3>
                                                                        <h5 style="text-align: center" >Full Blood Count</h5>
                                                                        <h4 style="text-align:center ;">contact us 0717843564</h4>

                                                                        Name   : {{Auth::user()->name}}<br>
                                                                        Age    : {{$interval->y}}<br>
                                                                        Gender : {{Auth::user()->gender}}

                                                                        <table class="table borderless">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>Test</th>
                                                                                <th>Result</th>
                                                                                <th>units</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td>Neutrophils</td>
                                                                                <td>{{$fb->neutrophil}}</td>
                                                                                <td>mg/dl</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Lymphocytes</td>
                                                                                <td>{{$fb->lymphocytes}}</td>
                                                                                <td>mg/dl</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Monocytes</td>
                                                                                <td>{{$fb->monocytes}}</td>
                                                                                <td>mg/dl</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Haemoglobin</td>
                                                                                <td>{{$fb->hemoglobin}}</td>
                                                                                <td>mg/dl</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Red Blood Cells</td>
                                                                                <td>{{$fb->rbc}}</td>
                                                                                <td>-</td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                        <div class="tab-pane fade" id="lft" role="tabpanel" aria-labelledby="home-tab">
                            @foreach($lft as $lf)
                                <div class="panel-body" style="border:solid; border-radius: 25px">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <p>Your Lipid Profile report of the date {{$lf->created_at}}</p>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if($lf->paymentStatus==0)
                                                        <form action="{{route('reportPayment')}}" method="post">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="amount" value="1">
                                                            <input type="submit" style="float: right" class="btn btn-warning" value="pay">
                                                        </form>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    @if($lf->paymentStatus==1)
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#lf{{$lf->id}}">
                                                            View Report
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="lf{{$lf->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Lipid Profile</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div id="section-to-print" class="modal-body section-to-print">
                                                                        <?php
                                                                        $dob = Auth::user()->dob;
                                                                        $date = new DateTime($dob);
                                                                        $now = new DateTime();
                                                                        $interval = $now->diff($date);
                                                                        ?>
                                                                        <h3 style="text-align: center" class="text-primary">Medi Lab</h3>
                                                                        <h5 style="text-align: center" >Liver Function Test</h5>
                                                                        <h4 style="text-align:center ;">contact us 0717843564</h4>

                                                                        Name   : {{Auth::user()->name}}<br>
                                                                        Age    : {{$interval->y}}<br>
                                                                        Gender : {{Auth::user()->gender}}

                                                                        <table class="table borderless">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>Test</th>
                                                                                <th>Result</th>
                                                                                <th>units</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td>Total Protein</td>
                                                                                <td>{{$lf->totalProtein}}</td>
                                                                                <td>mg/dl</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Albumin</td>
                                                                                <td>{{$lf->albumin}}</td>
                                                                                <td>mg/dl</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Globulin</td>
                                                                                <td>{{$lf->globulin}}</td>
                                                                                <td>mg/dl</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Alkaline</td>
                                                                                <td>{{$lf->alkaline}}</td>
                                                                                <td>mg/dl</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Total Bilirubin</td>
                                                                                <td>{{$lf->totalBilirubin}}</td>
                                                                                <td>-</td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                        <div class="tab-pane fade" id="summary" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="myChart" width="350" height="350"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="myChart1" width="350" height="350"></canvas>
                                </div>
                            </div>
                            {{--<canvas id="myChart" width="350" height="350"></canvas>--}}
                        </div>
                    </div>
                </div>
            </div>
            @endif

        @if(Auth::user()->role=="MLT")
                <div class="row">


                    <div class="col-md-4">
                        <div class="profile-img">
                            @if(!is_file(base_path() . '/public/img/'.Auth::user()->id))
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" style="height: 200px" alt=""/>
                            @else
                                <img src="{{asset('img/'.Auth::user()->id)}}" style="height: 200px" alt=""/>
                            @endif
                            <div class="file btn btn-lg btn-primary">
                                <button type="button" class="w3-button w3-small w3-white w3-border w3-border-teal w3-round-xxlarge" data-toggle="modal" data-target="#pic">
                                    <span class="fa fa-camera" align='right'> Change Profile Picture</span>
                                </button>

                            </div>
                            <div class="modal fade" id="pic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: teal">
                                            <h2 class="modal-title" id="exampleModalLabel" style="color: white;text-align: center">Upload Image</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form runat="server" action="{{route('uploadPhoto')}}" method="post" enctype="multipart/form-data">

                                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                <div class="form-inline">
                                                    <input id='picture' accept="image/*" type="file"  onchange="readURL(this);" name="pic" class="form-group mb-2 w3-button w3-small w3-white w3-border w3-border-teal w3-round-xxlarge" style="padding-left: 20px;" value="Select your Photo" required/>
                                                    <input type="submit" class="w3-button w3-small w3-white w3-border w3-border-teal w3-round-xxlarge" style="margin-top: 5px" value="Upload" name="btn"/><br>
                                                </div>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                            <h5>
                                {{Auth::user()->name}}
                            </h5>

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#report" role="tab" aria-controls="home" aria-selected="true">Add Reports</a>
                                </li>
                                <li class="nav-item">
                                    <a class="naexceeds your upload_max_filesize ini directive v-link" id="profile-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="profile" aria-selected="false">Summary</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <br>
                        <div class="profile-work">
                            <span class="glyphicon-envelope"> {{Auth::user()->email}}</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade active in" id="report" role="tabpanel" aria-labelledby="home-tab">
                                <input style="margin-bottom: 15px;" class="form-control" id="myInput" type="text" placeholder="Search..">
                                @foreach($user as $users)
                                    <ul class="list-group" id="myList">
                                        <li class="list-group-item">

                                    <div class="panel-body" style="border:solid; border-radius: 25px">
                                    <div class="row">
                                        <div class="col-md-6">

                                                <p>Name: {{$users->name}}</p>
                                                <p>Email: {{$users->email}}</p>
                                                <p>Gender: {{$users->gender}}</p>
                                                <?php
                                                    $date = new DateTime($users->dob);
                                                    $now = new DateTime();
                                                    $interval = $now->diff($date);
                                                ?>
                                                <p>Age: {{$interval->y}}</p>




                                        </div>
                                        <div class="col-md-6">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    {{--<form action="{{route('reportPayment')}}" method="post">--}}
                                                        {{--{{csrf_field()}}--}}
                                                        {{--<input type="hidden" name="amount" value="1">--}}
                                                        {{--<input type="submit" style="float: right" class="btn btn-warning" value="pay">--}}
                                                    {{--</form>--}}
                                                </div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#fbc{{$users->id}}">
                                                        + Full blood count
                                                    </button>

                                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#bs{{$users->id}}">
                                                        + Blood Suger
                                                    </button>
                                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#lp{{$users->id}}">
                                                        + Lipid Profile
                                                    </button>
                                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#lf{{$users->id}}">
                                                        + Liver function Test
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="fbc{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 style="text-align: center" class="modal-title" id="exampleModalLabel">Full Blood Count</h1>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div id="section-to-print" class="modal-body section-to-print">
                                                                    <form action="{{route('fbc')}}" method="post">
                                                                        {{csrf_field()}}
                                                                        <label>Payment Status</label>
                                                                        <select name="payment" class="form-control" required>
                                                                            <option value="1">Paid</option>
                                                                            <option value="2">Not Paid</option>
                                                                        </select>
                                                                        <br>
                                                                        <input type="hidden" name='id' class="form-control" value="{{$users->id}}" required>
                                                                        <label>Neutrophil</label>
                                                                        <input type="number" name="neutrophil" step="0.01"class="form-control" required>
                                                                        <br>
                                                                        <label>Lymphocytes</label>
                                                                        <input type="number" name="lymphocytes" step="0.01"  class="form-control" required>
                                                                        <br>

                                                                        <label>Monocytes</label>
                                                                        <input type="number" name="monocytes" step="0.01" class="form-control" required>
                                                                        <br>

                                                                        <label>Hemoglobin</label>
                                                                        <input type="number" name="hemoglobin" step="0.01" class="form-control" required>
                                                                        <br>

                                                                        <label>Red Blood Cells</label>
                                                                        <input type="number" name="rbc" step="0.01" name="" class="form-control" required>
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                                                                    </form>


                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="bs{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 style="text-align: center" class="modal-title" id="exampleModalLabel">Fasting Blood Suger</h1>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div id="section-to-print" class="modal-body section-to-print">
                                                                    <form action="{{route('bloodSuger')}}" method="post">
                                                                        {{csrf_field()}}
                                                                        <input type="hidden" name="id" value="{{$users->id}}">
                                                                        <label>Payment Status</label>
                                                                        <select name="payment" class="form-control" required>
                                                                            <option value="1">Paid</option>
                                                                            <option value="0">Not Paid</option>
                                                                        </select>
                                                                        <br>
                                                                        <label>Fasting Blood Glucose mg/dl</label>
                                                                        <input type="number" step="0.01" name="bsvalue" class="form-control" required>
                                                                        <br>
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <input  type="submit" class="btn btn-primary" value="Submit">
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="lp{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 style="text-align: center" class="modal-title" id="exampleModalLabel" >Lipid Profile</h1>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div id="section-to-print" class="modal-body section-to-print">
                                                                    <form action="#" method="post">
                                                                        <label>Payment Status</label>
                                                                        <select name="" class="form-control" required>
                                                                            <option value="1">Paid</option>
                                                                            <option value="2">Not Paid</option>
                                                                        </select>
                                                                        <br>
                                                                        <input type="hidden" class="form-control" value="{{$users->id}}" required>
                                                                        <label>Serum Cholestrol mg/dl</label>
                                                                        <input type="number" step="0.01" name="" class="form-control" required>
                                                                        <br>
                                                                        <label>Triglycerides mg/dl</label>
                                                                        <input type="number" step="0.01" name="" class="form-control" required>
                                                                        <br>

                                                                        <label>HDL Cholestrol mg/dl</label>
                                                                        <input type="number" step="0.01" name="" class="form-control" required>
                                                                        <br>

                                                                        <label>Vldl Cholestrol mg/dl</label>
                                                                        <input type="number" step="0.01" name="" class="form-control" required>
                                                                        <br>

                                                                        <label>Choiesterol/HDL Ratio</label>
                                                                        <input type="number" step="0.01" name="" class="form-control" required>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="lf{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title" id="exampleModalLabel" style="text-align: center">Liver Function Test</h1>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div id="section-to-print" class="modal-body section-to-print">
                                                                    <form action="{{route('liver')}}" method="post">
                                                                        {{csrf_field()}}
                                                                        <label>Payment Status</label>
                                                                        <select name="payment" class="form-control" required>
                                                                            <option value="1">Paid</option>
                                                                            <option value="2">Not Paid</option>
                                                                        </select>
                                                                        <br>
                                                                        <input type="hidden" name='id' class="form-control" value="{{$users->id}}" required>
                                                                        <label>Total Protein g/L</label>
                                                                        <input type="number" name="totalProtein" step="0.01"class="form-control" required>
                                                                        <br>
                                                                        <label>Albumin g/L</label>
                                                                        <input type="number" name="albumin" step="0.01"  class="form-control" required>
                                                                        <br>

                                                                        <label>Globulin g/L</label>
                                                                        <input type="number" name="globulin" step="0.01" class="form-control" required>
                                                                        <br>

                                                                        <label>Alkaline phosphatase U/L</label>
                                                                        <input type="number" name="alkaline" step="0.01" class="form-control" required>
                                                                        <br>

                                                                        <label>Total Bilirubin mol/L</label>
                                                                        <input type="number" name="totalBilirubin" step="0.01" name="" class="form-control" required>
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                                                                    </form>


                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        </li>
                                    </ul>
                                @endforeach


                            </div>
                            <div class="tab-pane fade" id="summary" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <canvas id="myChart" width="350" height="350"></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <canvas id="myChart1" width="350" height="350"></canvas>
                                    </div>
                                </div>
                                {{--<canvas id="myChart" width="350" height="350"></canvas>--}}
                            </div>
                        </div>
                    </div>
                </div>
        @endif

        @if(Auth::user()->role=="admin")
                <div class="row">


                    <div class="col-md-4">
                        <div class="profile-img">
                            @if(!is_file(base_path() . '/public/img/'.Auth::user()->id))
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" style="height: 200px" alt=""/>
                            @else
                                <img src="{{asset('img/'.Auth::user()->id)}}" style="height: 200px" alt=""/>
                            @endif
                            <div class="file btn btn-lg btn-primary">
                                <button type="button" class="w3-button w3-small w3-white w3-border w3-border-teal w3-round-xxlarge" data-toggle="modal" data-target="#pic">
                                    <span class="fa fa-camera" align='right'> Change Profile Picture</span>
                                </button>

                            </div>
                            <div class="modal fade" id="pic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background: teal">
                                            <h2 class="modal-title" id="exampleModalLabel" style="color: white;text-align: center">Upload Image</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form runat="server" action="{{route('uploadPhoto')}}" method="post" enctype="multipart/form-data">

                                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                                <div class="form-inline">
                                                    <input id='picture' accept="image/*" type="file"  onchange="readURL(this);" name="pic" class="form-group mb-2 w3-button w3-small w3-white w3-border w3-border-teal w3-round-xxlarge" style="padding-left: 20px;" value="Select your Photo" required/>
                                                    <input type="submit" class="w3-button w3-small w3-white w3-border w3-border-teal w3-round-xxlarge" style="margin-top: 5px" value="Upload" name="btn"/><br>
                                                </div>

                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="profile-head">
                            <h5>
                                {{Auth::user()->name}}
                            </h5>

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#report" role="tab" aria-controls="home" aria-selected="true">Add Reports</a>
                                </li>
                                <li class="nav-item">
                                    <a class="naexceeds your upload_max_filesize ini directive v-link" id="viewReport-tab" data-toggle="tab" href="#viewReport" role="tab" aria-controls="profile" aria-selected="false">Reports</a>
                                </li>
                                <li class="nav-item">
                                    <a class="naexceeds your upload_max_filesize ini directive v-link" id="employee-tab" data-toggle="tab" href="#employee" role="tab" aria-controls="profile" aria-selected="false">Employee Management</a>
                                </li>
                                <li class="nav-item">
                                    <a class="naexceeds your upload_max_filesize ini directive v-link" id="sample-tab" data-toggle="tab" href="#sample" role="tab" aria-controls="profile" aria-selected="false">Sample Handling</a>
                                </li>
                             </ul>
                        </div>
                    </div>
                    <div class="col-md-2">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <br>
                        <div class="profile-work">
                            <span class="glyphicon-envelope"> {{Auth::user()->email}}</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <!-- Button trigger modal -->
                            <div class="tab-pane fade active in" id="report" role="tabpanel" aria-labelledby="home-tab">
                                <button type="button" style="margin-bottom: 10px;" class="btn btn-primary" data-toggle="modal" data-target="#addPa">
                                    Add Patient
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="addPa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Patient</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" method="POST" action="{{ route('addPatient') }}">
                                                    {{ csrf_field() }}

                                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                        <label for="name" class="col-md-4 control-label">Name</label>

                                                        <div class="col-md-6">
                                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                                            @if ($errors->has('name'))
                                                                <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                        <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                                        <div class="col-md-6">
                                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                                            @if ($errors->has('email'))
                                                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                                        <label for="email" class="col-md-4 control-label">Gender</label>

                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label><input type="radio" name="gender" style="float: right" value="male" checked required>Male</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label><input type="radio" name="gender" style="float: left" value="female" required>Female</label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                                                        <label for="email" class="col-md-4 control-label">Date of Birth</label>
                                                        <div class="col-md-6">
                                                            <input type="date" name="dob"  class="form-control" value="{{ old('dob') }}" required>
                                                        </div>
                                                    </div>


                                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                        <label for="password" class="col-md-4 control-label">Password</label>

                                                        <div class="col-md-6">
                                                            <input id="password" type="password" class="form-control" name="password" required>

                                                            @if ($errors->has('password'))
                                                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <input class="form-control" style="margin-bottom: 10px;" id="myInput" type="text" placeholder="Search..">
                                @foreach($user as $users)
                                    <ul class="list-group" id="myList">
                                        <li class="list-group-item">

                                            <div class="panel-body" style="border:solid; border-radius: 25px">
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <p>Name: {{$users->name}}</p>
                                                        <p>Email: {{$users->email}}</p>
                                                        <p>Gender: {{$users->gender}}</p>
                                                        <?php
                                                        $date = new DateTime($users->dob);
                                                        $now = new DateTime();
                                                        $interval = $now->diff($date);
                                                        ?>
                                                        <p>Age: {{$interval->y}}</p>




                                                    </div>
                                                    <div class="col-md-6">

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                {{--<form action="{{route('reportPayment')}}" method="post">--}}
                                                                {{--{{csrf_field()}}--}}
                                                                {{--<input type="hidden" name="amount" value="1">--}}
                                                                {{--<input type="submit" style="float: right" class="btn btn-warning" value="pay">--}}
                                                                {{--</form>--}}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#fbc{{$users->id}}">
                                                                    + Full blood count
                                                                </button>

                                                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#bs{{$users->id}}">
                                                                    + Blood Suger
                                                                </button>
                                                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#slp{{$users->id}}">
                                                                    + Serum Lipid Profile
                                                                </button>
                                                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#lp{{$users->id}}">
                                                                    + Lipid Profile
                                                                </button>
                                                                {{--<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#sc{{$users->id}}">--}}
                                                                    {{--+ serum Creatanin--}}
                                                                {{--</button>--}}
                                                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#lf{{$users->id}}">
                                                                    + Liver function Test
                                                                </button>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="fbc{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 style="text-align: center" class="modal-title" id="exampleModalLabel">Full Blood Count</h1>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div id="section-to-print" class="modal-body section-to-print">
                                                                                <form action="{{route('fbc')}}" method="post">
                                                                                    {{csrf_field()}}
                                                                                    <label>Payment Status</label>
                                                                                    <select name="payment" class="form-control" required>
                                                                                        <option value="1">Paid</option>
                                                                                        <option value="2">Not Paid</option>
                                                                                    </select>
                                                                                    <br>
                                                                                    <input type="hidden" name='id' class="form-control" value="{{$users->id}}" required>
                                                                                    <label>Neutrophil</label>
                                                                                    <input type="number" name="neutrophil" step="0.01"class="form-control" required>
                                                                                    <br>
                                                                                    <label>Lymphocytes</label>
                                                                                    <input type="number" name="lymphocytes" step="0.01"  class="form-control" required>
                                                                                    <br>

                                                                                    <label>Monocytes</label>
                                                                                    <input type="number" name="monocytes" step="0.01" class="form-control" required>
                                                                                    <br>

                                                                                    <label>Hemoglobin</label>
                                                                                    <input type="number" name="hemoglobin" step="0.01" class="form-control" required>
                                                                                    <br>

                                                                                    <label>Red Blood Cells</label>
                                                                                    <input type="number" name="rbc" step="0.01" name="" class="form-control" required>
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                                                                                </form>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal fade" id="bs{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 style="text-align: center" class="modal-title" id="exampleModalLabel">Fasting Blood Suger</h1>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div id="section-to-print" class="modal-body section-to-print">
                                                                                <form action="{{route('bloodSuger')}}" method="post">
                                                                                    {{csrf_field()}}
                                                                                    <input type="hidden" name="id" value="{{$users->id}}">
                                                                                    <label>Payment Status</label>
                                                                                    <select name="payment" class="form-control" required>
                                                                                        <option value="1">Paid</option>
                                                                                        <option value="0">Not Paid</option>
                                                                                    </select>
                                                                                    <br>
                                                                                    <label>Fasting Blood Glucose mg/dl</label>
                                                                                    <input type="number" step="0.01" name="bsvalue" class="form-control" required>
                                                                                    <br>
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    <input  type="submit" class="btn btn-primary" value="Submit">
                                                                                </form>
                                                                            </div>
                                                                            <div class="modal-footer">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal fade" id="slp{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 style="text-align: center" class="modal-title" id="exampleModalLabel">Serum Lipid Profile</h1>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div id="section-to-print" class="modal-body section-to-print">
                                                                                <form action="{{route('slp')}}" method="post">
                                                                                    {{csrf_field()}}
                                                                                    <input type="hidden" name="id" value="{{$users->id}}">
                                                                                    <label>Payment Status</label>
                                                                                    <select name="payment" class="form-control" required>
                                                                                        <option value="1">Paid</option>
                                                                                        <option value="0">Not Paid</option>
                                                                                    </select>
                                                                                    <br>
                                                                                    <label>Serum Creatinine mg/dl</label>
                                                                                    <input type="number" step="0.01" name="serum" class="form-control" required>
                                                                                    <br>
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    <input  type="submit" class="btn btn-primary" value="Submit">
                                                                                </form>
                                                                            </div>
                                                                            <div class="modal-footer">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal fade" id="lp{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 style="text-align: center" class="modal-title" id="exampleModalLabel">Lipid Profile</h1>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div id="section-to-print" class="modal-body section-to-print">
                                                                                <form action="{{route('lipid')}}" method="post">
                                                                                    {{csrf_field()}}
                                                                                    <label>Payment Status</label>
                                                                                    <select name="payment" class="form-control" required>
                                                                                        <option value="1">Paid</option>
                                                                                        <option value="2">Not Paid</option>
                                                                                    </select>
                                                                                    <br>
                                                                                    <input type="hidden" name='id' class="form-control" value="{{$users->id}}" required>
                                                                                    <label>Serum Cholestrol mg/dl</label>
                                                                                    <input type="number" name="serum" step="0.01" name="" class="form-control" required>
                                                                                    <br>
                                                                                    <label>Triglycerides mg/dl</label>
                                                                                    <input type="number" name="trigly" step="0.01" name="" class="form-control" required>
                                                                                    <br>

                                                                                    <label>HDL Cholestrol mg/dl</label>
                                                                                    <input type="number" name="hdl" step="0.01" name="" class="form-control" required>
                                                                                    <br>

                                                                                    <label>Vldl Cholestrol mg/dl</label>
                                                                                    <input type="number" name="vldl" step="0.01" name="" class="form-control" required>
                                                                                    <br>

                                                                                    <label>Choiesterol/HDL Ratio</label>
                                                                                    <input type="number" name="cholestrol" step="0.01" name="" class="form-control" required>
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                                                                                </form>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal fade" id="lf{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h1 style="text-align: center" class="modal-title" id="exampleModalLabel">Liver Function</h1>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div id="section-to-print" class="modal-body section-to-print">
                                                                                <form action="{{route('liver')}}" method="post">
                                                                                    {{csrf_field()}}
                                                                                    <label>Payment Status</label>
                                                                                    <select name="payment" class="form-control" required>
                                                                                        <option value="1">Paid</option>
                                                                                        <option value="2">Not Paid</option>
                                                                                    </select>
                                                                                    <br>
                                                                                    <input type="hidden" name='id' class="form-control" value="{{$users->id}}" required>
                                                                                    <label>Total Protein g/L</label>
                                                                                    <input type="number" name="totalProtein" step="0.01"class="form-control" required>
                                                                                    <br>
                                                                                    <label>Albumin g/L</label>
                                                                                    <input type="number" name="albumin" step="0.01"  class="form-control" required>
                                                                                    <br>

                                                                                    <label>Globulin g/L</label>
                                                                                    <input type="number" name="globulin" step="0.01" class="form-control" required>
                                                                                    <br>

                                                                                    <label>Alkaline phosphatase U/L</label>
                                                                                    <input type="number" name="alkaline" step="0.01" class="form-control" required>
                                                                                    <br>

                                                                                    <label>Total Bilirubin mol/L</label>
                                                                                    <input type="number" name="totalBilirubin" step="0.01" name="" class="form-control" required>
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                                                                                </form>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                @endforeach


                            </div>
                            <div class="tab-pane fade" id="viewReport" role="tabpanel" aria-labelledby="profile-tab">
                                <?php
                                $fbcad = DB::table('full_blood_counts')->leftjoin('users','users.id','full_blood_counts.userId')->select(['users.name','users.email','users.dob','users.gender','full_blood_counts.*'])->orderBy('full_blood_counts.id', 'DESC')->get();

                                ?>

                                <h1 style="text-align: center">Full Blood Count</h1>
                                <div class="row" style="height: 500px;overflow-y: scroll">
                                    @foreach($fbcad as $fad)
                                    <div class="panel-body" style="border: solid;border-radius: 25px;margin-bottom: 5px">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <img class="img-circle" src="{{asset('img/'.$fad->userId)}}" style="width: 60px;height: 60px;">
                                            </div>
                                            <div class="col-md-9">
                                                <p>Created : {{$fad->created_at}}</p>
                                                <p>Name : {{$fad->name}}</p>
                                                <p>Email : {{$fad->email}}</p>
                                                <p>
                                                    @if($fad->paymentStatus==1)
                                                        <label class="label label-success" style="font-size: 18px">Paid</label>
                                                    @else
                                                        <label class="label label-danger" style="font-size: 18px">Paid</label>
                                                    @endif
                                                </p>
                                                <p style="text-align: center">
                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#fbcad{{$fad->id}}">
                                                        View Report
                                                    </button>

                                                    <!-- Modal -->
                                                <div class="modal fade" id="fbcad{{$fad->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Full Blood Count</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div id="section-to-print" class="modal-body section-to-print">
                                                                <?php
                                                                $dob = $fad->dob;
                                                                $date = new DateTime($dob);
                                                                $now = new DateTime();
                                                                $interval = $now->diff($date);
                                                                ?>
                                                                <h3 style="text-align: center" class="text-primary">Medi Lab</h3>
                                                                <h5 style="text-align: center" >Full Blood Count</h5>
                                                                <h4 style="text-align:center ;">contact us 0717843564</h4>

                                                                Name   : {{$fad->name}}<br>
                                                                Age    : {{$interval->y}}<br>
                                                                Gender : {{$fad->gender}}

                                                                <table class="table borderless">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Test</th>
                                                                        <th>Result</th>
                                                                        <th>units</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>Neutrophils</td>
                                                                        <td>{{$fad->neutrophil}}</td>
                                                                        <td>mg/dl</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Lymphocytes</td>
                                                                        <td>{{$fad->lymphocytes}}</td>
                                                                        <td>mg/dl</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Monocytes</td>
                                                                        <td>{{$fad->monocytes}}</td>
                                                                        <td>mg/dl</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Haemoglobin</td>
                                                                        <td>{{$fad->hemoglobin}}</td>
                                                                        <td>mg/dl</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Red Blood Cells</td>
                                                                        <td>{{$fad->rbc}}</td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                </p>
                                            </div>
                                            <div class="col-md-2">
                                                <form action="{{route('delfbc')}}" method="post">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="id" value="{{$fad->id}}">
                                                    <input type="submit" value="delete" class="btn btn-danger btn-xs">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach


                                </div>

                                <h1 style="text-align: center">Blood Suger</h1>
                                <div class="row" style="height: 400px;overflow-y: scroll">

                                </div>

                                <h1 style="text-align: center">Serum Lipid Profile</h1>
                                <div class="row" style="height: 400px;overflow-y: scroll">

                                </div>

                                <h1 style="text-align: center">Lipid Profile</h1>
                                <div class="row" style="height: 400px;overflow-y: scroll">

                                </div>

                                <h1 style="text-align: center">Liver Function Test</h1>
                                <div class="row" style="height: 400px;overflow-y: scroll">

                                </div>
                                {{--<canvas id="myChart" width="350" height="350"></canvas>--}}
                            </div>
                            <div class="tab-pane fade" id="employee" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <button type="button" style="margin-bottom: 10px;" class="btn btn-primary" data-toggle="modal" data-target="#addml">
                                        Add MLT
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="addml" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add MLT</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" method="POST" action="{{ route('addMLT') }}">
                                                        {{ csrf_field() }}

                                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                            <label for="name" class="col-md-4 control-label">Name</label>

                                                            <div class="col-md-6">
                                                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                                                @if ($errors->has('name'))
                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                                            <div class="col-md-6">
                                                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                                                @if ($errors->has('email'))
                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                                            <label for="email" class="col-md-4 control-label">Gender</label>

                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label><input type="radio" name="gender" style="float: right" value="male" checked required>Male</label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label><input type="radio" name="gender" style="float: left" value="female" required>Female</label>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                                                            <label for="email" class="col-md-4 control-label">Date of Birth</label>
                                                            <div class="col-md-6">
                                                                <input type="date" name="dob"  class="form-control" value="{{ old('dob') }}" required>
                                                            </div>
                                                        </div>


                                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                            <label for="password" class="col-md-4 control-label">Password</label>

                                                            <div class="col-md-6">
                                                                <input id="password" type="password" class="form-control" name="password" required>

                                                                @if ($errors->has('password'))
                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" style="margin-bottom: 10px;" class="btn btn-primary" data-toggle="modal" data-target="#addemp">
                                        Add Employee
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="addemp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Add MLT</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="form-horizontal" method="POST" action="{{ route('addEmployee') }}">
                                                        {{ csrf_field() }}

                                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                            <label for="name" class="col-md-4 control-label">Name</label>

                                                            <div class="col-md-6">
                                                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                                                @if ($errors->has('name'))
                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                                            <div class="col-md-6">
                                                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                                                @if ($errors->has('email'))
                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                                            <label for="email" class="col-md-4 control-label">Gender</label>

                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label><input type="radio" name="gender" style="float: right" value="male" checked required>Male</label>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label><input type="radio" name="gender" style="float: left" value="female" required>Female</label>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                                                            <label for="email" class="col-md-4 control-label">Date of Birth</label>
                                                            <div class="col-md-6">
                                                                <input type="date" name="dob"  class="form-control" value="{{ old('dob') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email" class="col-md-4 control-label">Address</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="address"  class="form-control" value="{{ old('dob') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email" class="col-md-4 control-label">Contact No</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="cno"  class="form-control" value="{{ old('dob') }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email" class="col-md-4 control-label">Position</label>
                                                            <div class="col-md-6">
                                                                <input type="text" name="position"  class="form-control" value="{{ old('dob') }}" required>
                                                            </div>
                                                        </div>


                                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                            <label for="password" class="col-md-4 control-label">Salary</label>

                                                            <div class="col-md-6">
                                                                <input id="password" type="number" class="form-control" name="salary" required>

                                                                @if ($errors->has('password'))
                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @foreach($emp as $em)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="panel panel-success">
                                                <div style="text-align: center;font-size: 18px" class="panel-heading">Name {{$em->name}}  <br><label  class="label label-info">Position:{{$em->position}}</label></div>
                                                <div class="panel-body">
                                                    Email : {{$em->email}}<br>
                                                    Gender : {{$em->gender}}<br>
                                                    Date of birth :{{$em->dob}}<br>

                                                </div>
                                                <div class="panel-footer">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <form action="{{route('deleteEmployee')}}" method="post">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="eid" value="{{$em->id}}">
                                                                <input style="float: right" type="submit" class="btn btn-danger btn-xs" value="Delete">
                                                            </form>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="button" style="margin-left: 5px;float: left" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#emp{{$em->id}}">
                                                                Update
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="emp{{$em->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 style="text-align: center" class="modal-title" id="exampleModalLabel">Update Employee</h1>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form class="form-horizontal" method="POST" action="{{ route('updateEmployee') }}">
                                                                                {{ csrf_field() }}

                                                                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                                                    <label for="name" class="col-md-4 control-label">Name</label>

                                                                                    <div class="col-md-6">
                                                                                        <input id="name" type="text" class="form-control" name="name" value="{{ $em->name }}" required autofocus>


                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="eid" value="{{$em->id}}">

                                                                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                                                                    <div class="col-md-6">
                                                                                        <input id="email" type="email" class="form-control" name="email" value="{{$em->email }}" required>


                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                                                                    <label for="email" class="col-md-4 control-label">Gender</label>

                                                                                    <div class="row">
                                                                                        <div class="col-md-3">
                                                                                            <label><input type="radio" name="gender" style="float: right" value="male" required>Male</label>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <label><input type="radio" name="gender" style="float: left" value="female" required>Female</label>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                                <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                                                                                    <label for="email" class="col-md-4 control-label">Date of Birth</label>
                                                                                    <div class="col-md-6">
                                                                                        <input type="date" name="dob"  class="form-control" value="{{ $em->dob }}" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="email" class="col-md-4 control-label">Address</label>
                                                                                    <div class="col-md-6">
                                                                                        <input type="text" name="address"  class="form-control" value="{{ $em->address }}" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="email" class="col-md-4 control-label">Contact No</label>
                                                                                    <div class="col-md-6">
                                                                                        <input type="text" name="cno"  class="form-control" value="{{ $em->cno }}" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="email" class="col-md-4 control-label">Position</label>
                                                                                    <div class="col-md-6">
                                                                                        <input type="text" name="position"  class="form-control" value="{{ $em->position }}" required>
                                                                                    </div>
                                                                                </div>


                                                                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                                                    <label for="password" class="col-md-4 control-label">Salary</label>

                                                                                    <div class="col-md-6">
                                                                                        <input id="password" type="number" class="form-control" name="salary" value="{{$em->salary}}" required>


                                                                                    </div>
                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                                {{--<canvas id="myChart" width="350" height="350"></canvas>--}}
                            </div>

                            {{--tab of the smple handling--}}
                            <div class="tab-pane fade" id="sample" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <!-- Button trigger modal -->

                                    <button type="button" style="margin-bottom: 10px;" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        Sample Handling
                                    </button> <br>

                                    @foreach($sm as $s)
                                        <div class="panel-body" style="border: solid;margin-bottom: 5px">
                                            <p style="font-size: 18px"><label class="label label-primary">Sample ID  {{$s->sampleId}}</label>  <label class="label label-warning"> Date : {{$s->date}}</label></p>
                                            <form action="{{route('deleteSample')}}" method="post">
                                                {{csrf_field()}}
                                                <input type="hidden" name="sid"  value="{{$s->id}}">
                                                <input type="submit" value="Delete" class="btn btn-danger btn-xs">
                                            </form>

                                        </div>

                                    @endforeach

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('sample')}}" method="post">
                                                        {{csrf_field()}}
                                                        <label>Sample Number</label>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="sid" required>
                                                        </div>
                                                        <br>
                                                        <label>Transfer Date</label>
                                                        <div class="form-group">
                                                            <input type="date" class="form-control" name="sdate" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<canvas id="myChart" width="350" height="350"></canvas>--}}
                            </div>
                            <div class="tab-pane fade" id="stock" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    Stock management
                                </div>
                                {{--<canvas id="myChart" width="350" height="350"></canvas>--}}
                            </div>
                        </div>
                    </div>
                </div>

            @endif

    </div>

<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myList li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<script>
    var ctx = document.getElementById("myChart").getContext("2d");
    var lab =  <?php echo json_encode($suger); ?>;
    var dt = <?php echo json_encode($val); ?>;
    var chart = new Chart(ctx, {
        // The type of chart we want to create

        type: "line",

        // The data for our dataset
        data: {
            labels: lab,
            datasets: [
                {
                    label: "Suger Level",
                    borderColor: "rgb(255, 99, 132)",
                    data: dt
                }
            ]
        },

        // Configuration options go here
        options: {
            responsive:false,
            maintainAspectRatio: false
        }
    });
</script>
   <script>
       var ctx = document.getElementById("myChart1").getContext("2d");
       var lab = <?php echo json_encode($slps); ?>;
       var dt =<?php echo json_encode($sval); ?>;
       var chart = new Chart(ctx, {
           // The type of chart we want to create

           type: "line",

           // The data for our dataset
           data: {
               labels: lab,
               datasets: [
                   {
                       label: "Serum Lipid Profile",
                       borderColor: "rgb(255, 99, 132)",
                       data: dt
                   }
               ]
           },

           // Configuration options go here
           options: {
               responsive:false,
               maintainAspectRatio: false
           }
       });
   </script>
<script>
    $("#modalDiv").printThis({
        debug: false,
        importCSS: true,
        importStyle: true,
        printContainer: true,
        loadCSS: "../css/style.css",
        pageTitle: "My Modal",
        removeInline: false,
        printDelay: 333,
        header: null,
        formValues: true
    });
</script>


