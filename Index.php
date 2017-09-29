<?php
session_start();
require_once 'inc/dbconnect.php';

if(isset($_POST['btn-signup'])) {
	
 $email = strip_tags($_POST['email']);
 $uname = strip_tags($_POST['usrname']);
 $upass = strip_tags($_POST['psw']);
	
 $email = $DBcon->real_escape_string($email);
 $uname = $DBcon->real_escape_string($uname);
 $upass = $DBcon->real_escape_string($upass);
 
 $hashed_password = password_hash($upass, PASSWORD_DEFAULT); // this function works only in PHP 5.5 or latest version
 
 $check_email = $DBcon->query("SELECT email FROM websiteusers WHERE email='$email'");
 $count=$check_email->num_rows;
 
 if ($count==0) {
  
  $query = "INSERT INTO websiteusers(email,usr,password) VALUES('$email','$uname','$hashed_password')";

  if ($DBcon->query($query)) {
   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
     </div>";
  }else {
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
     </div>";
  }
  
 } else {
  
  
  $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; sorry email already taken !
    </div>";
   
 }
 
 $DBcon->close();
}
if (isset($_SESSION['userSession'])!="") {
 header("Location: home.php");
 exit;
}
require_once 'inc/dbconnect.php';
if (isset($_POST['btn-login'])) {
 
 $email = strip_tags($_POST['email']);
 $password = strip_tags($_POST['password']);
 
 $email = $DBcon->real_escape_string($email);
 $password = $DBcon->real_escape_string($password);
 
 $query = $DBcon->query("SELECT user_id, email, password FROM websiteusers WHERE email='$email'");
 $row=$query->fetch_array();
 
 $count = $query->num_rows; // if email/password are correct returns must be 1 row
 
 if (password_verify($password, $row['password']) && $count==1) {
  $_SESSION['userSession'] = $row['user_id'];
  header("Location: home.php");
 } else {
  $msg1 = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
	 <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
 }
 $DBcon->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/npm.js"></script>
  <style>
  .modal-header, h4{
      background-color: #03A5F4;
      color:white !important;
      text-align: center;
      font-size: 30px;
  }
	  .close {
		  background-color: #03A5F4;
		  color: black!important;
		  text-align: center;
		  font-size: 30px;
	  }  
  .modal-footer {
      background-color: #0074FF;
  }
	  body {
		  background-image:url(img/bg-1.jpg);
		  background-size: cover;
		  background-repeat: no-repeat;
	  }
  </style>
</head>
<body>

 <nav class="navbar navbar-inverse">
  <div class="control-label">
    <div class="navbar-fluid">
      <a class="navbar-brand" href="#">Lorem ipsum</a>
	  </div>
      <ul class="nav navbar-nav navbar-right">
      <li type="button" class="btn btn-link navbar-btn" id="signUp"><span class="glyphicon glyphicon-user"></span> Sign Up</li>
      <li type="button" class="btn btn-link navbar-btn" id="logIn"><span class="glyphicon glyphicon-log-in"></span> Login</li>
    </ul>
</div>
   </nav>
              <?php
  if(isset($msg)){
   echo $msg;
  }
  ?>
              <?php
  if(isset($msg1)){
   echo $msg1;
  }
			  ?>
    <form method="POST" role="form">
 
    <div class="modal fade" id="modal2" role="dialog">
    <div class="modal-dialog">
    <div class="modal-content">
    	<div class="modal-header" style="padding:35px 50px;">
    		<button type="button" class="close" name="signup" data-dismiss="modal">&times;</button>
    		<h4><span class="glyphicon glyphicon-user"></span> Sign-Up</h4>
		</div>
		<div class="modal-body" style="padding:40px 50px">
		
			<div class="form-group">
				<label for="email"><span class="glyphicon glyphicon-envelope"></span> Email</label>
				<input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" required>
			</div>
			<div class="form-group">
				<label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
				<input type="text" class="form-control" id="usrname" placeholder="Enter Username" name="usrname" required>
			</div>
			<div class="form-group">
				<label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
				<input type="password" class="form-control" id="psw" placeholder="Enter Password" name="psw" required>
			</div>
			              <button type="submit" class="btn btn-success btn-block" name="btn-signup" ><span class="glyphicon glyphicon-off"></span> Submit</button>
		</form>
			
		</div>
				<div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span> Cancel</button>
		</div>
		</div>
		</div>
</div>
  <div class="modal fade" id="modal1" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">

          <form method="POST" role="form">
            <div class="form-group">
              <label for="email"><span class="glyphicon glyphicon-envelope"></span> Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" checked>Remember me</label>
            </div>
              <button type="submit" class="btn btn-success btn-block" name="btn-login" id="btn-login"><span class="glyphicon glyphicon-off"></span> Login</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
          <p>Not a member? <a href="#">Sign Up</a></p>
          <p>Forgot <a href="#">Password?</a></p>
        </div>
      </div>
      
    </div>
  </div> 
</div>
  <div class="container-fluid">
  	
  </div>

<script>
$(document).ready(function(){
    $("#logIn").click(function(){
        $("#modal1").modal();
    });
	$("#signUp").click(function(){
		$("#modal2").modal();
	});
});
</script>

</body>
</html>
