<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>

<form method="POST" id="sample_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Add New Vendor</h3>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
            	<div class="row" align="right">
            		<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='vender.php'">Back</button>   					
            	</div>
            </div>
			<table id="sample_data" class="table table-bordered table-striped">
				<tr>
					<td width=20%>Vendor Parent</td>
					<td><select name="epid" id="epid" class="form-control">
                                    <option value="">Select Parents</option>
                                    <?php echo entity_option_list($dbconnect);?>
                    </select></td>
				</tr>
				<tr>
					<td>Vendor Name</td>
					<td><input type="text" name="ename" id="ename" class="form-control" required /></td>
				</tr>
            	<tr>
					<td>Register As</td>
					<td><input type="text" name="eregisteredname" id="eregisteredname" class="form-control" required /></td>
				</tr>
				<tr>
					<td>Owner</td>
					<td><input type="text" name="owner" id="owner" class="form-control" required /></td>
				</tr>
				<tr>
					<td>Supplier</td>
					<td><input type="text" name="supplier" id="supplier" /></td>
				</tr>
				<tr>
					<td>OEM Customer</td>
					<td><input type="text" name="oemcustomer" id="oemcustomer" /></td>
				</tr>
				<tr>
					<td># of Worker</td>
					<td><input type="text" name="numberofworker" id="numberofworker" class="form-control" /></td>
				</tr>
				<tr>
					<td>Annual Sale</td>
					<td><input type="text" name="annualsale" id="annualsale" class="form-control" /></td>
				</tr>
				<tr>
					<td>Product Manufactured</td>
					<td><input type="text" name="productmanufactured" id="productmanufactured" /></td>
				</tr>
            	<tr>
					<td>Status</td>
            		<td><select name="status" id="status" class="form-control" required>
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
    	$epid = (($_POST['epid'] != '') ? ($epid = $_POST['completedate']) : ($epid = 0));
    	$ename = $_POST['ename'];
    	$eregisteredname = $_POST['eregisteredname'];
    	$owner = $_POST['owner'];
    	$supplier = (($_POST['supplier'] != '') ? ($supplier = $_POST['supplier']) : ($supplier = ""));
    	$oemcustomer = (($_POST['oemcustomer'] != '') ? ($oemcustomer = $_POST['oemcustomer']) : ($oemcustomer = ""));
    	$numberofworker = (($_POST['numberofworker'] != '') ? ($numberofworker = $_POST['numberofworker']) : ($numberofworker = 0));
    	$annualsale = (($_POST['annualsale'] != '') ? ($annualsale = $_POST['annualsale']) : ($annualsale = 0));
    	$productmanufactured = $_POST['productmanufactured'];
    	$estatus = $_POST['status'];
    	$eenterby = $_SESSION['acct_id'];
    	$emodifydate = date("Y-m-d h:i");
    	$emodifyby = $_SESSION['acct_id'];

        $query ="INSERT INTO Entity(EPID, Ename, ERegisteredName, Owner, Supplier, OEMCustomer, NumberofWorker, AnnualSales, ProductManufactured, EStatus, EEnterBy, EModifyDate, EModifyBy) VALUE ($epid, '$ename', '$eregisteredname', '$owner', '$supplier', '$oemcustomer', $numberofworker, $annualsale, '$productmanufactured', '$estatus', $eenterby, '$emodifydate', $emodifyby)";
		if($dbconnect->query($query) == TRUE){
			echo "New Vendor Added";
		}
    	else{
        	echo $query;
        }
}
?>

<script>
$(document).ready(function(){
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