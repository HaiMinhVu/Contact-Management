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
        $loginsql = "SELECT * FROM SMDBAccounts WHERE username = '$username'";
        $resultloginsql = $dbconnect->query($loginsql);
        $row_count = mysqli_num_rows($resultloginsql);

        if($row_count == 1){
        	$row = $resultloginsql->fetch_assoc();
            if($row['AcctStatus'] == "Active"){
            	if(strcmp($password, $row['password']) == 0){
                    $_SESSION['type'] = $row['AcctType'];
                    $_SESSION['acct_id'] = $row['AcctID'];
                    $_SESSION['username'] = $row['username'];
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
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<h2 align="center">Sellmark Factory Management</h2>
			<br />
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					<form method="post">
						<?php echo $message; ?>
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="username" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="password" class="form-control" required />
						</div>
						<div class="form-group">
							<input type="submit" name="login" value="Login" class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>