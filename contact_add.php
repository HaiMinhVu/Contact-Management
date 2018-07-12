<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>
<span id="alert_action"></span>
<form method="POST" id="vender_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Add New Contact</h3>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
            	<div class="row" align="right">
            		<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='contact.php'">Back</button>   					
            	</div>
            </div>
			<table id="add_contact" class="table table-bordered table-striped">
				<tr>
					<td width=20%>Name</td>
					<td><input type="text" name="ecname" id="ecname" class="form-control" required /></td>
				</tr>
				<tr>
					<td width=20%>Email</td>
					<td><input type="email" name="ecemail" id="ecemail" class="form-control" required /></td>
				</tr>
            	<tr>
					<td width=20%>Phone</td>
					<td><input type="text" name="ecphone" id="ecphone" class="form-control" required /></td>
				</tr>
            	<tr>
					<td width=20%>Fax</td>
					<td><input type="text" name="ecfax" id="ecfax" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Website</td>
					<td><input type="text" name="ecwebsite" id="ecwebsite" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Address 1</td>
					<td><input type="text" name="ecaddress1" id="ecaddress1" class="form-control" required /></td>
				</tr>
            	<tr>
					<td width=20%>Address 2</td>
					<td><input type="text" name="ecaddress2" id="ecaddress2" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>City</td>
					<td><input type="text" name="eccity" id="eccity" class="form-control" required /></td>
				</tr>
            	<tr>
					<td width=20%>State</td>
					<td><input type="text" name="ecstate" id="ecstate" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Zipcode</td>
					<td><input type="text" name="eczip" id="eczip" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Country</td>
					<td><input type="text" name="eccountry" id="eccountry" class="form-control" required /></td>
				</tr>
            	<tr>
					<td >Status</td>
            		<td><select name="status" id="status" class="form-control" >
                    	<option value="">Select Status</option>
                    	<option value="Active" selected>Active</option>
                        <option value="InActive">InActive</option>
                    </select></td>
				</tr>
			</table>
            <input type="submit" name="Add" id="Add" class="btn btn-info" value="Add" />
            <input type="reset" name="reset" id="reset" class="btn btn-warning" value="Reset" />

		</div>
	</div>
</div>
</form>
<?php
if(isset($_POST['Add'])){
	$ecname = $_POST['ecname'];
	$ecemail = $_POST['ecemail'];
	$ecphone = $_POST['ecphone'];
	$ecfax = $_POST['ecfax'];
	$ecwebsite = $_POST['ecwebsite'];
	$ecaddress1 = $_POST['ecaddress1'];
	$ecaddress2 = $_POST['ecaddress2'];
	$eccity = $_POST['eccity'];
	$ecstate = $_POST['ecstate'];
	$eczip = $_POST['eczip'];
	$ecstatus = $_POST['status'];
	$eccountry = $_POST['eccountry'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	
	$sql = "INSERT INTO Entity_Contact VALUES(null, '$ecname', '$ecemail', '$ecphone', '$ecfax', '$ecwebsite', '$ecaddress1', '$ecaddress2', '$eccity', '$ecstate', '$eczip', '$eccountry', $modify_by, '$modify_date', $modify_by, '$ecstatus')";
    if($dbconnect->query($sql) === TRUE){
		echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">New Contact Added</div>';
       			 </script>";
	}
    else{
        echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-danger"'.">Query Failed: ".$sql."</div>';
       			 </script>";
    }
}     
?>
<script>
$('#select-country').selectize();
</script>
<?php
include ('footer.php');
?>