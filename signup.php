<?php 
define('DB_HOST', 'localhost'); 
define('DB_NAME', 'website'); 
define('DB_USER','root'); 
define('DB_PASSWORD',''); 
$con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die("Failed to connect to MySQL: " . mysqli_error($con)); 
$db=mysqli_select_db($con,DB_NAME) or die("Failed to connect to MySQL: " . mysqli_error($db)); function NewUser() { $email = $_POST['email']; $userName = $_POST['usr']; $password = $_POST['psw']; $password1 = $_POST['psw1']; 
$query = "INSERT INTO websiteusers (email,usr,psw,psw1) VALUES ('$email','$userName','$password','$password1')"; 
$data = mysqli_query ($query)or die(mysqli_error($data)); 
if($data) { echo "YOUR REGISTRATION IS COMPLETED..."; } } function SignUp() { if(!empty($_POST['user'])) //checking the 'user' name which is from Sign-Up.html, is it empty or have some text 
{ $query = mysqli_query("SELECT * FROM websiteusers WHERE userName = '$_POST[usr]' AND pass = '$_POST[psw]'") or die(mysqli_error($query)); if(!$row = mysqli_fetch_array($query) or die(mysqli_error($query))) { newuser(); } else { echo "SORRY...YOU ARE ALREADY REGISTERED USER..."; } } } if(isset($_POST['submit'])) { SignUp(); } 
?>
