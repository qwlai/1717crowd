<!DOCTYPE html>
<head>
<title>Sign up form</title>
<link rel = "stylesheet"
   type = "text/css"
   href = "styles/style.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
li {listt-style: none;}
</style>
</head>
<body>
<h2>Enter user informationz</h2>
<ul>
<form name="insert" action="signup.php" method="POST" >
<li>Email:</li><li><input type="text" name="email" /></li>
<li>Name:</li><li><input type="text" name="name" /></li>
<li>Password:</li><li><input type="text" name="pass" /></li>
<li>Verify Password:</li><li><input type="text" name="vpass" /></li>
<li><input name="submit" type="submit" /></li>
</form>
</ul>
</body>
</html>
<?php
$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");
if(isset($_POST['submit'])) {
	$query = "SELECT add_user('$_POST[email]','$_POST[name]', crypt('$_POST[pass]', gen_salt('bf', 8)))";
	//$query = "INSERT INTO account VALUES ('$_POST[email]','$_POST[name]', crypt('$_POST[pass]', gen_salt('bf', 8)))";
	$result = pg_query($query); 
	$row = pg_fetch_array($result);
	echo $row[0];
}
?>
