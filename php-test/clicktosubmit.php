<!DOCTYPE html>
<html>
<body>

<h1>Click to submit</h1>

<?php
$servername = "";
$username = "";
$password = "";
$dbname = "";

if (isset($_GET['run'])) {
    submit();
}

function submit() {
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
        VALUES ('John', 'Smith', 'john@example.com')";
        
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
//            echo "New record created successfully. Last inserted ID is: " . $last_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
}
?>    
    
<!--
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Given Name: <input type="text" name="firstName" value="John" readonly>
    <span class="error">* <?php echo $firstNameErr;?></span><br>
    Family Name: <input type="text" name="lastName" value="Smith" readonly>
    <span class="error">* <?php echo $lastNameErr;?></span><br>
    E-mail: <input type="email" name="email" value="johnsmith@example.com" readonly>
    <span class="error">* <?php echo $emailErr;?></span><br>
    <input type="submit">
</form>
-->
    
<a href='clicktosubmit.php?run=true'>Run PHP Function</a>
    
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