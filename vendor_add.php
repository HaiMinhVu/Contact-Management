<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>
<?php
	$vendors = array();
	$vendornamesql = "SELECT EName FROM PD_Entity";
	$vendornameresult = $dbconnect->query($vendornamesql);
	while($row = $vendornameresult->fetch_assoc()){
    	array_push($vendors, $row['EName']);
    }
	
?>
	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><label>Add New Vendor</label></h3>
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
					<td><input type="text" name="ename" id="ename" class="form-control" required /><span id="hintvendorname"></span></td>
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
			
		<!------------- address group ----------------->
			<div class="form-group vendoraddress">
			<table id="vendor_data_address" class="table table-bordered table-striped">
				<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                	<div class="row">
                    	<h5><label>Address Detail</label></h5>
                	</div>
            	</div>
            	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                	<div class="row" align="right">   
                		<button type="button" name="addmoreaddress" id="addmoreaddress"  class="btn btn-success btn-xs">Add Address</button>   		
                	</div>
            	</div>
				<tr>
					<td width=12%>Sub Category</td>
					<td width=38%><input type="text" name="esubaddress[]" id="esubaddress" class="form-control" value="Primary" readonly   /></td>
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

		<!------------- email group ----------------->
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

		<!------------- phone group ----------------->
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
					<td width=38%><input type="text" name="esubphone[]" id="esubphone" class="form-control" value="Primary" readonly  /></td>
					<td width=12%>Phone <span style="color:red">*</span></td>
            		<td width=38%><input type="number" name="ephone[]" id="ephone" class="form-control" required /></td>
				</tr>
			</table>
			</div>

		</form>
		<span id="alert_action"></span>
		<!----------------------- ANOTHER FORM OF ADDRESS, EMAIL, PHONE ------------------------->
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
					<td width=38%><input type="text" name="esubaddress[]" id="esubaddresscopy" class="form-control" placeholder="Alternative Address"  onchange="check_prim_address()"  /></td>
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
					<td width=38%><input type="text" name="esubemail[]" id="esubemailcopy" class="form-control" placeholder="Alternative Email" onchange="check_prim_email()" /></td>
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
					<td width=38%><input type="text" name="esubphone[]" id="esubphonecopy" class="form-control" placeholder="Alternative Phone" onchange="check_prim_phone()" /></td>
					<td width=12%>Phone <span style="color:red">*</span></td>
            		<td width=38%><input type="number" name="ephone[]" id="ephone" class="form-control" required /></td>
				</tr>
			</table>
			</div>
			<div style="text-align:center">
				<input type="submit" name="Add" id="Add" form="vendor_add_form" class="btn btn-success" value="Save & Add More" />
				&nbsp;
				<input type="submit" name="Save" id="Save" form="vendor_add_form" class="btn btn-info" value="Save" />
                &nbsp;
            	<input type="reset" name="reset" id="reset" form="vendor_add_form" class="btn btn-warning" value="Reset" />
			</div>
		</div>
	</div>

<script>
function check_prim_address(){
	var num = document.querySelectorAll("#esubaddresscopy");
	var i;
	for(i = 0; i < num.length-1; i++){
    	var prim = num[i].value;
    	if(prim=="Primary" || prim=="primary"){
        	alert("Cannot be Primary Type");
        	num[i].value = "";
        }
    }
    
}
function check_prim_email(){
    var num = document.querySelectorAll("#esubemailcopy");
    var i;
    for(i = 0; i < num.length-1; i++){
        var prim = num[i].value;
        if(prim=="Primary" || prim=="primary"){
            alert("Cannot be Primary Type");
            num[i].value = "";
        }
    }
}
function check_prim_phone(){
    var num = document.querySelectorAll("#esubphonecopy");
    var i;
    for(i = 0; i < num.length-1; i++){
        var prim = num[i].value;
        if(prim=="Primary" || prim=="primary"){
            alert("Cannot be Primary Type");
            num[i].value = "";
        }
    }
}

</script>
<script>
$(document).ready(function(){
	
	// hint for vendor name
	var vendors = <?php echo json_encode($vendors)?>;
	$('#ename').keyup(function(){
    	var vendor = $('#ename').val();
    	if (jQuery.inArray(vendor, vendors)!='-1'){
        	$('#hintvendorname').fadeIn().html('<div>Vendor Name has been used</div>');
        }
    	else{
        	$('#hintvendorname').fadeIn().html('<div>Ok Vendor Name</div>');
        	$('#hintvendorname').fadeOut(1000);
        }
    });
	
	var action;
	$('#Add').click(function(){
    	action = "addmore";
    });
	$('#Save').click(function(){
    	action = "save";
    });

	$('#vendor_add_form').submit(function(event){
        event.preventDefault();
        var data = $(this).serialize()+"&action="+action;
        $.ajax({
           	type:"post",
           	url:"vendor_action.php",
           	data:data,
           	success: function(mess){
               	$('#alert_action').fadeIn().html('<div class="alert alert-info">'+mess+'</div>');
               	if(action == "addmore"){
                   	window.setTimeout(function(){location.reload()},2000)
                }
               	if(action == "save"){
                   	window.setTimeout(function(){location.replace("vendor.php")},2000)
                }
           	}
        });
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
        $(this).parents(".vendoraddress").remove();
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
        $(this).parents(".vendoremail").remove();
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
        $(this).parents(".vendorphone").remove();
    });


});
</script>

<?php
include ('footer.php');
?>