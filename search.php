<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

$search_field = $_POST['search'];
$search_owner = $_POST['owner'];
$search_start = $_POST['start'];
$search_end = $_POST['end'];

$results_per_page = 10;

if (isset($_GET["search"])) { 
	$str=$_GET["search"];
	$arr=explode("?owner=", $str,2); 
	$search_field = $arr[0];
	$str=$arr[1];

	$arr=explode("?start=", $str, 2);
	$search_owner=$arr[0];
	$str=$arr[1];;

	$arr=explode("?end=", $str, 2);
	$search_start=$arr[0];
	$str=$arr[1];

	$arr=explode("?page=", $str,2);
	$search_end=$arr[0];
	$page = $arr[1];
} else { 
	$page=1; 
}

$start_from = ($page-1) * $results_per_page;

if (!$search_start) {
	$search_start = '2010-01-01';
}

if (!$search_end) {
	$search_end = '2030-12-31';
}

if ($search_owner) {
	$result = pg_query_params($db, 'SELECT * FROM projectview WHERE (title ilike $1 OR keywords ilike $2) AND owner = $3 AND start_date >= $4 AND end_date <= $5 
		ORDER BY now() < start_date OR end_date < now(), end_date - now() ASC LIMIT $6 OFFSET $7', array("%".$search_field."%", "%".$search_field."%", $search_owner, $search_start, $search_end,
		$results_per_page, $start_from));
} else {
	$result = pg_query_params($db, 'SELECT * FROM projectview WHERE (title ilike $1 OR keywords ilike $2) AND start_date >= $3 AND end_date <= $4
		ORDER BY now() < start_date OR end_date < now(), end_date - now() ASC LIMIT $5 OFFSET $6', array("%".$search_field."%", "%".$search_field."%", $search_start, $search_end,
		 $results_per_page, $start_from));
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
		<h4>Colours legend:</h4>
		<div class="box" style="background-color:#e6e6e6"></div><p>Projects already ended</p>
		<div class="box" style="background-color:#cce6ff"></div><p>Projects that have yet to start</p>
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
							echo '<th>Fund</th>';
							if ($_SESSION['admin'] == 't') {
								echo '<th>Modify </th>';
								echo '<th>Delete</th>';
							}
						}?>
					</tr>
				</thead>
					<?php while ($row = pg_fetch_array($result)) { 
						$today = date('Y-m-d');
						if ($row['end_date'] <= $today) {
							echo '<tr bgcolor="#e6e6e6">';
						} else if ($row['start_date'] > $today) {
							echo '<tr bgcolor="#cce6ff">';
						} else {
							echo "<tr>";
						}
					?> 
					
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
							if (strtotime('tomorrow') >= strtotime($row['start_date']) && strtotime('today') < strtotime($row['end_date']) && $row['owner'] != $_SESSION['user']) {
									echo '<form action="./add_fund.php" method="post">';
										echo '<button class="btn btn-success btn-xs btn-block" type="submit" name="submit" value="'.$row['owner'].','.$row['title'].'">Fund</button>';
									echo '</form>';
							} else {
								if ($row['end_date'] <= $today) {
									echo 'Project Ended';
								} else if ($row['start_date'] > $today) {
									echo 'Future Project';
								} else if ($row['owner'] == $_SESSION['user']) {
									echo 'Own Project';
								}
							}
							echo '</td>';

							if ($_SESSION['admin'] == 't') {
								echo '<td>';
									echo '<form action="./update_project.php" method="post">';
										echo '<button class="btn btn-warning btn-xs btn-block" type="submit" name="submit" value="'.$row['title'].'">Update</button>';
										echo '<input type="hidden" name="owner" value="'.$row['owner'].'"/>';
									echo '</form>';
								echo '</td>';	
								echo '<td>';
									echo '<form action="./delete_project.php" method="post">';
										echo '<button class="btn btn-danger btn-xs btn-block" type="submit" name="submit" onclick="return confirmation('."'".$row['title']."'".')" value="'.$row['owner'].','.$row['title'].'">Delete</button>';
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

					if ($search_owner) {
						$result = pg_query_params($db, 'SELECT count(*) as total FROM projectview WHERE (title ilike $1 or keywords ilike $2) AND owner = $3 AND start_date >= $4 AND end_date <= $5', array("%".$search_field."%", "%".$search_field."%", $search_owner, $search_start, $search_end));
					} else {
						$result = pg_query_params($db, 'SELECT count(*) as total FROM projectview WHERE (title ilike $1 or keywords ilike $2) AND start_date >= $3 AND end_date <= $4', 
							array("%".$search_field."%", "%".$search_field."%",$search_start, $search_end));	
					}
					

					while ($row = pg_fetch_array($result)) {
						$total_pages = ceil($row['total'] / $results_per_page);
					}

					$current_page = $start_from/$results_per_page + 1; 
					$previous = $current_page - 1;
					$next = $current_page + 1;

					if ($current_page == 1) {	
						echo "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
					} else {
						echo "<li class='page-item'><a class='page-link' href='search.php?search=".$search_field."?owner=".$search_owner."?start=".$search_start."?end=".$search_end."?page=".$previous."'>Previous</a></li>";
					}


					for ($i=1; $i <= $total_pages; $i++) {
						if ($i == $current_page) {
							echo "<li class='page-item active'><span class='page-link'>".$i."<span class='sr-only'>(current)</span></span></li>";
						} else {
							echo "<li class='page-item'><a class='page-link' href='search.php?search=".$search_field."?owner=".$search_owner."?start=".$search_start."?end=".$search_end."?page=".$i."'>".$i."</a></li>";
						}
					}

					if ($current_page == $total_pages || $total_pages == 0) {	
						echo "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
					} else {
						echo "<li class='page-item'><a class='page-link' href='search.php?search=".$search_field."?owner=".$search_owner."?start=".$search_start."?end=".$search_end."?page=".$next."'>Next</a></li>";
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


