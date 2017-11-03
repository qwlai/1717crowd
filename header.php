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
<<<<<<< HEAD
    <div>
        <div class="header-dark" style="padding:0px;">
            <nav class="navbar navbar-default navigation-clean-search">
                <div class="container">
                    <div class="navbar-header"><a class="navbar-brand navbar-link" href="index.php">Home </a>
					<a class="navbar-brand navbar-link" href="view_project.php">View Project</a>
                        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                    </div>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <form class="navbar-form navbar-left" target="_self" method="post" action="search.php">
                            <div class="form-group">
                                <label class="control-label" for="search-field"><i class="glyphicon glyphicon-search"></i></label>
                                <input class="form-control search-field" type="search" name="search" placeholder="Search Project" id="search-field">
                            </div>
                        </form>
             
                        <?php if (!isset($_SESSION['user'])) { ?> 
                            <p class="navbar-text navbar-right">
                                <a class="navbar-link login" href="login.php">Log In</a> 
                                <a class="btn btn-default action-button" role="button" href="signup.php">Sign Up</a>
                            </p>
                        <?php } else { ?>
                            <p class="navbar-text navbar-right">

                                <label class="email"><?php echo $_SESSION['user']; ?> </label>
                                <a class="btn btn-default action-button" role="button" href="add_project.php">Add Project</a> 
                                <a class="btn btn-default action-button" role="button" href="logout.php">Logout</a>
                            </p>
                        <?php } ?>
                    </div>
=======
	<div>
		<div class="header-dark" style="padding:0px;">
			<nav class="navbar navbar-default navigation-clean-search">
				<div class="container">
					<div class="navbar-header"><a class="navbar-brand navbar-link" href="index.php">Home </a>
						<button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
					</div>

					<form class="navbar-form navbar-left" target="_self" method="post" action="search.php">
						 <div class="form-group">
							<label class="control-label" for="search-field"><i class="glyphicon glyphicon-search"></i></label>
							 <input class="form-control search-field" type="search" name="search" placeholder="Search Project" id="search-field">
						</div>
					</form>     
>>>>>>> 4289e9695f78f94e57e26c2ef6a550b7f134997a

					<?php if (!isset($_SESSION['user'])) { ?> 
						<div class="navbar-right">
							 <a class="navbar-link login" href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a> 
							 <a class="navbar-link login" href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a>
						</div>
					<?php } else { ?>
						<div class="navbar-right">
							<span class="navbar-text user"></span><span class="glyphicon glyphicon-user"></span><?php echo " ".$_SESSION['user']; ?> 
							<a class="navbar-link login" href="projects.php"><span class="glyphicon glyphicon-list-alt"></span> My Projects</a>      
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
</body>

</html>