<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$eid =$_GET['eid'];
$status; $epid;

?>
<span id="alert_action"></span>
<form method="POST" id="vender_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">

			<?php
            $entitysql = "SELECT * FROM Entity e INNER JOIN SMDBAccounts sma ON sma.AcctID = e.EEnterBy WHERE e.EID = $eid";
			$entityfetch = $dbconnect->query($entitysql);
			while($row = $entityfetch->fetch_array()){
            	$status = $row['EStatus'];
            	$epid = $row['EPID'];
            ?>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Vendor <?php echo $row['EName'];?></h3>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
            	<div class="row" align="right">
            		<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='vendor.php'">Back</button>   					
            	</div>
            </div>
			
			<table id="samplerecord_data" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Vendor Name</td>
					<td width=40%><input type="text" name="ename" id="ename" value="<?php echo $row['EName'];?>" class="form-control" required /></td>
            		<td width=10%>Parent Vendor</td>
					<td width=40%><select name="epid" id="epid" class="selectpicker" data-live-search="true" >
                                    <option value="">Select Parent Vender</option>
                                    <?php echo entity_option_list($dbconnect);?>
                                </select></td>
				</tr>
				<tr>
					<td width=10%>Register As</td>
					<td width=40%><input type="text" name="eregisteredname" id="eregisteredname" value="<?php echo $row['ERegisteredName'];?>" class="form-control" required /></td>
            		<td width=10%>Supplier</td>
            		<td><input type="text" name="supplier" id="supplier" value="<?php echo $row['Supplier'];?>" /></td>
				</tr>
            	<tr>
					<td>Owner</td>
					<td><input type="text" name="owner" id="owner" value="<?php echo $row['Owner'];?>" class="form-control" required/></td>
            		<td>Product Manufactured</td>
            		<td><input type="text" name="productmanufactured" id="productmanufactured" value="<?php echo $row['ProductManufactured'];?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Last Modify</td>
					<td width=40%><?php echo date('Y-m-d H:i', strtotime($row['EModifyDate'])) ;?></td>
            		<td width=10%>OEM Customer</td>
            		<td><input type="text" name="oemcustomer" id="oemcustomer" value="<?php echo $row['OEMCustomer'];?>" /></td>
				</tr>
            	<tr>
            		<?php
					$modifybyid = $row['EModifyBy'];
    				$modifybyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
    				while($modifyrow = $modifybyresult->fetch_assoc()){
            		?>
					<td width=10%>Modify By</td>
					<td width=40%><?php echo $modifyrow['username'];?></td>
                    <?php
                    }
                    ?>
                    <td width=10%># of Worker</td>
            		<td><input type="text" name="numberofworker" id="numberofworker" value="<?php echo $row['NumberofWorker'];?>" class="form-control" /></td>
            		
				</tr>
            	<tr>
            		<td width=10%>Status</td>
					<td width=40%><select name="status" id="status" class="form-control" >
                    	<option value="">Select Status</option>
                    	<option value="Active">Active</option>
                        <option value="InActive">InActive</option>
                    </select></td>
                    <td width=10%>Annual Sale</td>
            		<td><input type="text" name="annualsale" id="annualsale" value="<?php echo $row['AnnualSales'];?>" class="form-control"/></td>
				</tr>
                <tr>
                    <td width=10%>Enter By</td>
					<td width=40%><?php echo $row['username'];?></td>
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
            
<form method="POST" id="view_sample">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Contacts Related</h3>
            	</div>
            </div>
            <?php
    		$contactsql = "SELECT * FROM Entity e INNER JOIN Entity_RelateTo_Contact erc ON erc.EID = e.EID
						INNER JOIN Entity_Contact ec ON ec.ECID = erc.ECID
                        WHERE e.EID = $eid";

    		$contactfetch = $dbconnect->query($contactsql);
    		while($crow = $contactfetch->fetch_array()){
			?>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<div class="col-md-8"><h4>Title: <?php echo $crow['ERCTitle'];?></h4></div>
            	</div>
            </div>
			<table id="contact_view" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Name</td>
					<td width=40%><?php echo $crow['ECName'];?></td>
            		<td width=10%>Address 1</td>
            		<td width=40%><?php echo $crow['ECAddress1'];?></td>
				</tr>
            	<tr>
					<td width=10%>Email</td>
					<td width=40%><?php echo $crow['ECEmail'];?></td>
            		<td width=10%>Address 2</td>
            		<td width=40%><?php echo $crow['ECAddress2'];?></td>
				</tr>
            	<tr>
					<td width=10%>Phone</td>
					<td width=40%><?php echo $crow['ECPhone'];?></td>
            		<td width=10%>City</td>
            		<td width=40%><?php echo $crow['ECCity'];?></td>
				</tr>
            	<tr>
					<td width=10%>Fax</td>
					<td width=40%><?php echo $crow['ECFax'];?></td>
            		<td width=10%>State-Zip</td>
            		<td width=40%><?php echo $crow['ECState']."-".$crow['ECZip'];?></td>
				</tr>
            	<tr>
					<td width=10%>Website</td>
					<td width=40%><?php echo $crow['ECWebsite'];?></td>
            		<td width=10%>Country</td>
            		<td width=40%><?php echo $crow['ECCountry'];?></td>
				</tr>
            	<tr>
					<td width=10%>Status</td>
					<td width=40%><?php echo $crow['ECStatus'];?></td>
                    <td width=10%>Priority</td>
					<td width=40%><?php echo $crow['Priority'];?></td>
				</tr>
            	
			</table>
            <?php
            }
            ?>  
		</div>
	</div>
</div>
</form>

            
            
<?php
if(isset($_POST['Save'])){
	$epid = (($_POST['epid'] != '') ? ($epid = $_POST['epid']) : ($epid = 0));
    $ename = $_POST['ename'];
    $eregisteredname = $_POST['eregisteredname'];
    $owner = $_POST['owner'];
    $supplier = (($_POST['supplier'] != '') ? ($supplier = $_POST['supplier']) : ($supplier = ""));
    $oemcustomer = (($_POST['oemcustomer'] != '') ? ($oemcustomer = $_POST['oemcustomer']) : ($oemcustomer = ""));
    $numberofworker = (($_POST['numberofworker'] != '') ? ($numberofworker = $_POST['numberofworker']) : ($numberofworker = 0));
    $annualsale = (($_POST['annualsale'] != '') ? ($annualsale = $_POST['annualsale']) : ($annualsale = 0));
    $productmanufactured = $_POST['productmanufactured'];
	$status = $_POST['status'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	
	$sql = "UPDATE Entity SET EPID = $epid, EName = '$ename', ERegisteredName = '$eregisteredname', Owner = '$owner', Supplier = '$supplier', OEMCustomer = '$oemcustomer', NumberofWorker = $numberofworker, AnnualSales = $annualsale, ProductManufactured = '$productmanufactured', EModifyDate = '$modify_date', EModifyBy = $modify_by, EStatus = '$status'
            WHERE EID = $eid";
    if($dbconnect->query($sql) === TRUE){
		echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">Vendor Updated</div>';
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

	$('#productmanufactured').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    create: function(input) {
        return {
            value: input,
            text: input
        }
    }
	});
	$('#oemcustomer').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    create: function(input) {
        return {
            value: input,
            text: input
        }
    }
	});
	$('#supplier').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    create: function(input) {
        return {
            value: input,
            text: input
        }
    }
	});
});
</script>


<?php
include ('footer.php');
?>