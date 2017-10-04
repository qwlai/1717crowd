<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
if(isset($_SESSION['user']))  { // Checking whether the session is already there or not 
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

	

	if (isset($_POST['submit'])) {
		$details = explode(',',$_POST['submit']);
		$owner = $details[0];
		$title = $details[1];
	}


	if (isset($_POST['update'])) {
		$amount = $_POST['amount'];
		$owner = $_POST['owner'];
		$title = $_POST['title'];
		$result = pg_query_params($db, 'SELECT add_fund($1,$2,$3,$4)', array($owner, $title, $_SESSION['user'], $amount));		
		$row = pg_fetch_array($result);
		if ($row[0] != null) {
			echo "<script> alert('Fund added!'); window.location = './search.php'; </script>";
		} else {
			echo "<script type=\"text/javascript\">"."alert('Transaction failed, Please try again!');"."</script>";
		}
	}
	
	$result = pg_query_params($db, 'SELECT * FROM projectview where owner = $1 and title = $2', array($_SESSION['user'], $title));?>

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
		    <?php echo '<input type="number" style="text-align:center" min="0.00" max="100000000.00" step="1.0" minclass="form-control" id="amount" name="amount" value="0">' ?>
		  </div>
		  <div class="form-group">
		  	<?php echo '<input type="hidden" name="title" value="'.$title.'"/>'?>
		  </div>
		  <div class="form-group">
		  	<?php echo '<input type="hidden" name="owner" value="'.$owner.'"/>'?>
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
