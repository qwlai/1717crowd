<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
if(isset($_SESSION['user']))  { // Checking whether the session is already there or not 
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");
	
	if (isset($_POST['submit'])) {
		$title = $_POST['title'];
		$description = $_POST['description'];
		$start_date = $_POST['start'];
		$end_date = $_POST['end'];
		$keywords = $_POST['keywords'];
		$amount_sought = $_POST['amount'];
	
	
		if ($title == '') {
			$message = "Project title cannot be empty!";
		} else {
			$result = pg_query_params($db, 'SELECT add_project($1,$2,$3,$4,$5,$6,$7)', array($_SESSION['user'], $title, $description, $start_date, $end_date,$keywords,$amount_sought)); 
			$row = pg_fetch_array($result);
			if ($row[0] != null) {
			echo "<script> alert('Project added!'); window.location = './index.php'; </script>";
			} else {
				echo "<script type=\"text/javascript\">"."alert('Error adding project');"."</script>";
			}
		}
	}
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
    	<h2> Add new Project </h2>
		<form method="post">
		  <div class="form-group">
		    <label for="title">Project Title</label>
		    <input class="form-control" id="title" name="title" placeholder ="Name">
		  </div>
		  <div class="form-group">
		    <label for="description">Description</label>
		    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
		  </div>
		  <div class="form-group">
		    <label for="start">Start Date</label>
		    <input type="date" class="form-control" id="start" name ="start">
		  </div>			  
		  <div class="form-group">
		    <label for="end">End Date</label>
		    <input type="date" class="form-control" id="end" name="end">
		  </div>	
		  <div class="form-group">
		    <label for="keywords">Keywords</label>
		  <input class="form-control" id="keywords" name="keywords">
		  </div>
		  <div class="form-group">
		    <label for="amount">Amount Sought</label><br>
		    <input type="number" style="text-align:center" min="0.00" max="100000000.00" step="1.0" minclass="form-control" id="amount" name="amount">
		  </div>		  	  
		  <button type="submit" name="submit" class="btn btn-primary">Create new Project</button>
		   <div class="message">
		    <?php if(isset($message)) { 
					echo $message; 
				} 
			?>
		   </div>
		</form>
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
