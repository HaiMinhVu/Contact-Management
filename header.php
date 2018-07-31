<?php
if(!isset($_SESSION['type'])){
	header('location:login.php');
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sellmark Product Development</title>
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>	
		<script type="text/javascript" src="js/selectize.js"></script>

		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/custom.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>


		<link href="js/selectize.default.css" media="screen" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/selectize.min.js"></script>

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}
function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
</head>
<body>
<div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="vendor.php"><i class="fa fa-university"></i> Vendors</a>
        <a href="project.php"><i class="fa fa-briefcase"></i></span> Projects</a>
        <a href="sample.php"><i class="fa fa-inbox"></i> Samples</a>
        <a href="contact.php"><i class="fa fa-user"></i> Contacts</a>
        <a href="#"><i class="fa fa-newspaper-o"></i> Reports</a>
</div>
<div class="container">
	<nav >
	<div class="container-fluid">
    <ul class="nav navbar-nav">
    <span>
    <button class="btn btn-info"><span style="font-size:20px;cursor:pointer" onclick="openNav()">&#9776</span></button>
    <a href="index.php"><img src='images/sellmarklogo.png' width=120dp height=40dp><a></span>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <div class="dropdown">
 			<button class="dropbtn"><?php echo $_SESSION["name"].' - '.$_SESSION['type']; ?></button>
  			<div class="dropdown-content">
    			<a href="logout.php">Logout</a>
  			</div>
		</div>
    </ul>
    </div>
	</nav>
	<h2 align="center" style="color:#006EC4">Product Development</h2>

			