<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$sid =$_GET['sid'];
$status;
?>

<form method="POST" id="sample_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Sample Update</h3>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
            	<div class="row" align="right">
            		<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='sample.php'">Back</button>   					
            	</div>
            </div>
			<?php
			$sql = "SELECT * FROM Sample JOIN SMDBAccounts ON SEnterBy = AcctID WHERE SID = $sid";
			$samplefetch = $dbconnect->query($sql);
			while($row = $samplefetch->fetch_assoc()){
           		$status = $row['SStatus'];
			?>
			<table id="sample_data" class="table table-bordered table-striped">
				<tr>
					<td width=20%>Sample Name</td>
					<td><input type="text" name="sample_name" id="sample_name" value="<?php echo $row['SName'];?>" class="form-control"/></td>
				</tr>
				<tr>
					<td >Description</td>
					<td><input type="text" name="sample_description" id="sample_description" value="<?php echo $row['SDescription'];?>" class="form-control"/></td>
				</tr>
            	<tr>
					<td >Image</td>
					<td><input type="text" name="sample_image" id="sample_image" value="<?php echo $row['SImages'];?>" class="form-control"/></td>
				</tr>
            	<tr>
					<td>Status</td>
            		<td><select name="status" id="status" class="form-control" >
                    	<option value="">Select Status</option>
                    	<option value="Active">Active</option>
                        <option value="InActive">InActive</option>
                    </select></td>
				</tr>
            	<tr>
					<td >Enter By</td>
					<td ><?php echo $row['username'] ;?></td>
				</tr>
            	<tr>
					<td >Modify Date</td>
            		<td><?php echo date('Y-m-d H:i', strtotime($row['SModifyDate'])) ;?></td>
				</tr>
			</table>
            <?php
            }
            ?>
			<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            <input type="submit" name="reset" id="reset" class="btn btn-warning" value="Reset" />
		</div>
	</div>
</div>
</form>
            
<form method="POST" id="sample_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Records Related</h3>
            	</div>
            </div>
			<?php
            $recordquery = "SELECT * FROM SampleRecord sr INNER JOIN Entity e ON sr.EID = e.EID
								INNER JOIN SMDBAccounts sma ON sma.AcctID = sr.SRRequestBy WHERE SID = $sid";
			$recordfetch = $dbconnect->query($recordquery);
			while($rcrow = $recordfetch->fetch_array()){
            ?>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h4>Request From: <?php echo $rcrow['EName']?></h4>
            	</div>
            </div>
			<table id="sample_data" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Type</td>
					<td width=40%><?php echo $rcrow['Type']?></td>
            		<td width=10%>Requested On</td>
            		<td><?php echo $rcrow['DateRequested']?></td>
				</tr>
				<tr>
					<td width=10%>Requested By</td>
					<td width=40%><?php echo $rcrow['username'] ;?></td>
            		<td width=10%>Est Deliver</td>
            		<td><?php echo $rcrow['EstDeliver']?></td>
				</tr>
            	<tr>
					<td width=10%>Quantity</td>
					<td width=40%><?php echo $rcrow['Quantity'] ;?></td>
            		<td width=10%>Payment Term</td>
            		<td><?php echo $rcrow['PaymentTerms']?></td>
				</tr>
            	<tr>
					<td width=10%>Price/Unit</td>
					<td width=40%><?php echo $rcrow['PriceperUnit'] ;?></td>
            		<td width=10%>Warranty Term</td>
            		<td><?php echo $rcrow['WarrantyTerms']?></td>
				</tr>
            	<tr>
					<td width=10%>Status</td>
					<td width=40%><?php echo $rcrow['SRStatus'] ;?></td>
            		<td width=10%>Shipping Term</td>
            		<td><?php echo $rcrow['ShippingTerms']?></td>
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
	$sname = $_POST['sample_name'];
	$sdescription = $_POST['sample_description'];
	$simage = $_POST['sample_image'];
	$status = $_POST['status'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	
	$sql = "UPDATE Sample SET SName = '$sname', SDescription = '$sdescription', SImages = '$simage', SModifyDate = '$modify_date', SModifyBy = $modify_by, SStatus = '$status'
            WHERE SID = $sid";
    if($dbconnect->query($sql) === TRUE){
		//header("Refresh:2");
		echo "<meta http-equiv='refresh' content='0'>";
	}
    else{
        echo $sql;
    }
}   
?>
<script>
$(document).ready(function(){
	$('#status').val("<?php echo $status?>");
});
</script>


<?php
include ('footer.php');
?>