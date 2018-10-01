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

   <!------ Include the above in your HEAD tag ---------->

    <div class="container emp-profile">

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
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                            {{Auth::user()->name}}
                        </h5>

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#report" role="tab" aria-controls="home" aria-selected="true">Reports</a>
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
                        <span class="glyphicon-envelope"> {{Auth::user()->email}}</span>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade active in" id="report" role="tabpanel" aria-labelledby="home-tab">
                            <div class="panel-body" style="border:solid; border-radius: 25px">
                            <div class="row">
                                <div class="col-md-6">

                                        <p>Your report of the date 2015/02/4</p>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form action="{{route('reportPayment')}}" method="post">
                                                {{csrf_field()}}
                                                <input type="hidden" name="amount" value="1">
                                                <input type="submit" style="float: right" class="btn btn-warning" value="pay">
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                                                View Report
                                            </button>

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
                                                        <div id="section-to-print" class="modal-body section-to-print">
                                                            hu dkla

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
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
                                <input class="form-control" id="myInput" type="text" placeholder="Search..">
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
                                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#sc{{$users->id}}">
                                                        + serum Creatanin
                                                    </button>
                                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#lf{{$users->id}}">
                                                        + Liver function Test
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="fbc{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div id="section-to-print" class="modal-body section-to-print">
                                                                    hu dkla

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="bs{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
                                                                    <label>Fasting Blood Glucose mg/dl</label>
                                                                    <input type="number" step="0.01" name="" class="form-control" required>
                                                                    <br>
                                                                </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
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
                                                    <div class="modal fade" id="sc{{$users->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div id="section-to-print" class="modal-body section-to-print">
                                                                    hu dkla

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
                                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div id="section-to-print" class="modal-body section-to-print">
                                                                    hu dkla

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
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
    var lab = [1,2,3,4,5] ;
    var dt =[135,88,100,110,95] ;
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
       var lab = [1,2,3,4,5] ;
       var dt =[135,88,100,110,95] ;
       var chart = new Chart(ctx, {
           // The type of chart we want to create

           type: "line",

           // The data for our dataset
           data: {
               labels: lab,
               datasets: [
                   {
                       label: "Suger Level",
                       borderColor: "#000",
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


