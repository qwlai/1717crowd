<?php  

session_start();
$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

if (isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT * FROM account WHERE email= '$email' and password= '$password'";
    
    $result = pg_query($query); 
    $row = pg_fetch_array($result);
    echo $row[0];

    if(pg_num_rows($result) != 0) {
        header("Location: ./index.php");    
    }else{
		$_SESSION['error'] = "Username or Password is invalid";
 }
        
}
?>
