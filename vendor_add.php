<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>
<style>
#contactoptiondisplay{
 display: none;
}
</style>
<span id="alert_action"></span>

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><label>Add New Vendor</label></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
                    <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='vendor.php'">Back</button> 	
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		<div class="panel-body">
		<form method="POST" id="vendor_add_form">
			<table id="vendor_data_basic" class="table table-bordered table-striped">
				<h5><label>Basic Info</label></h5>
				<tr>
					<td width=12%>Parent</td>
					<td width=38%><select name="epid" id="epid" class="selectpicker" data-live-search="true" >
                                    <option value="">Select Parent</option>
                                    <?php echo entity_option_list($dbconnect);?>
                    </select></td>
					<td width=12%># of Employees</td>
            		<td width=38%><input type="number" name="numberofworker" id="numberofworker" class="form-control" min="0" max="2147483647" /></td>
            		
				</tr>
				<tr>
					<td>Vendor Name <span style="color:red">*</span></td>
					<td><input type="text" name="ename" id="ename" class="form-control" required /></td>
					<td>Annual Sales</td>
            		<td><input type="number" name="annualsale" id="annualsale" class="form-control" min="0" max="9007199254740991" /></td>
            		
				</tr>
            	<tr>
					<td>Register As <span style="color:red">*</span></td>
					<td><input type="text" name="eregisteredname" id="eregisteredname" class="form-control" required /></td>
					<td>Supplier Type</td>
            		<td><input type="text" name="supplier" id="supplier" /></td>
				</tr>
            	<tr>
					<td>Owner <span style="color:red">*</span></td>
					<td><input type="text" name="owner" id="owner" class="form-control" required /></td>
            		<td>Products Manufactured</td>
            		<td><input type="text" name="productmanufactured" id="productmanufactured" /></td>

				</tr>
                <tr>
                    <td>Status</td>
					<td><input type="checkbox" name="estatus" id="estatus" value="status" checked> Active</td>
            		<td>OEM Customer</td>
            		<td><input type="text" name="oemcustomer" id="oemcustomer" /></td>

                </tr>
			</table>
			
			<div class="form-group vendoraddress">
			<table id="vendor_data_address" class="table table-bordered table-striped">
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                	<div class="row">
                    	<h5><label>Address</label></h5>
                	</div>
            	</div>
            	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                	<div class="row" align="right">   
                		<button type="button" name="addmoreaddress" id="addmoreaddress"  class="btn btn-success btn-xs">Add Address</button>   		
                	</div>
            	</div>
				<tr>
					<td width=12%>Sub Category</td>
					<td width=38%><input type="text" name="esubaddress[]" id="esubaddress" class="form-control" value="Primary" readonly /></td>
					<td width=12%>City</td>
            		<td><input type="text" name="ecity[]" id="ecity" class="form-control" /></td>
				</tr>
				<tr>
					<td>Address 1<span style="color:red">*</span></td>
					<td><input type="text" name="eaddress1[]" id="eaddress1" class="form-control" required /></td>
					<td>State</td>
            		<td><input type="text" name="estate[]" id="estate" class="form-control" /></td>
				</tr>
				<tr>
					<td>Address 2</td>
					<td><input type="text" name="eaddress2[]" id="eaddress2" class="form-control"  /></td>
					<td>Country</td>
            		<td><input type="text" name="ecountry[]" id="ecountry" class="form-control" /></td>
				</tr>
				<tr>
					<td>PO Box</td>
					<td><input type="text" name="epobox[]" id="epobox" class="form-control" /></td>
					<td>Zip Code</td>
					<td><input type="text" name="ezip[]" id="ezip" class="form-control"  /></td>
				</tr>
			</table>
			</div>

			<div class="form-group vendoremail">
			<table id="vendor_data_email" class="table table-bordered table-striped">
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                	<div class="row">
                		<h5><label>Email</label></h5>
                	</div>
            	</div>
            	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                	<div class="row" align="right">   
                		<button type="button" name="addmoreemail" id="addmoreemail"  class="btn btn-success btn-xs">Add Email</button>   		
                	</div>
            	</div>
				<tr>
					<td width=12%>Sub Category</td>
					<td width=38%><input type="text" name="esubemail[]" id="esubemail" class="form-control" value="Primary" readonly /></td>
					<td width=12%>Email <span style="color:red">*</span></td>
            		<td width=38%><input type="email" name="eemail[]" id="eemail" class="form-control" required /></td>
				</tr>
			</table>
			</div>

			<div class="form-group vendorphone">
			<table id="vendor_data_phone" class="table table-bordered table-striped">
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                	<div class="row">
                		<h5><label>Phone</label></h5>
                	</div>
            	</div>
            	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                	<div class="row" align="right">   
                		<button type="button" name="addmorephone" id="addmorephone"  class="btn btn-success btn-xs">Add Phone</button>   		
                	</div>
            	</div>
				<tr>
					<td width=12%>Sub Category</td>
					<td width=38%><input type="text" name="esubphone[]" id="esubphone" class="form-control" value="Primary" readonly /></td>
					<td width=12%>Phone <span style="color:red">*</span></td>
            		<td width=38%><input type="number" name="ephone[]" id="ephone" class="form-control" required /></td>
				</tr>
			</table>
			</div>

		</form>
	
			<!-- ANOTHER FORM OF ADDRESS, EMAIL, PHONE -->
			<div class="form-group vendoraddresscopy" style="display: none;">
			<table id="vendor_data_address" class="table table-bordered table-striped" >
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	</div>
            	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                	<div class="row" align="right">   
                		<button type="button" name="removeaddress" id="removeaddress"  class="btn btn-danger btn-xs">Remove Address</button>   		
                	</div>
            	</div>
				<tr>
					<td width=12%>Sub Category</td>
					<td width=38%><input type="text" name="esubaddress[]" id="esubaddress" class="form-control" placeholder="Alternative Address" /></td>
					<td width=12%>City</td>
            		<td><input type="text" name="ecity[]" id="ecity" class="form-control" /></td>
				</tr>
				<tr>
					<td>Address 1<span style="color:red">*</span></td>
					<td><input type="text" name="eaddress1[]" id="eaddress1" class="form-control" required /></td>
					
					<td>State</td>
            		<td><input type="text" name="estate[]" id="estate" class="form-control" /></td>
				</tr>
				<tr>
					<td>Address 2</td>
					<td><input type="text" name="eaddress2[]" id="eaddress2" class="form-control"  /></td>
					<td>Country</td>
            		<td><input type="text" name="ecountry[]" id="ecountry" class="form-control" /></td>
				</tr>
				<tr>
					<td>PO Box</td>
					<td><input type="text" name="epobox[]" id="epobox" class="form-control" /></td>
					<td>Zip Code</td>
					<td><input type="text" name="ezip[]" id="ezip" class="form-control"  /></td>
				</tr>
			</table>
			</div>

			<div class="form-group vendoremailcopy" style="display: none;">
			<table id="vendor_data_email" class="table table-bordered table-striped">
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	</div>
            	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                	<div class="row" align="right">   
                		<button type="button" name="removeemail" id="removeemail"  class="btn btn-danger btn-xs">Remove Email</button>   		
                	</div>
            	</div>
				<tr>
					<td width=12%>Sub Category</td>
					<td width=38%><input type="text" name="esubemail[]" id="esubemail" class="form-control" placeholder="Alternative Email" /></td>
					<td width=12%>Email <span style="color:red">*</span></td>
            		<td width=38%><input type="email" name="eemail[]" id="eemail" class="form-control" required /></td>
				</tr>
			</table>
			</div>
			
			<div class="form-group vendorphonecopy" style="display: none;">
			<table id="vendor_data_phone" class="table table-bordered table-striped">
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	</div>
            	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                	<div class="row" align="right">   
                		<button type="button" name="removephone" id="removephone"  class="btn btn-danger btn-xs">Remove Phone</button>   		
                	</div>
            	</div>
				<tr>
					<td width=12%>Sub Category</td>
					<td width=38%><input type="text" name="esubphone[]" id="esubphone" class="form-control" placeholder="Alternative Phone" /></td>
					<td width=12%>Phone <span style="color:red">*</span></td>
            		<td width=38%><input type="number" name="ephone[]" id="ephone" class="form-control" required /></td>
				</tr>
			</table>
			</div>

			<input type="submit" name="Add" id="Add" form="vendor_add_form" class="btn btn-info" value="Add" />
            <input type="reset" name="reset" id="reset" form="vendor_add_form" class="btn btn-warning" value="Reset" />
		</div>
	</div>
	
