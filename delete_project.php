<?php   session_start(); 
 
if(isset($_SESSION['user']))  { // Checking whether the session is already there or not 
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");
	if (isset($_POST['submit'])) {
		$details = explode(',',$_POST['submit']);
		$owner = $details[0];
		$title = $details[1];
		$result = pg_query_params($db, 'DELETE FROM project WHERE  title = $1 AND owner = $2', array($title, $owner));
		header("Location: ./search.php");  

	}
} else {
	header("Location: ./login.php");  
}
?>