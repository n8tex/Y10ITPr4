<!DOCTYPE HTML>
<head>
    <title>Ticketing Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        function reload() {
            location.reload();
        }
    </script>
    <style>
        .container {
            text-align: center;
        }
    </style>
</head>
<body>
<?php
    $econSeats = 20;
    $standardSeats = 30;
    $vipSeats = 15;
    
    //Checks for the amount of Discounted Tickets sold
    $con=mysqli_connect("","","","");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $sql="SELECT firstName FROM Discounted";

    if ($result=mysqli_query($con,$sql)) {
      // Return the number of rows in result set
      $econSold=mysqli_num_rows($result);
      // Free result set
      mysqli_free_result($result);
      }

    mysqli_close($con);
    
    //Checks for the amount of Standard Tickets sold
    $con=mysqli_connect("","","","");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $sql="SELECT firstName FROM Standard";

    if ($result=mysqli_query($con,$sql)) {
      // Return the number of rows in result set
      $standardSold=mysqli_num_rows($result);
      // Free result set
      mysqli_free_result($result);
      }

    mysqli_close($con);
    
    //Checks for the amount of VIP Tickets sold
    $con=mysqli_connect("","","","");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $sql="SELECT firstName FROM VIP";

    if ($result=mysqli_query($con,$sql)) {
      // Return the number of rows in result set
      $vipSold=mysqli_num_rows($result);
      // Free result set
      mysqli_free_result($result);
      }

    mysqli_close($con);
    
    $econRemaining = $econSeats - $econSold;
    $standardRemaining = $standardSeats - $standardSold;
    $vipRemaining = $vipSeats - $vipSold;
    
    //Ensure negetive numbers aren't shown
    if ($econSold >= $econSeats) {
        $econRemaining = 0;
    }
    
    if ($standardSold >= $standardSeats) {
        $standardRemaining = 0;
    }
    
    if ($vipSold >= $vipSeats) {
        $vipRemaining  = 0;
    }
    
    //Caulculates the total amount of seats remaining
    $totalRemaining = $econRemaining + $standardRemaining + $vipRemaining;
?>
    
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="jumbotron">
                <h1>Discounted</h1> 
                <p><?php echo $econRemaining; ?> Remaining</p>
                <a href="http://localhost:8888/concert/ticketing/econ/" class="btn btn-info" role="button" target="_parent">Order Now</a>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="jumbotron">
                <h1>Standard</h1> 
                <p><?php echo $standardRemaining; ?> Remaining</p> 
                <a href="http://localhost:8888/concert/ticketing/standard/" class="btn btn-info" role="button" target="_parent">Order Now</a>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="jumbotron">
                <h1>VIP</h1> 
                <p><?php echo $vipRemaining; ?> Remaining</p> 
                <a href="http://localhost:8888/concert/ticketing/vip/" class="btn btn-info" role="button" target="_parent">Order Now</a>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="jumbotron">
                <h1>Total</h1> 
                <p><?php echo $totalRemaining; ?> Remaining</p> 
                <button onclick="reload()" class="btn btn-primary">Refresh</button>
            </div>
        </div>
    </div>
</div>
</body>