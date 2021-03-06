<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CS2102</title>
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700">
	<link rel="stylesheet" href="assets/css/styles.css">	
</head>

<body>
	<div>
		<div class="header-dark" style="padding:0px;">
			<nav class="navbar navbar-default navigation-clean-search">
				<div class="container">

					<div class="navbar-header"><a class="navbar-brand navbar-link" href="index.php">Home </a>
						<button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
					</div>		

					<form class="navbar-form navbar-left submit_on_enter" method="post" action="search.php">
						<div class="input-group add-on">
							<input class="form-control search-field" type="search" name="search" placeholder="Search Project by Title/Keyword" id="search-field">

							<div class="input-group-btn">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
									<div class="dropdown-menu dropdown-menu-left">
										<label> Filter By: </label>
										<br/>

										<label style="margin-right:38px;">Owner:</label>
										<div class="form-group">
											<input type="text" class="form-control" name="owner" placeholder="Owner's Email">
										</div>
											
										<br/>
										<label style="margin-right:15px;">Start Date:</label>
										<div class="form-group">
											<input type="date" class="form-control" value="2010-01-01" name="start">
										</div>
											
										<br/>
										<label style="margin-right:21px;">End Date:</label>
										<div class="form-group">
											<input type="date" class="form-control" value="2030-12-31" name="end">
										</div>
										<br>
									</div>
								<button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
							</div>
						</div>
					</form>     


					<?php if (!isset($_SESSION['user'])) { ?> 
						<div class="navbar-right">
							 <a class="navbar-link login" href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a> 
							 <a class="navbar-link login" href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
						</div>
					<?php } else { ?>
						<div class="navbar-right">
							<span class="navbar-text user"></span><span class="glyphicon glyphicon-user"></span><?php echo " ".$_SESSION['user']; ?> 
							<a class="navbar-link login" href="projects.php"><span class="glyphicon glyphicon-list-alt"></span> My Projects</a>    
							<a class="navbar-link login" href="view_project.php"><span class="glyphicon glyphicon-star"></span> My Contributions</a>  				  
							<a class="navbar-link login" href="add_project.php"><span class="glyphicon glyphicon-plus"></span> Add Project</a>                                
							<a class="navbar-link login" href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a> 							
						</div>
					<?php } ?>
				</div>
			</nav>
		</div>
	</div>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function () {
			$('.dropdown-toggle').dropdown();
		});
	</script>
</body>

</html>