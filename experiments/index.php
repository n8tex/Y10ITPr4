<!DOCTYPE html>
<html>
<body>

<h1>Writing Database Experiment</h1>

<?php
$servername = "";
$username = "root";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE blank (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
firstName VARCHAR(30) NOT NULL,
lastName VARCHAR(30) NOT NULL,
email VARCHAR(50),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully";
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
    $firstNameErr = $lastNameErr = $emailErr = "";
    $firstName = $lastName = $email = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST[""])) {
        $firstNameErr = "Given name is required."
      } else {
        $firstName = test_input($_POST["firstName"]);
      }
        
    if (empty($_POST[""])) {
        $lastNameErr = "Family name is required.";
      } else {
        $lastName = test_input($_POST["lastName"]);
      }
        
    if (empty($_POST[""])) {
        $emailErr = "Email is required";
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
//                $firstName = $lastName = $email = "";
            }
        }
    }
?>
        
<?php
    function submitToDatabase($submitFirstName, $submitLastName, $submitEmail) {
        $servername = "";
        $username = "root";
        $password = "";
        $dbname = "";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "INSERT INTO blank (firstname, lastname, email)
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
    
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Given Name: <input type="text" name="firstName" value="<?php echo $firstName;?>">
    <span class="error">* <?php echo $firstNameErr;?></span><br>
    Family Name: <input type="text" name="lastName" value="<?php echo $lastName;?>">
    <span class="error">* <?php echo $lastNameErr;?></span><br>
    E-mail: <input type="email" name="email" value="<?php echo $email;?>">
    <span class="error">* <?php echo $emailErr;?></span><br>
    <input type="submit">
</form>
    
<?php
echo "<h2>Your Input: (Debug)</h2>";
echo $firstName;
echo "<br>";
echo $lastName;
echo "<br>";
echo $email;
echo "<br>";
?>
</body>
</html>