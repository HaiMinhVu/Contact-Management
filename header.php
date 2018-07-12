<?php
if(!isset($_SESSION['type'])){
	header('location:login.php');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Database System</title>
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>	
		<script type="text/javascript" src="js/selectize.js"></script>

		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>


		<link href="js/selectize.default.css" media="screen" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/selectize.min.js"></script>
</style>
	</head>
	<body>
		<br />
		<div class="container">
			<h2 align="center">Database Management</h2>

			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a href="index.php" class="navbar-brand">Home</a>
					</div>
					<ul class="nav navbar-nav">
					<?php
					if(($_SESSION['type'] == 'Admin') || ($_SESSION['type'] == 'Manager'))
					{
					?>
                    	<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span>SellMark</a>
							<ul class="dropdown-menu">
								<li><a href="brand.php">Brand</a></li>
								<li><a href="category.php">Category</a></li>
                    			<li><a href="product.php">Product</a></li>
							</ul>
						</li>
						
					<?php
					}
					?>
                    	<li class="dropdown">
							<a href="vender.php" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span>Vendor</a>
							<ul class="dropdown-menu">
								<li><a href="vendor.php">View Vendor</a></li>
								<li><a href="vendorcontact.php">Vendor Related Contact</a></li>
                    			<li><a href="contact.php">All Contact</a></li>
							</ul>
						</li>
                    	<li><a href="project.php">Project</a></li>
                    	<li class="dropdown">
							<a href="vender.php" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span>Sample</a>
							<ul class="dropdown-menu">
								<li><a href="sample.php">View Sample</a></li>
								<li><a href="samplerecord.php">Request Records</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> <?php echo $_SESSION["username"]; ?></a>
							<ul class="dropdown-menu">
								<li><a href="logout.php">Logout</a></li>
							</ul>
						</li>
					</ul>

				</div>
			</nav>
			