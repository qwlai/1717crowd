<!DOCTYPE html>
<html>
<style>


input[type=text], input[type=password] {
    width: 30%;
    padding: 10px 10px;
    margin: 5px 0;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 30%;
}

button:hover {
    opacity: 0.8;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

.container {
    padding: 16px;
}

span.psw {
    padding-left: 200px;
	padding-top: 16px;
}


</style>
<body>

<?php  //Start the Session
$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");
$result = pg_query($query); 

session_start();
require('signup.php');
if (isset($_POST['username']) and isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM 'user' WHERE userID='$username' and password='$password'";
    $result = pg_query($query);

    if ($result == true){
        $_SESSION['username'] = $username;
    }else{
        echo "Invalid Login Credentials.";
    }
}

if (isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    echo "Hello " . $username;

?>

<h2>Login</h2>

<form action="login.php" method = "POST">

  <div class="container">
    <label><b>Username</b></label>
	<br>
    <input type="text" placeholder="Enter Username" name="uname" required>
	<br>
    <label><b>Password</b></label>
	<br>
    <input type="password" placeholder="Enter Password" name="psw" required>
    <br>    
    <button type="submit" formmethod = "POST" formaction="./index.php">Login</button>
	<a class="btn" href="./signup.php">Register </a>
  </div>

</form>

</body>
</html>