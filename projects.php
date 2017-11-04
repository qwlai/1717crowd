<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php

$results_per_page = 10;

if (isset($_GET["page"])) { 
	$page = $_GET["page"]; 
} else { 
	$page = 1; 
}

$start_from = ($page - 1) * $results_per_page;

if(isset($_SESSION['user']))  { // Checking whether the session is already there or not if 
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

	$user = $_SESSION['user'];
	
	$result = pg_query_params($db, 'SELECT * FROM projectview where owner = $1 ORDER BY start_date LIMIT $2 OFFSET $3', array($user, $results_per_page, $start_from));

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
		<h2> My Projects </h2>
		<div class="table-responsive">
			<table class="table" style="width:100%">
				<thead>
					<tr>
						<th style="width:10%">Title </th>
						<th style="width:30%">Description </th>
						<th style="width:8%">Start Date</th>
						<th style="width:8%">End Date</th>
						<th style="width:15%">Keywords</th>
						<th style="width:10%">Progress</th>
						<th style="width:9%">Update</th>
						<th style="width:10%">Close Project</th>
					</tr>
				</thead>
				
					<?php while ($row = pg_fetch_array($result)) { 
						$today = date('Y-m-d');
						if ($row['end_date'] <= $today) {
							echo '<tr bgcolor="#D3D3D3">';
						} else {
							echo "<tr>";
						}
					?>
						<td><?php echo $row['title']; ?></td>
						<td><?php echo $row['description']; ?></td>
						<td><?php echo $row['start_date']; ?></td>
						<td><?php echo $row['end_date']; ?></td>
						<td><?php echo $row['keywords']; ?></td>

						<td>
							<div class="progress">
									<?php  	$progress = pg_query_params($db, 'SELECT calculate_fund($1, $2)', array($_SESSION['user'], $row['title']));
									$amount = pg_fetch_array($progress);
									$amount_sought = $row['amount_sought'];

									$percentage = round($amount[0]/$amount_sought*100,2);

									if ($percentage >= 100) { ?>
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
						
						<td>
							<form action="/update_project.php" method="post">
								<?php echo '<button class="btn btn-warning btn-xs btn-block" type="submit" name="submit" value="'.$row['title'].'">Update</button>' ?>
							</form>
						</td>

						<td>
						<?php 
							if ($row['end_date'] <= $today) {
								echo "Project Ended";
							} else { ?>
								<form action="/close_project.php" method="post">
									<?php echo '<button class="btn btn-danger btn-xs btn-block" id="fire" type="submit" name="submit" onclick="return confirmation('."'".$row['title']."'".')" value="'.$row['title'].'">Close Project</button>' ?>		
								</form>	
							<?php } ?>					
						</td>
					</tr>	
					<?php } ?>
			</table>
		</div>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
				<?php 					
					$result = pg_query_params($db, 'SELECT count(*) as total FROM projectview where owner = $1', array($user));
						
					while ($row = pg_fetch_array($result)) {
						$total_pages = ceil($row['total'] / $results_per_page);
					}

					$current_page = $start_from/$results_per_page + 1; 
					$previous = $current_page - 1;
					$next = $current_page + 1;

					if ($current_page == 1) {	
						echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
					} else {
						echo "<li class='page-item'><a class='page-link' href='projects.php?page=".$previous."'>Previous</a></li>";
					}


					for ($i=1; $i <= $total_pages; $i++) {
						if ($i == $current_page) {
							echo "<li class='page-item active'><span class='page-link'>".$i."<span class='sr-only'>(current)</span></span></li>";
						} else {
							echo "<li class='page-item'><a class='page-link' href='projects.php?page=".$i."'>".$i."</a></li>";
						}
					}

					if ($current_page == $total_pages) {
						echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
					} else {
						echo "<li class='page-item'><a class='page-link' href='projects.php?page=".$next."'>Next</a></li>";
					}
				?>
			</ul>
		</nav>	
	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>

	<script>
    function confirmation(delName){
    	var del=confirm("Are you sure you want to delete "+delName+"?");
    return del;
	}
	</script>
</body>

</html>

<?php
	} else { 
		header("Location: ./login.php");  
	}
?>

