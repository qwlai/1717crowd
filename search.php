<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

$search_field = $_POST['search'];

$results_per_page = 10;

if (isset($_GET["search"])) { 
	$search_field=$_GET["search"]; 
	$arr=explode("?page=", $search_field,2); 
	$search_field = $arr[0];
	$page = $arr[1];
} else { 
	$page=1; 
}

$start_from = ($page-1) * $results_per_page;

$result = pg_query_params($db, 'SELECT * FROM projectview WHERE title ilike $1 or keywords ilike $2 LIMIT $3 OFFSET $4', array("%".$search_field."%", "%".$search_field."%", $results_per_page, $start_from));

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
		<h2>Search Results for <?php echo '"'.$search_field.'"'; ?></h2>
		<div class="table-responsive">
			<table class="table table-striped" style="width:100%">
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
							echo '<th>Fund</th>';
							if ($_SESSION['admin'] == 't') {
								echo '<th>Modify </th>';
								echo '<th>Delete</th>';
							}
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

							if (strtotime('tomorrow') >= strtotime($row['start_date']) && strtotime('today') < strtotime($row['end_date'])) {
								echo '<td>';
									echo '<form action="./add_fund.php" method="post">';
										echo '<button class="btn btn-success btn-xs btn-block" type="submit" name="submit" value="'.$row['owner'].','.$row['title'].'">Fund</button>';
									echo '</form>';
								echo '</td>';
							} else {
								echo '<td></td>';
							}

							if ($_SESSION['admin'] == 't') {
								echo '<td>';
									echo '<form action="./update_project.php" method="post">';
										echo '<button class="btn btn-warning btn-xs btn-block" type="submit" name="submit" value="'.$row['title'].'">Update</button>';
										echo '<input type="hidden" name="owner" value="'.$row['owner'].'"/>';
									echo '</form>';
								echo '</td>';	
								echo '<td>';
									echo '<form action="./update_project.php" method="post">';
										echo '<button class="btn btn-danger btn-xs btn-block" type="submit" name="submit" value="'.$row['title'].'">Delete</button>';
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
					$result = pg_query_params($db, 'SELECT count(*) as total FROM projectview WHERE title ilike $1 or keywords ilike $2', array("%".$search_field."%", "%".$search_field."%"));
						
					while ($row = pg_fetch_array($result)) {
						$total_pages = ceil($row['total'] / $results_per_page);
					}

					$current_page = $start_from/$results_per_page + 1; 
					$previous = $current_page - 1;
					$next = $current_page + 1;

					if ($current_page == 1) {	
						echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
					} else {
						echo "<li class='page-item'><a class='page-link' href='search.php?search=".$search_field."?page=".$previous."'>Previous</a></li>";
					}


					for ($i=1; $i <= $total_pages; $i++) {
						if ($i == $current_page) {
							echo "<li class='page-item active'><span class='page-link'>".$i."<span class='sr-only'>(current)</span></span></li>";
						} else {
							echo "<li class='page-item'><a class='page-link' href='search.php?search=".$search_field."?page=".$i."'>".$i."</a></li>";
						}
					}

					if ($current_page == $total_pages || $total_pages == 0) {	
						echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
					} else {
						echo "<li class='page-item'><a class='page-link' href='search.php?search=".$search_field."?page=".$next."'>Next</a></li>";
					}
				?>
			</ul>
		</nav>			
	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>


</body>

</html>