<?php
if(isset($_POST['Add'])){
	$addressresult; $emailresult; $phoneresult;
	$estatus = '';
	if(empty($_POST['estatus'])){
    	$estatus = 'InActive';
    }
	else{
    	$estatus = 'Active';
    }
    $epid = (($_POST['epid'] != '') ? ($epid = $_POST['epid']) : ($epid = 0));
    $ename = $_POST['ename'];
    $eregisteredname = $_POST['eregisteredname'];
    $owner = $_POST['owner'];
    $supplier = (($_POST['supplier'] != '') ? ($supplier = $_POST['supplier']) : ($supplier = ""));
    $oemcustomer = (($_POST['oemcustomer'] != '') ? ($oemcustomer = $_POST['oemcustomer']) : ($oemcustomer = ""));
    $numberofworker = (($_POST['numberofworker'] != '') ? ($numberofworker = $_POST['numberofworker']) : ($numberofworker = 0));
    $annualsale = (($_POST['annualsale'] != '') ? ($annualsale = $_POST['annualsale']) : ($annualsale = 0));
    $productmanufactured = $_POST['productmanufactured'];
    $eenterby = $_SESSION['acct_id'];
    $emodifydate = date("Y-m-d h:i");
    $emodifyby = $_SESSION['acct_id'];

	$subaddressArr = $_POST['esubaddress'];
	$address1Arr = $_POST['eaddress1'];
	$address2Arr = $_POST['eaddress2'];
	$cityArr = $_POST['ecity'];
	$stateArr = $_POST['estate'];
	$countryArr = $_POST['ecountry'];
	$zipArr = $_POST['ezip'];
	$poboxArr = $_POST['epobox'];
	$subemailArr = $_POST['esubemail'];
	$emailArr = $_POST['eemail'];
	$subphoneArr = $_POST['esubphone'];
	$phoneArr = $_POST['ephone'];

    $query ="INSERT INTO Entity(EPID, Ename, ERegisteredName, Owner, Supplier, OEMCustomer, NumberofWorker, AnnualSales, ProductManufactured, EStatus, EEnterBy, EModifyDate, EModifyBy) VALUES ($epid, '$ename', '$eregisteredname', '$owner', '$supplier', '$oemcustomer', $numberofworker, $annualsale, '$productmanufactured', '$estatus', $eenterby, '$emodifydate', $emodifyby)";
	if($dbconnect->query($query) == TRUE){
    	$tmpsql = "SELECT MAX(EID) FROM Entity";
    	$tmpresult = $dbconnect->query($tmpsql);
    	while($erow = $tmpresult->fetch_assoc()){
        	$maxeid = $erow['MAX(EID)'];
    		if(!empty($address1Arr)){
    			for($i = 0; $i < count($address1Arr); $i++){
        			if(!empty($address1Arr[$i])){
            			$subaddress = $subaddressArr[$i];
            			$address['address1'] = $address1Arr[$i];
            			$address['address2'] = $address2Arr[$i];
            			$address['city'] = $cityArr[$i];
            			$address['state'] = $stateArr[$i];
            			$address['country'] = $countryArr[$i];
            			$address['zip'] = $zipArr[$i];
            			$address['pobox'] = $poboxArr[$i];
                    	$jsonaddress = json_encode($address);
            			//$jsonaddress = json_encode(array($subaddress." Address".$i => $address));
            			$insertaddress = "INSERT INTO Entity_Attribute VALUES (null, $maxeid, 'address', '$subaddress', '$jsonaddress', 'Active' )";
            			$addressresult = $dbconnect->query($insertaddress);
            		}
        		}
    		}
        	if(!empty($emailArr)){
    			for($i = 0; $i < count($emailArr); $i++){
        			if(!empty($emailArr[$i])){
            			$subemail = $subemailArr[$i];
            			$email = $emailArr[$i];
            			$insertemail = "INSERT INTO Entity_Attribute VALUES (null, $maxeid, 'email', '$subemail', '$email', 'Active')";
            			$emailresult = $dbconnect->query($insertemail);
            		}
        		}
    		}
			if(!empty($phoneArr)){
    			for($i = 0; $i < count($phoneArr); $i++){
        			if(!empty($phoneArr[$i])){
            			$subphone = $subphoneArr[$i];
            			$phone = $phoneArr[$i];
            			$insertphone = "INSERT INTO Entity_Attribute VALUES (null, $maxeid, 'phone', '$subphone', '$phone', 'Active')";
            			$phoneresult = $dbconnect->query($insertphone);
                    }
        		}
    		}
			
        }
    	if($addressresult == true && $emailresult == true && $phoneresult == true){
        	echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">New Vendor Added</div>';
       			 </script>";
        }
	}
    else{
        echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-danger"'.">Query Failed:</div>';
       			 </script>";
    }
	
}
?>

