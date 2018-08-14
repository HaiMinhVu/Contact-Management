<?php
include('dbconnect.php');

if(isset($_SESSION['type'])){
	header('location:index.php');
}

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
	$message="";
    if(isset($_POST['login'])){
       // trim input
        $username = test_input($_POST['username']);
        $password = test_input($_POST['password']);

       // verify username and password
<<<<<<< HEAD
        $loginsql = "SELECT * FROM PD_DB_Account sma JOIN PD_Employee sme ON sme.SMEmID = sma.SMEmID WHERE username = '$username'";
=======
        $loginsql = "SELECT * FROM SMDBAccounts sma JOIN SMEmployees sme ON sme.SMEmID = sma.SMEmID WHERE username = '$username'";
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
        $resultloginsql = $dbconnect->query($loginsql);
        $row_count = mysqli_num_rows($resultloginsql);

        if($row_count == 1){
        	$row = $resultloginsql->fetch_assoc();
            if($row['AcctStatus'] == "Active"){
            	if(strcmp($password, $row['password']) == 0){
                    $_SESSION['type'] = $row['AcctType'];
                    $_SESSION['acct_id'] = $row['AcctID'];
                    $_SESSION['username'] = $row['username'];
                	$_SESSION['name'] = $row['SMEmName'];
                    header('location:index.php');
                }
                else{
                    $message = "Wrong Password";
                   }
            }
            	else{
                $message = "Account is Disabled";
               }
        }
        else{
            $message = "Wrong Username";
        }
	}   
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Sellmark Factory Management</title>	
		<!--
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
<<<<<<< HEAD
		-->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<div id="wrapper" style="width:100%; text-align:center; margin-top:10%">
=======

		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<div id="wrapper" style="width:100%; text-align:center">
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
			<img src='images/sellmarklogo.png'>
		</div>
		<h2 align="center" style="color:#052A95">Product Development</h2>
	</head>
	<style>
	.login-form {
    margin: auto;
    width: 60%;
	background: #f2f2f2;
    padding: 10px;
	}
<<<<<<< HEAD

=======
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
	</style>

	<body>
		<div style="width:30%; text-align:center" class="login-form" style="margin-top: 60px">
		<div class="logincontainer" >
				<div class="panel-body">
					<form method="post" >
						<?php echo $message; ?>
							<div style="padding-left: 30px;padding-right: 30px;" class="form-group input-group">
            					<span style="background-image: linear-gradient(to bottom, #fff 0%, #e3e3e3 100%);" class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            					<input type="text" name="username" class="form-control" id="inputEmail" placeholder="Enter username" autofocus="">
        					</div>
							<div style="padding-left: 30px;padding-right: 30px;" class="form-group  input-group">
            					<span style="background-image: linear-gradient(to bottom, #fff 0%, #e3e3e3 100%);" class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            					<input type="password" name="password" class="form-control" id="inputPassword" placeholder="Nhập mật khẩu">
        					</div>
							<input type="submit" name="login" value="Login" class="btn btn-primary" />
                        	
					</form>
				</div>
		</div>
	</body>
                      
</html>