<!DOCTYPE html>
<html>
<head>
    <title>Economy Booking</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <style>
        .backButton {
            text-align: center
        }
    </style>
</head>
<body>
<?php
//Variables
    $firstName = $lastName = $email = "";
    $fieldErr = "";
    $submitFirstName = $submitLastName = $submitEmail = "";
    $rowcount = "";
    $seatsRemaining = "";
    $bookSuccess = "";
    
//Form verification code
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstName = test_input($_POST["firstName"]);
        $lastName = test_input($_POST["lastName"]);
        $email = test_input($_POST["email"]);
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["firstName"])) {
            $fieldErr = true;
            } else {
            $firstName = test_input($_POST["firstName"]);
        }

        if (empty($_POST["lastName"])) {
            $fieldErr = true;
        } else {
            $lastName = test_input($_POST["lastName"]);
        }

        if (empty($_POST["email"])) {
            $fieldErr = true;
        } else {
            $email = test_input($_POST["email"]);
        }
    }
    
//Verify every field is filled before submitting
    if (!empty($firstName)) {
        if (!empty($lastName)) {
            if (!empty($email)) {  
                submitToDatabase($firstName, $lastName, $email);
                $firstName = $lastName = $email = "";
            }
        }
    }
    
    //Submit to database function
    function submitToDatabase($submitFirstName, $submitLastName, $submitEmail) {
        $servername = "";
        $username = "";
        $password = "";
        $dbname = "";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "INSERT INTO Discounted (firstname, lastname, email)
        VALUES ('$submitFirstName', '$submitLastName', '$submitEmail')";

        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            echo '<div class="alert alert-success">Booking Success! Refrence ID: <strong>D';
            echo $last_id;
            echo '</strong></div>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    
    //Checks for the number of tickets in the Discounted database
    $con=mysqli_connect("localhost:8889","root","root","bookings");
    // Check connection
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $sql="SELECT firstName FROM Discounted";

    if ($result=mysqli_query($con,$sql)) {
      // Return the number of rows in result set
      $rowcount=mysqli_num_rows($result);
//      printf("Result set has %d rows.\n",$rowcount);
      // Free result set
      mysqli_free_result($result);
      }

    mysqli_close($con);
?>
<div class="container">
    <div class="jumbotron">
        <h1>Book Discounted Tickets</h1>
        <p>Please fill in the following information to reserve a seat:</p>
        <?php 
        $seatsRemaining = 20 - $rowcount;
        //Count seats remaining
        echo '<p>';
        if ($seatsRemaining > 0) {
            echo $seatsRemaining ;
        } else {
            echo "0";
        }
        echo ' seats remaining</p>';
        
        //Notify user if there is an unfilled box
        if ($fieldErr === true) {
            echo '<div class="alert alert-danger">All fields are required!</div>';
            $fieldErr = "";
        } 
        
        //Alert user this category is full
        if ($rowcount >= 20) {
            echo '<div class="alert alert-danger">This category is full. You may not be promised a seat.</div>';
        }
        ?>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" value="<?php echo $firstName;?>" id="firstName" class="form-control">
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" value="<?php echo $lastName;?>" id="lastName" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo $email;?>" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Ticket price: $300 HKD</label>
            </div>
            <input type="submit" class="btn btn-info">
        </form>
        <br>
        <div class="backButton">
            <button onclick="goBack()" class="btn btn-danger">Cancel</button>
        </div>
    </div>
</div>
