<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
if(isset($_SESSION['user']))  { // Checking whether the session is already there or not 
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

	

	if (isset($_POST['submit'])) {
		$details = explode(',',$_POST['submit']);
		$owner = $details[0];
		$title = $details[1];
		echo $owner;
		echo $title;
	}


	if (isset($_POST['update'])) {
		$owner = $_POST['owner'];			
		$title = $_POST['title'];
		$investor = $_POST['investor'];
		$amount = $_POST['amount'];
		$result = pg_query_params($db, 'SELECT add_fund($1,$2,$3,$4)', array($owner, $title, $investor, $amount));		
		$row = pg_fetch_array($result);
		if ($row[0] == 1) {
			echo "<script type=\"text/javascript\">"."alert('Update Success!');"."</script>";
		} else {
			echo "<script type=\"text/javascript\">"."alert('Update failed, Please try again!');"."</script>";
		}
	}
	
	$result = pg_query_params($db, 'SELECT * FROM projectview where project_id = $1', array("$project_id"));
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <div class="container">
    	<h2> Add Fund </h2>
    	
    	<?php while ($row = pg_fetch_array($result)) { ?>
		<form method="post">
		  <div class="form-group">
		    <label for="title">Project Title</label>
		    <?php echo '<input class="form-control" id="title" name="title" value="'.$row['title'].'">' ?>
		  </div>
		  <div class="form-group">
		    <label for="amount">Amount of fund to add:</label><br>
		    <?php echo '<input type="number" style="text-align:center" min="0.00" max="100000000.00" step="1.0" minclass="form-control" id="amount" name="amount" value="'.$row['amount_sought'].'">' ?>
		  </div>			  		  	  
		  <button type="submit" name="update" class="btn btn-primary">Submit</button>
		</form>
		<?php }?>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

<?php
	} else { 
		header("Location: ./add_fund.php");  
	}
?>
