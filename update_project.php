<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
if(isset($_SESSION['user']))  { // Checking whether the session is already there or not 
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

	$user = $_SESSION['user'];
	$project_id = $_POST['submit'];
	
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
    	<h2> Update Project </h2>
    	
    	<?php while ($row = pg_fetch_array($result)) { ?>
		<form>
		  <div class="form-group">
		    <label for="title">Project Title</label>
		    <?php echo '<input class="form-control" id="title" value="'.$row['title'].'">' ?>
		  </div>
		  <div class="form-group">
		    <label for="description">Description</label>
		    <textarea class="form-control" id="description" rows="3"><?php echo $row['description']; ?></textarea>
		  </div>
		  <div class="form-group">
		    <label for="end">Start Date</label>
		    <?php echo '<input type="date" class="form-control" id="start" readonly="readonly" value="'.$row['start_date'].'">' ?>
		  </div>			  
		  <div class="form-group">
		    <label for="end">End Date</label>
		    <?php echo '<input type="date" class="form-control" id="end" value="'.$row['end_date'].'">' ?>
		  </div>	
		  <div class="form-group">
		    <label for="keywords">Keywords</label>
		    <?php echo '<input class="form-control" id="keywords" value="'.$row['keywords'].'">' ?>
		  </div>
		  <div class="form-group">
		    <label for="amount">Amount Sought</label><br>
		    <?php echo '<input type="number" style="text-align:center" min="0.00" max="100000000.00" step="1.0" minclass="form-control" id="amount" value="'.$row['amount_sought'].'">' ?>
		  </div>			  		  	  
		  <button type="submit" class="btn btn-primary">Submit</button>
		</form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

<?php 
	}

	} else { 
		header("Location: ./login.php");  
	}
?>
