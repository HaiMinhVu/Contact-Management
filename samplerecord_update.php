<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$srid =$_GET['srid'];
$status; $type; $eid; $sid;
?>
<<<<<<< HEAD
=======
<span id="alert_action"></span>

>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Record Update</font></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
<<<<<<< HEAD
                    <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.history.back()">Back</button> 	
=======
                    <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='samplerecord.php'">Back</button> 	
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
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
            		<td><input type="date" name="daterequested" id="daterequested" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['DateRequested'])) ;?>" required /></td>
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
					<td width=40%><input type="text" name="quantity" id="quantity" value="<?php echo $row['Quantity'];?>" class="form-control"/></td>
            		<td width=10%>Payment Term</td>
            		<td><input type="text" name="paymentterm" id="paymentterm" value="<?php echo $row['PaymentTerms'];?>" /></td>
				</tr>
            	<tr>
					<td width=10%>Used</td>
					<td width=40%><input type="text" name="used" id="used" value="<?php echo $row['Used'];?>" class="form-control"/></td>
            		<td width=10%>Warranty Term</td>
            		<td><input type="text" name="warrantyterm" id="warrantyterm" value="<?php echo $row['WarrantyTerms'];?>" /></td>
				</tr>
            	<tr>
            		
					<td width=10%>Available</td>
					<td width=40%><input type="text" name="available" id="available" value="<?php echo $row['Available'];?>" class="form-control"/></td>
            		<td width=10%>Shipping Term</td>
            		<td><input type="text" name="shippingterm" id="shippingterm" value="<?php echo $row['ShippingTerms'];?>" /></td>
				</tr>
            	<tr>
            		<td width=10%>Price/Unit</td>
					<td width=40%><input type="text" name="priceperunit" id="priceperunit" value="<?php echo $row['PriceperUnit'];?>" class="form-control"/></td>
            		
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
<<<<<<< HEAD
                    <td width=10%>Last Modify</td>
					<td width=40%><?php echo date('Y-m-d H:i', strtotime($row['SRModifyDate'])) ;?></td>
=======
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
            		
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
				</tr>
			</table>
            <?php
            }
            ?>
<<<<<<< HEAD
            <div style="text-align:center">
            	<span id="alert_action"></span>
            	<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            	<input type="submit" name="reset" id="reset" class="btn btn-warning" value="Reset" />
            </div>
            
=======
            	<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            	<input type="submit" name="reset" id="reset" class="btn btn-warning" value="Reset" />
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
            </form>
		</div>
	</div>

<<<<<<< HEAD
=======
    <!-- 
	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Related Reviews</font></h3>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		<div class="panel-body">
            <?php
            $getsreidsql = "SELECT SReID FROM SampleReview WHERE SRID = $srid";
			$getsreidresult = $dbconnect->query($getsreidsql);
			foreach ($getsreidresult as $sreidrow){
            	$sreid = $sreidrow['SReID'];
            	$sreidsql = "SELECT * FROM SampleReview JOIN SMDBAccounts ON ReviewBy = AcctID WHERE SReID = $sreid";
            	$samplefetch = $dbconnect->query($sreidsql);
				while($srerow = $samplefetch->fetch_assoc()){
            ?>
                <table id="samplereview_update_data" class="table table-bordered table-striped">
            	<tr>
            		<a href="samplereview_update.php?sreid=<?php echo $sreid; ?>" class="btn btn-warning btn-xs">Edit</a>
            	</tr>
				<tr>
					<td width=10%>Comment</td>
            		<td width=60%><?php echo $srerow['SReComments'];?></td>
            		<td rowspan="3"><?php echo "<img src='images/sample_review/". $srerow['SReImages']."' height='250' width='250'>"; ?></td>
				</tr>
            	
            	<tr>
					<td>Review By</td>
					<td><?php echo $srerow['username'] ;?></td>
				</tr>
            	<tr>
					<td>Last Modify</td>
            		<td><?php echo date('Y-m-d H:i', strtotime($srerow['ReviewDate'])) ;?></td>
				</tr>
			</table>
            <br>
            <?php
                }
            }
            ?>
		</div>
	</div>
    -->
            
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
    	echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">Record Updated</div>';
       			 </script>";
		echo "<meta http-equiv='refresh' content='2'>";
	}
    else{
        echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-danger"'.">Failed to Update</div>';
       			 </script>";
    }
}     
?>
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
<script>
$(document).ready(function(){

	$('#Save').click(function(){
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