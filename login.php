<?php  

session_start();

if(isset($_SESSION['user']))   // Checking whether the session is already there or not if 
							  // true then header redirect it to the home page directly 
 {
	header("Location: ./index.php"); 
 }

$error="";

$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

if (isset($_POST['submit'])){
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$result = pg_query_params($db, 'SELECT password, is_admin FROM account WHERE email= $1', array($email)); 
	$row = pg_fetch_array($result);
	$verify = password_verify($password, $row[0]);

	if ($verify) {
		$_SESSION['user']=$email;
		$_SESSION['admin']=$row[1];
		header("Location: ./index.php");    
	}else{
		$error = "Username or Password is invalid!";
 }
		
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/fonts/ionicons.min.css">
	<link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
	<link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>

	<div class="login-dark">    
	<?php include 'header.php' ?>    
	<div class="login">
		<form method="post">
			<h2 class="sr-only">Login Form</h2>
			<div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
			<div class="form-group">
				<input class="form-control" type="email" name="email" placeholder="Email" />
			</div>
			<div class="form-group">
				<input class="form-control" type="password" name="password" placeholder="Password" />
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-block" type="submit" name="submit">Log In</button>
			</div>
			 <div class="error-message"><?php if(isset($error)) { echo $error; } ?></div>
	</div>
</form>
</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

