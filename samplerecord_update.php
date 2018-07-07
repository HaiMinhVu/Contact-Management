<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$srid =$_GET['srid'];
$status; $type; $eid; $sid;

?>
<form method="POST" id="sample_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">

            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Sample Record Update</h3>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
            	<div class="row" align="right">
            		<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='samplerecord.php'">Back</button>   					
            	</div>
            </div>
			<?php
            $recordquery = "SELECT * FROM SampleRecord sr INNER JOIN SMDBAccounts sma ON sma.AcctID = sr.SRRequestBy WHERE SRID = $srid";
			$recordfetch = $dbconnect->query($recordquery);
			$countrecord = mysqli_num_rows($recordfetch);
			while($row = $recordfetch->fetch_array()){
            	$status = $row['SRStatus'];
            	$type = $row['Type'];
            	$eid = $row['EID'];
            	$sid = $row['SID'];
            ?>
			<table id="samplerecord_data" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Type</td>
					<td width=40%>
            			<select name="type" id="type" class="form-control" required>
                                <option value="">Select Type</option>
                        		<option value="Quote">Quote</option>
                        		<option value="P.O">P.O</option>
                        		<option value="Invoice">Invoice</option>
                        		<option value="Payment">Payment</option>
                       	</select></td>
            		<td width=10%>Date Request</td>
            		<td><input type="date" name="daterequested" id="daterequested" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['DateRequested'])) ;?>" required /></td>
				</tr>
				<tr>
					<td width=10%>Sample</td>
					<td width=40%><select name="sid" id="sid" class="form-control" required>
                                    <option value="">Select Vender</option>
                                    <?php echo sample_option_list($dbconnect);?>
                    	</select></td>
            		<td width=10%>Est Deliver</td>
            		<td><input type="date" name="estdeliver" id="estdeliver" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['EstDeliver'])) ;?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Request From</td>
					<td width=40%>
            			<select name="eid" id="eid" class="form-control" required>
                                    <option value="">Select Vender</option>
                                    <?php echo entity_option_list($dbconnect);?>
                    	</select></td>
            		<td width=10%>Arrival Date</td>
            		<td><input type="date" name="arrivaldate" id="arrivaldate" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['ArrivalDate'])) ;?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Quantity</td>
					<td width=40%><input type="text" name="quantity" id="quantity" value="<?php echo $row['Quantity'];?>" class="form-control"/></td>
            		<td width=10%>Payment Term</td>
            		<td><input type="text" name="paymentterm" id="paymentterm" value="<?php echo $row['PaymentTerms'];?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Price/Unit</td>
					<td width=40%><input type="text" name="priceperunit" id="priceperunit" value="<?php echo $row['PriceperUnit'];?>" class="form-control"/></td>
            		<td width=10%>Warranty Term</td>
            		<td><input type="text" name="warrantyterm" id="warrantyterm" value="<?php echo $row['WarrantyTerms'];?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Last Modify</td>
					<td width=40%><?php echo date('Y-m-d H:i', strtotime($row['SRModifyDate'])) ;?></td>
            		<td width=10%>Shipping Term</td>
            		<td><input type="text" name="shippingterm" id="shippingterm" value="<?php echo $row['ShippingTerms'];?>" /></td>
				</tr>
            	<tr>
            		<?php
					$modifybyid = $row['SRModifyBy'];
    				$modifybyresult = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
    				while($modifyrow = $modifybyresult->fetch_assoc()){
            		?>
					<td width=10%>Modify By</td>
					<td width=40%><?php echo $modifyrow['username'];?></td>
                    <?php
                    }
                    ?>
            		<td>Enter By</td>
            		<td><?php echo $row['username'];?></td>
            		
				</tr>
            	<tr>
					<td width=10%>Status</td>
					<td width=40%><select name="status" id="status" class="form-control" >
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
	$sid = $_POST['sid'];
	$eid = $_POST['eid'];
	$type = $_POST['type'];
	$quantity = $_POST['quantity'];
	$priceperunit = $_POST['priceperunit'];
	$daterequested = $_POST['daterequested'];
	$estdeliver = $_POST['estdeliver'];
	$arrivaldate = $_POST['arrivaldate'];
	$paymentterm = $_POST['paymentterm'];
	$shippingterm = $_POST['shippingterm'];
	$warrantyterm = $_POST['warrantyterm'];
	$status = $_POST['status'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	
	$sql = "UPDATE SampleRecord SET SID = $sid, EID = $eid, Type = '$type', Quantity = $quantity, PriceperUnit = $priceperunit, DateRequested = '$daterequested', EstDeliver = '$estdeliver', ArrivalDate = '$arrivaldate', PaymentTerms = '$paymentterm', ShippingTerms = '$shippingterm', WarrantyTerms = '$warrantyterm', SRModifyDate = '$modify_date', SRModifyBy = $modify_by, SRStatus = '$status'
            WHERE SRID = $srid";
    if($dbconnect->query($sql) === TRUE){
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
	$('#type').val("<?php echo $type?>");
	$('#eid').val("<?php echo $eid?>");
	$('#sid').val("<?php echo $sid?>");

	$('#paymentterm').selectize({
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
	$('#warrantyterm').selectize({
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
	$('#shippingterm').selectize({
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