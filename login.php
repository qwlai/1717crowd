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



<h2>Login</h2>

<form action="login.php" method = "POST">

  <div class="container">
    <label><b>Username</b></label>
	<br>
    <input type="text" placeholder="Enter Username" name="uname" required>
	<br>
    <label><b>Password</b></label>
	<br>
    <input type="password" placeholder="Enter Password" name="pass" required>
    <br>    
    <button type="submit" formmethod = "POST" name = "submit">Login</button>
	<a class="btn" href="./signup.php">Register </a>
  </div>

</form>

</body>
</html>

<?php  //Start the Session
$error ="";
$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");


if (isset($_POST['submit'])){
    $username = $_POST['uname'];
    $password = $_POST['pass'];
    //$query = "SELECT * FROM 'account' WHERE email='$username' and password='$password'";
	$query = "SELECT * FROM account WHERE email= '$username' and password='$password'";
	
	$result = pg_query($db, $query);
	
	if(pg_num_rows($result) != 0) {
		header('Location: ./index.php');    
	}else{
		echo "Wrong Username or Password!";
	}
		
}
?>
