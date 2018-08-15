<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$srid =$_GET['srid'];
$status; $type; $eid; $sid;
?>
	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Record Update</font></h3>
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
			<form method="POST" id="samplerecord_update_form">
			<?php
            $recordquery = "SELECT * FROM PD_SampleRecord sr INNER JOIN PD_DB_Account sma ON sma.AcctID = sr.SRRequestBy WHERE SRID = $srid";
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
            			<select name="type" id="type" class="selectpicker" data-live-search="true" required>
                                <option value="">Select Type</option>
                        		<option value="Quote">Quote</option>
                        		<option value="P.O">P.O</option>
                        		<option value="Invoice">Invoice</option>
                        		<option value="Payment">Payment</option>
                       	</select></td>
            		<td width=10%>Date Request</td>
            		<td><?php echo date('Y-m-d', strtotime($row['DateRequested'])) ;?></td>
				</tr>
				<tr>
					<td width=10%>Sample</td>
					<td width=40%><select name="sid" id="sid" class="selectpicker" data-live-search="true" required>
                                    <option value="">Select Sample</option>
                                    <?php echo sample_option_list($dbconnect);?>
                    	</select>
            			<button type="button" name="addsample" id="addsample" class="btn btn-success btn-xs" onclick="window.location.href='sample_add.php'">Add</button></td>
            		<td width=10%>Est Deliver</td>
            		<td><input type="date" name="estdeliver" id="estdeliver" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['EstDeliver'])) ;?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Request From</td>
					<td width=40%>
            			<select name="eid" id="eid" class="selectpicker" data-live-search="true" required>
                                    <option value="">Select Vender</option>
                                    <?php echo entity_option_list($dbconnect);?>
                    	</select>
            			<button type="button" name="addvendor" id="addvendor" class="btn btn-success btn-xs" onclick="window.location.href='vendor_add.php'">Add</button></td>
            		<td width=10%>Arrival Date</td>
            		<td><input type="date" name="arrivaldate" id="arrivaldate" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['ArrivalDate'])) ;?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Quantity</td>
					<td width=40%><input type="number" name="quantity" id="quantity" value="<?php echo $row['Quantity'];?>" class="form-control" pattern="[0-9]+" required/></td>
            		<td width=10%>Payment Term</td>
            		<td><input type="text" name="paymentterm" id="paymentterm" value="<?php echo $row['PaymentTerms'];?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Used</td>
					<td width=40%><input type="number" name="used" id="used" value="<?php echo $row['Used'];?>" class="form-control" pattern="[0-9]+"/></td>
            		<td width=10%>Warranty Term</td>
            		<td><input type="text" name="warrantyterm" id="warrantyterm" value="<?php echo $row['WarrantyTerms'];?>" /></td>
				</tr>
            	<tr>
            		
					<td width=10%>Available</td>
					<td width=40%><input type="number" name="available" id="available" value="<?php echo $row['Available'];?>" class="form-control" pattern="[0-9]+"/></td>
            		<td width=10%>Shipping Term</td>
            		<td><input type="text" name="shippingterm" id="shippingterm" value="<?php echo $row['ShippingTerms'];?>" /></td>
				</tr>
            	<tr>
            		<td width=10%>Price/Unit</td>
					<td width=40%><input type="number" name="priceperunit" id="priceperunit" value="<?php echo $row['PriceperUnit'];?>" class="form-control" pattern="[0-9.]+"/></td>
            		
            		<td>Enter By</td>
            		<td><?php echo $row['username'];?></td>
				</tr>
            	<tr>
					<?php
					$modifybyid = $row['SRModifyBy'];
    				$modifybyresult = $dbconnect->query("SELECT username FROM PD_DB_Account WHERE AcctID = $modifybyid");
    				while($modifyrow = $modifybyresult->fetch_assoc()){
            		?>
					<td width=10%>Modify By</td>
					<td width=40%><?php echo $modifyrow['username'];?></td>
                    <?php
                    }
                    ?>
                    <td width=10%>Last Modify</td>
					<td width=40%><?php echo date('Y-m-d H:i', strtotime($row['SRModifyDate'])) ;?></td>
				</tr>
			</table>
            <?php
            }
            ?>
            <div style="text-align:center">
            	<span id="alert_action"></span>
            	<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            	<input type="button" name="Reset" id="Reset" class="btn btn-warning" value="Reset" onClick="window.location.reload()"/>
            </div>
            
            </form>
		</div>
	</div>

<script>
$(document).ready(function(){

	$('#samplerecord_update_form').submit(function(event){
       	event.preventDefault();
    	var action="save_update";
       	var srid = "<?php echo $srid?>"
       	var data = $(this).serialize()+"&action="+action+"&srid="+srid;
       	$.ajax({
           	type:"post",
           	url:"samplerecord_action.php",
           	data:data,
           	success: function(mess){
               	$('#alert_action').fadeIn().html(mess);
               	window.setTimeout(function(){location.reload()},2000)
           	}
       	});
    });

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