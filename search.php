<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

$search_field = $_POST['search'];

$result = pg_query_params($db, 'SELECT * FROM projectview WHERE title ilike $1', array("%".$search_field."%"));

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
		<h2>Search Results for <?php echo '"'.$search_field.'"'; ?></h2>
		<div class="table-responsive">
			<table class="table" style="width:100%">
				<thead>
					<tr>
						<th style="width:10%">Owner </th>
						<th style="width:10%">Title </th>
						<th style="width:30%">Description </th>
						<th style="width:8%">Start Date</th>
						<th style="width:8%">End Date</th>
						<th style="width:15%">Keywords</th>
						<th style="width:10%">Progress</th>
						<?php if(isset($_SESSION['user']))  {
							echo '<th>Add Fund</th>';
						}?>
					</tr>
				</thead>
					<?php while ($row = pg_fetch_array($result)) { ?> 
					<tr>
						<td><?php echo $row['owner'] ?></td>
						<td><?php echo $row['title'] ?></td>
						<td><?php echo $row['description'] ?></td>
						<td><?php echo $row['start_date'] ?></td>
						<td><?php echo $row['end_date'] ?></td>
						<td><?php echo $row['keywords'] ?></td>

						<td>
							<div class="progress">
									<?php $progress = pg_query_params($db, 'SELECT calculate_fund($1, $2)', array($row['owner'], $row['title']));
									$amount = pg_fetch_array($progress);
									$amount_sought = $row['amount_sought'];
					
									$percentage = round($amount[0]/$amount_sought*100,2);
									
									if ($percentage > 100) { ?>
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
										<?php echo $amount[0]."/".$amount_sought; ?>
										</div>
									<?php } else { 
										echo '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="'.$percentage.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$percentage.'%">';
											echo '<span>'.$amount[0].'/'.$amount_sought.'</span>';
										echo '</div>';

										} ?>
								</div>
							</div>	
						</td>
						<?php if(isset($_SESSION['user']))  {
							echo '<td>';
								echo '<form action="./add_fund.php" method="post">';
									echo '<button class="btn btn-warning btn-xs btn-block" type="submit" name="submit" value="'.$row['owner'].','.$row['title'].'">Fund</button>';
								echo '</form>';
							echo '</td>';
						}?>
						<?php } ?>
					</tr>	
			</table>
		</div>
	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>