<?php
session_start();
require_once 'inc/dbconnect.php';
if (isset($_POST['btn-login'])) {
 
 $admin_id = strip_tags($_POST['admin_id']);	
 $work_id = strip_tags($_POST['work_id']);
 $password = strip_tags($_POST['password']);
 
 $admin_id = $DBcon->real_escape_string($admin_id);
 $work_id = $DBcon->real_escape_string($work_id);
 $password = $DBcon->real_escape_string($password);
 
 $query = $DBcon->query("SELECT admin_id, work_id, password FROM admin WHERE work_id='$work_id'");
 $row=$query->fetch_array();
 
 $count = $query->num_rows; // if email/password are correct returns must be 1 row
 
 if (password_verify($password, $row['password']) && $count==1) {
  $_SESSION['userSession'] = $row['admin_id'];
  header("Location: admin.php");
 } else {
  $msg1 = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Work ID or Password !
	 <button type='button' class='close' data-dismiss='alert'>&times;</button>
    </div>";
 }
 $DBcon->close();
}
?>
<!DOCTYPE html>
<html>
	<title></title>
	<head>
		
	</head>
	<body>
		
	</body>
</html>