<script>
$(document).ready(function(){

	$("#esubaddress").change(function(){
    	var s = this.value;
        if(s == "Primary" || s== "primary"){
        	alert("wrong");
            $('#esubaddress').val('');
        }
        else{
        	alert(s);
        }
  	});

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

	var maxGroup = 5;
    //add more fields group
    $("#addmoreaddress").click(function(){
        if($('body').find('.vendoraddress').length < maxGroup){
            var fieldHTML = '<div class="form-group vendoraddress">'+$(".vendoraddresscopy").html()+'</div>';
            $('body').find('.vendoraddress:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    //remove fields group
    $("body").on("click","#removeaddress",function(){ 
    	if(confirm("Remove Cannot Be Undo. Are You Sure???")){
       		$(this).parents(".vendoraddress").remove();
        }
    });

	$("#addmoreemail").click(function(){
        if($('body').find('.vendoremail').length < maxGroup){
            var fieldHTML = '<div class="form-group vendoremail">'+$(".vendoremailcopy").html()+'</div>';
            $('body').find('.vendoremail:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    //remove fields group
    $("body").on("click","#removeemail",function(){ 
    	if(confirm("Remove Cannot Be Undo. Are You Sure???")){
        	$(this).parents(".vendoremail").remove();
        }
    });

	$("#addmorephone").click(function(){
        if($('body').find('.vendorphone').length < maxGroup){
            var fieldHTML = '<div class="form-group vendorphone">'+$(".vendorphonecopy").html()+'</div>';
            $('body').find('.vendorphone:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    //remove fields group
    $("body").on("click","#removephone",function(){ 
    	if(confirm("Remove Cannot Be Undo. Are You Sure???")){
        	$(this).parents(".vendorphone").remove();
        }
    });


});
</script>

<?php
include ('footer.php');
?>