<!DOCTYPE html>
<html>
<head>
    //This was my first attempt at making the form look better. The final version is a lot tidier than this.
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://bootswatch.com/paper/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<?php
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

// sql to create table
$sql = "CREATE TABLE VIP (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
firstName VARCHAR(30) NOT NULL,
lastName VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table VIP created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
    
<!--Form handling-->
<?php
    // define variables and set to empty values
    $firstName = $lastName = $email = "";

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
?>
    
<?php
    // define variables and set to empty values
    $fieldErr = "";
    $firstName = $lastName = $email = "";

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
?>
    
<?php
    //define new vars
    $submitFirstName = $submitLastName = $submitEmail = "";
    
    if (!empty($firstName)) {
        if (!empty($lastName)) {
            if (!empty($email)) {  
                submitToDatabase($firstName, $lastName, $email);
                $firstName = $lastName = $email = "";
            }
        }
    }
?>
        
<?php
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

        $sql = "INSERT INTO VIP (firstname, lastname, email)
        VALUES ('$submitFirstName', '$submitLastName', '$submitEmail')";

        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            echo "New record created successfully. Last inserted ID is: " . $last_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
?>    

<div class="container">
  <div class="jumbotron">
    <h1>Book Tickets - VIP</h1>      
    <p>Please fill in the following:</p>
        <?php if ($fieldErr === true) {
            echo '<div class="alert alert-danger">All fields are required!</div>';
        } else {
            echo '<div class="alert alert-success">Success! Your booking ID is null.</div>';
        } ?>
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
    <input type="submit" class="btn btn-info">
</form>
  </div>    
</div>
<?php
echo "<h2>Your Input:</h2>";
echo $firstName;
echo "<br>";
echo $lastName;
echo "<br>";
echo $email;
echo "<br>";
?>
</body>
</html>