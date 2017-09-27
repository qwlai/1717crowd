<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
if(isset($_SESSION['user']))  { // Checking whether the session is already there or not if 
                              
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

	$user = $_SESSION['user'];
	
	$result = pg_query_params($db, 'SELECT * FROM projectview where advertiser = $1', array("$user"));

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
    	<h2> My Projects </h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                    	<th style="display:none;">ProjectID</th>
                        <th>Owner </th>
                        <th>Title </th>
                        <th>Description </th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Keywords</th>
                        <th>Progress</th>
                        <th>Update Project</th>
                    </tr>
                </thead>
                
					<?php while ($row = pg_fetch_array($result)) { 
					?> 
					<tr>
						<td style="display:none;"><?php $project_id = $row['project_id']; echo $project_id; ?></td>
						<td><?php echo $row['advertiser'] ?></td>
						<td><?php echo $row['title'] ?></td>
						<td><?php echo $row['description'] ?></td>
						<td><?php echo $row['start_date'] ?></td>
						<td><?php echo $row['end_date'] ?></td>
						<td><?php echo $row['keywords'] ?></td>

						<td>
							<div class="progress">
									<?php  	$progress = pg_query_params($db, 'SELECT calculate_fund($1)', array($project_id));
								   	$amount = pg_fetch_array($progress);
								   	$amount_sought = $row['amount_sought'];

								   	$percentage = round($amount[0]/$amount_sought*100,2);

								   	if ($percentage >= 100) { ?>
  										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
  										<?php echo $amount[0]."/".$amount_sought; ?>
  										</div>
								   	<?php } else {
								  		
								   		echo '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$percentage.'%">';
								   		  	echo $amount[0]."/".$amount_sought;
  										echo '</div>';

								   		} ?>
  								</div>
							</div>	
						</td>
						
						<td>
							<form action="/update_project.php" method="post">
								<button class="btn btn-warning btn-xs btn-block" type="submit" name="submit">Update</button>
							</form>
						</td>
					</tr>	
					<?php } ?>
            </table>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>

<?php } ?>