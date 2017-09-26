<?php  

session_start();
    
$error="";
$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

if (isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM account WHERE email= '$email' and password= '$password'";
    
    $result = pg_query_params($query); 
    $row = pg_fetch_array($result);
    echo $row[0];

    if(pg_num_rows($result) != 0) {
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

</form>
</div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

