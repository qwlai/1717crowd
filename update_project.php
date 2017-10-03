<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
if(isset($_SESSION['user']))  { // Checking whether the session is already there or not 
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

	$oldtitle = "";

	if (isset($_POST['submit'])) {
		$oldtitle = $_POST['submit'];
	}


	if (isset($_POST['update'])) {
		$oldtitle = $_POST['oldtitle'];			
		$title = $_POST['title'];
		$description = $_POST['description'];
		$end = $_POST['end'];
		$keywords = $_POST['keywords'];
		$amount = $_POST['amount'];
		$result = pg_query_params($db, 'SELECT update_project($1,$2,$3,$4,$5,$6, $7)', array($_SESSION['user'], $oldtitle, $title, $description, $end, $keywords, $amount));		
		$row = pg_fetch_array($result);
		if ($row[0] == 1) {
			echo "<script type=\"text/javascript\">"."alert('Update Success!');"."</script>";
		} else {
			echo "<script type=\"text/javascript\">"."alert('Update failed, Please try again!');"."</script>";
		}
	}
	
	$result = pg_query_params($db, 'SELECT * FROM projectview where owner = $1 and title = $2', array($_SESSION['user'], $oldtitle));
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
    	<h2> Update Project </h2>
    	
    	<?php while ($row = pg_fetch_array($result)) { ?>
		<form method="post">
		  <div class="form-group">
		    <label for="title">Project Title</label>
		    <?php echo '<input class="form-control" id="title" name="title" value="'.$row['title'].'">' ?>
		  </div>
		  <div class="form-group">
		    <label for="description">Description</label>
		    <textarea class="form-control" id="description" name="description" rows="3"><?php echo $row['description']; ?></textarea>
		  </div>
		  <div class="form-group">
		    <label for="end">Start Date</label>
		    <?php echo '<input type="date" class="form-control" id="start" readonly="readonly" value="'.$row['start_date'].'">' ?>
		  </div>			  
		  <div class="form-group">
		    <label for="end">End Date</label>
		    <?php echo '<input type="date" class="form-control" id="end" name="end" value="'.$row['end_date'].'">' ?>
		  </div>	
		  <div class="form-group">
		    <label for="keywords">Keywords</label>
		    <?php echo '<input class="form-control" id="keywords" name="keywords" value="'.$row['keywords'].'">' ?>
		  </div>
		  <div class="form-group">
		    <label for="amount">Amount Sought</label><br>
		    <?php echo '<input type="number" style="text-align:center" min="0.00" max="100000000.00" step="1.0" minclass="form-control" id="amount" name="amount" value="'.$row['amount_sought'].'">' ?>
		  </div>	
		  <div class="form-group">
		  	<?php echo '<input type="hidden" name="oldtitle" value="'.$oldtitle.'"/>'?>
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
		header("Location: ./login.php");  
	}
?>
