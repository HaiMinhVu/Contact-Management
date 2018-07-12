<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$ecid =$_GET['ecid'];
$status;

?>
<span id="alert_action"></span>
<form method="POST" id="vender_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">

			<?php
            $sql = "SELECT * FROM Entity_Contact ec INNER JOIN SMDBAccounts sma ON sma.AcctID = ec.ECEnterBy WHERE ec.ECID = $ecid";
			$ecfetch = $dbconnect->query($sql);
			while($row = $ecfetch->fetch_array()){
            	$status = $row['ECStatus'];
            	
            ?>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Contact Update</h3>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
            	<div class="row" align="right">
            		<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='contact.php'">Back</button>   					
            	</div>
            </div>
			<table id="contact_data" class="table table-bordered table-striped">
				<tr>
					<td width=20%>Name</td>
					<td><input type="text" name="ecname" id="ecname" value="<?php echo $row['ECName'];?>" class="form-control" required /></td>
				</tr>
				<tr>
					<td width=20%>Email</td>
					<td><input type="text" name="ecemail" id="ecemail" value="<?php echo $row['ECEmail'];?>" class="form-control" required /></td>
				</tr>
            	<tr>
					<td width=20%>Phone</td>
					<td><input type="text" name="ecphone" id="ecphone" value="<?php echo $row['ECPhone'];?>" class="form-control" required /></td>
				</tr>
            	<tr>
					<td width=20%>Fax</td>
					<td><input type="text" name="ecfax" id="ecfax" value="<?php echo $row['ECFax'];?>" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Website</td>
					<td><input type="text" name="ecwebsite" id="ecwebsite" value="<?php echo $row['ECWebsite'];?>" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Address 1</td>
					<td><input type="text" name="ecaddress1" id="ecaddress1" value="<?php echo $row['ECAddress1'];?>" class="form-control" required /></td>
				</tr>
            	<tr>
					<td width=20%>Address 2</td>
					<td><input type="text" name="ecaddress2" id="ecaddress2" value="<?php echo $row['ECAddress2'];?>" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>City</td>
					<td><input type="text" name="eccity" id="eccity" value="<?php echo $row['ECCity'];?>" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>State</td>
					<td><input type="text" name="ecstate" id="ecstate" value="<?php echo $row['ECState'];?>" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Zipcode</td>
					<td><input type="text" name="eczip" id="eczip" value="<?php echo $row['ECZip'];?>" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Country</td>
					<td><input type="text" name="eccountry" id="eccountry" value="<?php echo $row['ECCountry'];?>" class="form-control"  /></td>
				</tr>
            	<tr>
					<td >Enter By</td>
					<td ><?php echo $row['username'] ;?></td>
				</tr>
            	<tr>
					<td >Modify Date</td>
            		<td><?php echo ($row['ECModifyDate']) ;?></td>
				</tr>
            	<tr>
            		<?php
					$modifybyid = $row['ECModifyBy'];
    				$modifybyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
    				while($modifyrow = $modifybyresult->fetch_assoc()){
            		?>
					<td>Modify By</td>
					<td><?php echo $modifyrow['username'];?></td>
                    <?php
                    }
                    ?>
                </tr>
            	<tr>
					<td >Status</td>
            		<td><select name="status" id="status" class="form-control" >
                    	<option value="">Select Status</option>
                    	<option value="Active">Active</option>
                        <option value="InActive">InActive</option>
                    </select></td>
				</tr>
			</table>
            <input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            <input type="submit" name="reset" id="reset" class="btn btn-warning" value="Reset" />
            <?php
            }
            ?>
            
		</div>
	</div>
</div>
</form>
<?php
if(isset($_POST['Save'])){
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
	
	$sql = "UPDATE Entity_Contact SET ECname = '$ecname', ECEmail = '$ecemail', ECPhone = '$ecphone', ECFax = '$ecfax', ECWebsite = '$ecwebsite', ECAddress1 = '$ecaddress1', ECAddress2 = '$ecaddress2', ECCity = '$eccity', ECState = '$ecstate', ECZip = '$eczip', ECCountry = '$eccountry', ECModifyDate = '$modify_date', ECModifyBy = $modify_by, ECStatus = '$ecstatus'
            WHERE ECID = $ecid";
    if($dbconnect->query($sql) === TRUE){
		echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">Contact Updated</div>';
       			 </script>";
		echo "<meta http-equiv='refresh' content='2'>";
	}
    else{
        echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-danger"'.">Query Failed: ".$sql."</div>';
       			 </script>";
    }
}     
?>
<script>
$(document).ready(function(){
	$('#status').val("<?php echo $status?>");
	$('#epid').val("<?php echo $epid?>");

});
</script>


<?php
include ('footer.php');
?>