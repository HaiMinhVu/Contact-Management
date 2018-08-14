<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$ecid =$_GET['ecid'];
$eid=$_GET['eid'];
$status;
$priority;
$relateEID;
?>
<span id="alert_action"></span>

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Contact Update</font></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
                    <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.history.back()">Back</button> 	
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		<div class="panel-body">
			
            <form method="POST" id="contact_update_form">
			<?php
            $sql = "SELECT * FROM PD_Entity_Contact_Person ecp INNER JOIN PD_DB_Account sma ON sma.AcctID = ecp.ECEnterBy WHERE ecp.ECPID = $ecid";
			$ecfetch = $dbconnect->query($sql);
			while($row = $ecfetch->fetch_array()){
            	
            	
            ?>
            <!--------------General Info Update------------>
			<table id="contact_data" class="table table-bordered table-striped">
            	<h5><label>General Info</label></h5>
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
    				$modifybyresult = $dbconnect->query("SELECT username FROM PD_DB_Account WHERE AcctID = $modifybyid");
    				while($modifyrow = $modifybyresult->fetch_assoc()){
            		?>
					<td>Modify By</td>
					<td><?php echo $modifyrow['username'];?></td>
                    <?php
                    }
                    ?>
                </tr>
            	
			</table>
            <?php
            }
            ?>
            
            <!--------------Relationship Update------------>
            <?php
            $query = "SELECT * FROM PD_Entity_RelateTo_Contact WHERE ECID = $ecid AND EID = $eid";
        	$result = $dbconnect->query($query);
			while($ecrow = $result->fetch_assoc()){
            	$status = $ecrow['ERCStatus'];
            	$relateEID = $ecrow['EID'];
            	$priority = $ecrow['Priority'];
            ?>
            <table id="add_contact_relation" class="table table-bordered table-striped">
				<h5><label>Related To</label></h5>
				<tr>
					<td width=20%>Select Vendor</td>
					<td><select name="eid" id="eid" class="selectpicker" data-live-search="true" required>
                                    <option value="">Select Vender</option>
                                    <?php echo entity_option_list($dbconnect);?>
                    </select></td>
				</tr>
				<tr>
					<td width=20%>Priority</td>
					<td><select name="priority" id="priority" class="selectpicker" data-live-search="true" required>
                                    <option value="">Select Priority</option>
                                    <option value="Primary Contact">Primary Contact</option>
                                    <option value="Alternative Contact">Alternative Contact</option>
                    </select></td>
				</tr>
				<tr>
					<td width=20%>Title</td>
					<td><input type="text" name="erctitle" id="erctitle" class="form-control" value="<?php echo $ecrow['ERCTitle']?>" required /></td>
				</tr>
            	<tr>
					<td >Status</td>
            		<td><input type="checkbox" name="ecrstatus" id="ecrstatus" value="status"> Active</td>
				</tr>
			</table>
            <?php
            }
            ?>
            <div style="text-align:center">
            	<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            	<input type="submit" name="reset" id="reset" class="btn btn-warning" value="Reset" />
            </div>
            </form>
		</div>
	</div>

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

	$eid = $_POST['eid'];
    $erctitle = $_POST['erctitle'];
    $priority = $_POST['priority'];
	$ercstatus;
	if(empty($_POST['ecrstatus'])){
    	$ercstatus = 'InActive';
    }
	else{
    	$ercstatus = 'Active';
    }

	// query update contact
	$sql = "UPDATE PD_Entity_Contact_Person SET ECname = '$ecname', ECEmail = '$ecemail', ECPhone = '$ecphone', ECFax = '$ecfax', ECWebsite = '$ecwebsite', ECAddress1 = '$ecaddress1', ECAddress2 = '$ecaddress2', ECCity = '$eccity', ECState = '$ecstate', ECZip = '$eczip', ECCountry = '$eccountry', ECModifyDate = '$modify_date', ECModifyBy = $modify_by
            WHERE ECPID = $ecid";

	// query update relationship
	$relationupdatesql = "UPDATE PD_Entity_RelateTo_Contact SET EID = $eid, ECID = $ecid, Priority = '$priority', ERCTitle = '$erctitle', ERCStatus = '$ercstatus', ERCModifyDate = '$modify_date', ERCModifyBy = $modify_by WHERE ECID = $ecid AND EID = $relateEID";

    if(($dbconnect->query($sql) === TRUE) && ($dbconnect->query($relationupdatesql) === TRUE)){
		echo "<script type='text/javascript'>
            	alert('Contact Updated');
                window.location.href = 'vendorcontact.php';
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
$(document).ready(function(){
	$('#epid').val("<?php echo $epid; ?>");

	var ecrstatus = "<?php echo $status; ?>";
	if(ecrstatus == "Active"){
    	$('#ecrstatus').prop("checked", true);
    }
	else{
    	$('#ecrstatus').prop("checked", false);
    }
	
	$('#eid').val("<?php echo $relateEID; ?>");
	$('#priority').val("<?php echo $priority?>");
});
</script>

<?php
include ('footer.php');
?>