<!DOCTYPE html>
<html>
<head>
//This project was my first attempt at PHP forms.    
</head>
<body>

<h1>My first PHP page</h1>
<h2>Concert Ticket Prices:</h2>

<?php
    define("vipPrice", 1500, false);
    define("midPrice", 1000, false);
    define("ecoPrice", 500, false);
    echo "VIP: ";
    echo vipPrice;
    echo "</br>";
    echo "Mid: ";
    echo midPrice;
    echo "</br>";
    echo "Economy: ";
    echo ecoPrice
?>
<?php
// define variables and set to empty values
$name = $email = $gender = $comment = $website = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = test_input($_POST["username"]);
  $email = test_input($_POST["email"]);
  $website = test_input($_POST["website"]);
  $password = test_input($_POST["password"]);
  $gender = test_input($_POST["gender"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
<h1>Purchase Tickets</h1>
<p>Please log in to continue:</p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
Username: <input type="username" name="username"><br>
Password: <input type="text" name="password"><br>
<input type="submit">
</form>

<br>    
    
<?php
    echo "Username:<br>";
    echo $username;
    echo "<br>";
    echo "Password:<br>";
    echo $password;
    echo "<br>";
?>
    

</body>
</html>