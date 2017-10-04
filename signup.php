<?php  

session_start();

if(isset($_SESSION['user']))   // Checking whether the session is already there or not if 
                              // true then header redirect it to the home page directly 
 {
    header("Location: ./index.php"); 
 }

$message="";

$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

if (isset($_POST['submit'])){
	$password = $_POST['password'];
	$password2 = $_POST['password-repeat'];
	
	if ($password != $password2) {
    	$message = "Oops! Password did not match! Try again.";
 	} else {
	    $email = $_POST['email'];
	    $name = $_POST['name'];
     	$password = password_hash($password2, PASSWORD_DEFAULT);

	    $result = pg_query_params($db, 'SELECT add_user($1, $2, $3)', array($email, $name, $password)); 
	    $row = pg_fetch_array($result);
	    $message = $row[0];
	}
 }
?>  
  

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CS2102</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
    <link rel="stylesheet" href="assets/css/Header-Dark.css">
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
	<?php include 'header.php' ?> 
    <div class="register-photo">
        <div class="form-container">
            <form method="post">
                <h2 class="text-center"><strong>Create</strong> an account.</h2>
                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input class="form-control" type="name" name="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password-repeat" placeholder="Password (repeat)">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit" name="submit">Sign Up</button>
                </div>
                <div class="message"><?php if(isset($message)) { echo $message; } ?></div>
            </form>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
