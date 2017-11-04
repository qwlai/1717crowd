<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
							  
$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

$result = pg_query($db, "SELECT SQ.owner, SQ.title, SQ.description, SQ.amount_raised, SQ.amount_sought, SQ.percentage, SQ.timeleft
								FROM (SELECT PV.owner, PV.title, PV.description, PV.amount_sought, sum(FV.amount) as amount_raised, sum(FV.amount)/PV.amount_sought as percentage, (date(now()) - PV.end_date) as timeleft
									  FROM projectview PV, fundview FV
									  WHERE PV.owner=FV.owner AND PV.title=FV.title 
									  GROUP BY PV.owner, PV.title, PV.description, PV.amount_sought, PV.end_date
									  ORDER BY percentage desc) SQ
								WHERE SQ.percentage > 1");

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
		<h2> Most Successful Projects </h2>
		<div class="table-responsive">
			<table class="table " style="width:100%">
				<thead>
					<tr>
						<th style="width:10%">Owner </th>
						<th style="width:10%">Title </th>
						<th style="width:30%">Description </th>
						<th style="width:10%">Amount Raised</th>
						<th style="width:10%">Amount Sought</th>
						<th style="width:10%">Success Rate</th>
						<th>Days Left</th>
						
					</tr>
				</thead>
					<?php  
					while ($row = pg_fetch_array($result)) { 
						if ($row['timeleft'] < 0) {
							echo "<tr>";
						} else {
							echo "<tr bgcolor=#b1fbb1>";
						}
					?>
						<td><?php echo $row['owner']; ?></td>
						<td><?php echo $row['title']; ?></td>
						<td><?php echo $row['description']; ?></td>
						<td><?php echo $row['amount_raised']; ?>
						<td><?php echo $row['amount_sought']; ?>
						<td><?php echo round($row['percentage'],2)."%"?></td>
						<?php	if ($row['timeleft'] < 0) {
									echo "<td>".abs($row['timeleft'])." days left. </td>";
							    } else {
							    	echo "<td> Ended ".abs($row['timeleft'])." days ago.</td>"; 
							    }
						?>
					</tr>
					<?php } ?> 
			</table>
		</div>
	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>


