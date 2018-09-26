<html>
<head>
    <meta charset="utf-8"/>
    <title>Chart.js demo</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.min.js" type="text/javascript"></script>

</head>
<body>


<h1>Chart.js Sample</h1>

<canvas id="myChart" width="600" height="400"></canvas>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [{
                label: "My First dataset",
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [0, 10, 5, 2, 20, 30, 45],
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>
</body>
</html>

javascript html css chart.js
shareeditflag
asked Jun 17 '17 at 20:35
amanda45
12011
add a comment
1 Answer
active
oldest
votes
up vote
2
down vote
accepted

You're using version 0.2.0. Works fine if you use the version in the demo (2.4.0) or the newest version (2.6.0). The CDN link for that is https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js

<html>

<head>
    <meta charset="utf-8" />
    <title>Chart.js demo</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
</head>
<body>

<h1>Chart.js Sample</h1>

<canvas id="myChart" width="600" height="400"></canvas>
<script>
    var ctx = document.getElementById("myChart").getContext("2d");
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: "line",

        // The data for our dataset
        data: {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
                {
                    label: "My First dataset",
                    backgroundColor: "rgb(255, 99, 132)",
                    borderColor: "rgb(255, 99, 132)",
                    data: [0, 10, 5, 2, 20, 30, 45]
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
</body>
</html>