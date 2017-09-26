<?php   session_start();  ?>
<?php include 'header.php'  ?>  

<?php
$db = pg_connect("host=188.166.229.13 port=5455 dbname=crowdfunding user=postgres password=210217huhu");

$search_field = $_POST['search'];

$result = pg_query_params($db, 'SELECT * FROM projectview WHERE title ilike $1', array("%".$search_field."%"));

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
<table width=100% border="1">
<tr>
<td><b>Advertiser</b></td> <td><b>title</b></td><td><b>description</b></td> <td><b>start_date</b></td> <td><b>end_date</b></td> <td><b>keywords</b></td> <td><b>amount sought</b></td>
</tr>
<?php while ($row = pg_fetch_array($result)) { ?> 
<tr>
	<td><?php echo $row['advertiser'] ?></td>
	<td><?php echo $row['title'] ?></td>
	<td><?php echo $row['description'] ?></td>
	<td><?php echo $row['start_date'] ?></td>
	<td><?php echo $row['end_date'] ?></td>
	<td><?php echo $row['keywords'] ?></td>
	<td><?php echo $row['amount_sought'] ?></td>
</tr>	
<?php } ?>

</table>
</body>
</html>
