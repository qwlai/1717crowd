<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
if(isset($_SESSION['user']))  { // Checking whether the session is already there or not if 
							  
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

	$user = $_SESSION['user'];
	
?>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
	<div class="container">
	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

<?php } ?>
