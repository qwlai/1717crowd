<?php   session_start(); 
 
if(isset($_SESSION['user']))  { // Checking whether the session is already there or not 
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");
	if (isset($_POST['submit'])) {
		$title = $_POST['submit'];
		$today = date('Y-m-d');
		$result = pg_query_params($db, 'UPDATE project SET end_date = $1 WHERE title = $2 AND owner = $3', array($today, $title, $_SESSION['user']));
		header("Location: ./projects.php");  

	}
} else {
	header("Location: ./login.php");  
}
?>