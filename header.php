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
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
<<<<<<< HEAD
    document.getElementById("divMenu").style.width = "250px";
}
function closeNav() {
    document.getElementById("divMenu").style.width = "0";
}
</script>
<style>
@import url(//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css);
}
@import url(https://fonts.googleapis.com/css?family=Titillium+Web:300);
.fa-2x {
font-size: 2em;
}
.fa {
position: relative;
display: table-cell;
width: 60px;
height: 36px;
text-align: center;
vertical-align: middle;
font-size:20px;
}


.main-menu:hover,nav.main-menu.expanded {
width:250px;
overflow:visible;
}

.main-menu {
background:#005FA4;
border-right:1px solid #e5e5e5;
position:fixed;
top:0;
bottom:0;
height:100%;
left:0;
width:60px;
overflow:hidden;
-webkit-transition:width .05s linear;
transition:width .05s linear;
-webkit-transform:translateZ(0) scale(1,1);
z-index:1000;
}

.main-menu>ul {
margin:7px 0;
}

.main-menu li {
position:relative;
display:block;
width:250px;
}

.main-menu li>a {
position:relative;
display:table;
border-collapse:collapse;
border-spacing:0;
color:white;
 font-family: arial;
font-size: 14px;
text-decoration:none;
-webkit-transform:translateZ(0) scale(1,1);
-webkit-transition:all .1s linear;
transition:all .1s linear;
  
}

.main-menu .nav-icon {
position:relative;
display:table-cell;
width:60px;
height:36px;
text-align:center;
vertical-align:middle;
font-size:18px;
}

.main-menu .nav-text {
position:relative;
display:table-cell;
vertical-align:middle;
width:190px;
  font-family: 'Titillium Web', sans-serif;
}

.main-menu>ul.logout {
position:absolute;
left:0;
bottom:0;
}

.no-touch .scrollable.hover {
overflow-y:hidden;
}

.no-touch .scrollable.hover:hover {
overflow-y:auto;
overflow:visible;
}

a:hover,a:focus {
text-decoration:none;
}

nav {
-webkit-user-select:none;
-moz-user-select:none;
-ms-user-select:none;
-o-user-select:none;
user-select:none;
}

nav ul,nav li {
outline:0;
margin:0;
padding:0;
}
.main-menu li:hover>a,nav.main-menu li.active>a,.dropdown-menu>li>a:hover,.dropdown-menu>li>a:focus,.dropdown-menu>.active>a,.dropdown-menu>.active>a:hover,.dropdown-menu>.active>a:focus,.no-touch .dashboard-page nav.dashboard-menu ul li:hover a,.dashboard-page nav.dashboard-menu ul li.active a {
color:#fff;
background-color:#5fa2db;
}

@font-face {
  font-family: 'Titillium Web';
  font-style: normal;
  font-weight: 300;
  src: local('Titillium WebLight'), local('TitilliumWeb-Light'), url(http://themes.googleusercontent.com/static/fonts/titilliumweb/v2/anMUvcNT0H1YN4FII8wpr24bNCNEoFTpS2BTjF6FB5E.woff) format('woff');
}

</style>

</head>
<body>
		<nav class="main-menu">
            <ul>
                <li><a href="index.php"><i class="fa fa-home fa-2x"></i><span class="nav-text">Dashboard</span></a></li>
                <li><a href="vendor.php"><i class="fa fa-building"></i><span class="nav-text">Vendors</span></a></li>
                <li><a href="project.php"><i class="fa fa-briefcase"></i><span class="nav-text">Projects</span></a></li>
                <li><a href="sample.php"><i class="fa fa-inbox"></i><span class="nav-text">Samples</span></a></li>
                <li><a href="samplerecord.php"><i class="fa fa-ticket"></i><span class="nav-text">Request Records</span></a></li>
                <li><a href="vendorcontact.php"><i class="fa fa-user"></i><span class="nav-text">Contacts</span></a></li>
            </ul>
        </nav>
<div class="container" >
	
	<div class="container-fluid" >
    <ul class="nav navbar-nav">
    
    
    <a href="index.php"><img src='images/sellmarklogo.png' width=120dp height=40dp><a>
=======
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
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
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
<<<<<<< HEAD

=======
	</nav>
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
	<h2 align="center" style="color:#006EC4">Product Development</h2>

			