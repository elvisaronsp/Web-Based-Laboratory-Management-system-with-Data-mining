@extends('layouts.app')
<head>
    <meta charset="utf-8" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
</head>
@section('content')
   <!------ Include the above in your HEAD tag ---------->

    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS52y5aInsxSm31CvHOFHWujqUx_wWTS9iM6s7BAm21oEN_RiGoog" style="height: 200px" alt=""/>
                        <div class="file btn btn-lg btn-primary">
                            Change Photo
                            <input type="file" name="file"/>
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
                    <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
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
                            <div class="panel-body" style="border-radius: 25px">
                                <p>Your report of the date 2015/02/4</p>
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
        </form>
    </div>

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

