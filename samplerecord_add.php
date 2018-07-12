<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>
<span id="alert_action"></span>
<form method="POST" id="sample_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">

            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Sample Record List</h3>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
            	<div class="row" align="right">
            		<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='samplerecord.php'">Back</button>   					
            	</div>
            </div>
			
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
            		<td><input type="date" name="daterequested" id="daterequested" class="form-control" value="<?php echo date('Y-m-d') ;?>" /></td>
				</tr>
				<tr>
					<td width=10%>Sample</td>
					<td width=40%><select name="sid" id="sid" class="selectpicker" data-live-search="true" required>
                                    <option value="">Select Sample</option>
                                    <?php echo sample_option_list($dbconnect);?>
                    	</select>
						<button type="button" name="addsample" id="addsample" class="btn btn-success btn-xs" onclick="window.location.href='sample_add.php'">Add</button></td></td>
            		<td width=10%>Est Deliver</td>
            		<td><input type="date" name="estdeliver" id="estdeliver" class="form-control" value="<?php echo date('Y-m-d') ;?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Request From</td>
					<td width=40%>
            			<select name="eid" id="eid" class="selectpicker" data-live-search="true" required>
                                    <option value="">Select Vendor</option>
                                    <?php echo entity_option_list($dbconnect);?>
                    	</select>
						<button type="button" name="addvendor" id="addvendor" class="btn btn-success btn-xs" onclick="window.location.href='vendor_add.php'">Add</button></td>
            		<td width=10%>Arrival Date</td>
            		<td><input type="date" name="arrivaldate" id="arrivaldate" class="form-control" value="<?php echo date('Y-m-d') ;?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Quantity</td>
					<td width=40%><input type="text" name="quantity" id="quantity" value="<?php echo $row['Quantity'];?>" class="form-control" required /></td>
            		<td width=10%>Payment Term</td>
            		<td><input type="text" name="paymentterm" id="paymentterm" value="<?php echo $row['PaymentTerms'];?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Price/Unit</td>
					<td width=40%><input type="text" name="priceperunit" id="priceperunit" value="<?php echo $row['PriceperUnit'];?>" class="form-control" /></td>
            		<td width=10%>Warranty Term</td>
            		<td><input type="text" name="warrantyterm" id="warrantyterm" value="<?php echo $row['WarrantyTerms'];?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Status</td>
					<td width=40%><select name="status" id="status" class="form-control" >
                    	<option value="">Select Status</option>
                    	<option value="Active" selected>Active</option>
                        <option value="InActive">InActive</option>
                    </select></td>
            		<td width=10%>Shipping Term</td>
            		<td><input type="text" name="shippingterm" id="shippingterm" value="<?php echo $row['ShippingTerms'];?>" /></td>
				</tr>
            	<tr>
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
	$sid = $_POST['sid'];
	$eid = $_POST['eid'];
	$type = $_POST['type'];
	$quantity = $_POST['quantity'];
	$priceperunit = (($_POST['priceperunit'] != '') ? ($priceperunit = $_POST['priceperunit']) : ($priceperunit = 0));
	$daterequested = $_POST['daterequested'];
	$estdeliver = $_POST['estdeliver'];
	$arrivaldate = $_POST['arrivaldate'];
	$paymentterm = $_POST['paymentterm'];
	$shippingterm = $_POST['shippingterm'];
	$warrantyterm = $_POST['warrantyterm'];
	$status = $_POST['status'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	
	$sql = "INSERT INTO SampleRecord VALUES(null, $sid, $eid, $quantity, $priceperunit, '$daterequested', '$type', '$estdeliver', '$arrivaldate', '$paymentterm', '$warrantyterm', '$shippingterm', $modify_by, '$modify_date', '$modify_by', '$status')";
    if($dbconnect->query($sql) === TRUE){
		echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">New Record Added</div>';
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