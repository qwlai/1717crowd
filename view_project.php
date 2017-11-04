<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
if(isset($_SESSION['user']))  {
	
	$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");
	$results_per_page = 10;

	if (isset($_GET["page"])) { 
		$page = $_GET["page"]; 
	} else { 
		$page=1; 
	}
	$user = $_SESSION['user'];

	$start_from = ($page-1) * $results_per_page;

	$result = pg_query_params($db, 'SELECT PV.owner, PV.title, PV.description, PV.start_date, PV.end_date, PV.keywords, PV.amount_sought 
	FROM projectview PV, fundview FV 
	WHERE PV.title = FV.title AND FV.investor = $1 
	group by PV.owner, PV.title, PV.description, PV.start_date, PV.end_date, PV.keywords, PV.amount_sought LIMIT $2 OFFSET $3' , array($user,$results_per_page,$start_from));

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
		<h2>View Projects Funded</h2>
		<div class="table-responsive">
			<table class="table table-striped" style="width:100%">
				<thead>
					<tr>
						<th style="width:10%">Owner </th>
						<th style="width:10%">Title </th>
						<th style="width:30%">Description </th>
						<th style="width:8%">Start Date</th>
						<th style="width:8%">End Date</th>
						<th style="width:10%">Keywords</th>
						<th style="width:10%">Progress</th>
						<th style="width:12%">My Contributions</th>
						<?php if(isset($_SESSION['user']))  {
							echo '<th>Fund</th>';
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
						<?php 
							$contributions = pg_query_params($db, 'select sum(amount) AS contributions_list from fundview where investor = $1 and title = $2 and owner = $3',array($user,$row['title'], $row['owner']));
							$output = pg_fetch_array($contributions);
							echo '<td style="text-align:center;">' . $output['contributions_list'] . '</td>';
						?>
						
						<?php if(isset($_SESSION['user']))  {
							if (strtotime('tomorrow') >= strtotime($row['start_date']) && strtotime('today') < strtotime($row['end_date'])) {
							echo '<td>';
								echo '<form action="./add_fund.php" method="post">';
									echo '<input type="hidden" value="test" name="f" />';
									echo '<button class="btn btn-warning btn-xs btn-block" type="submit" name="submit" value="'.$row['owner'].','.$row['title'].'">Fund</button>';
								echo '</form>';
							echo '</td>';
							}
						}?>
						<?php } ?>
						
					</tr>	
			</table>
		</div>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
				<?php 					
					$result = pg_query_params($db, 'SELECT count(*) as total FROM (SELECT PV.owner, PV.title, PV.description, PV.start_date, PV.end_date, PV.keywords, PV.amount_sought 
													FROM projectview PV, fundview FV 
													WHERE PV.title = FV.title AND FV.investor = $1 
													group by PV.owner, PV.title, PV.description, PV.start_date, PV.end_date, PV.keywords, PV.amount_sought) src' , array($user));
					while ($row = pg_fetch_array($result)) {
						$total_pages = ceil($row['total'] / $results_per_page);
					}

					$current_page = $start_from/$results_per_page + 1; 
					$previous = $current_page - 1;
					$next = $current_page + 1;

					if ($current_page == 1) {	
						echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
					} else {
						echo "<li class='page-item'><a class='page-link' href='view_project.php?page=".$previous."'>Previous</a></li>";
					}


					for ($i=1; $i <= $total_pages; $i++) {
						if ($i == $current_page) {
							echo "<li class='page-item active'><span class='page-link'>".$i."<span class='sr-only'>(current)</span></span></li>";
						} else {
							echo "<li class='page-item'><a class='page-link' href='view_project.php?page=".$i."'>".$i."</a></li>";
						}
					}

					if ($current_page == $total_pages || $total_pages == 0) {	
						echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
					} else {
						echo "<li class='page-item'><a class='page-link' href='view_project.php?page=".$next."'>Next</a></li>";
					}
				?>
			</ul>
		</nav>			
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