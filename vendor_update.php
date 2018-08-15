<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$eid =$_GET['eid'];
$status; $epid;
$eaidadd = array();
$eaidemail = array();
$eaidphone = array();
?>
	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h5 class="panel-title"><label>Vendor Update</label></h5>
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
		<form method="POST" id="vendor_update_form">
			<?php
            $entitysql = "SELECT * FROM PD_Entity e INNER JOIN PD_DB_Account sma ON sma.AcctID = e.EEnterBy WHERE e.EID = $eid";
			$entityfetch = $dbconnect->query($entitysql);
			while($row = $entityfetch->fetch_array()){
            	$status = $row['EStatus'];
            	$epid = $row['EPID'];
            ?>

        <!-- -------------- Edit General Info ---------------- -->
			<table id="samplerecord_data" class="table table-bordered table-striped">
            	<h5><label>General Info</label></h5>
				<tr>
					<td width=12%>Vendor Name</td>
					<td width=38%><input type="text" name="ename" id="ename" value="<?php echo $row['EName'];?>" class="form-control" required /></td>
            		<td width=12%>Parent</td>
					<td><select name="epid" id="epid" class="selectpicker" data-live-search="true" >
                                    <option value="">Select Parent</option>
                                    <?php echo entity_option_list($dbconnect);?>
                                </select></td>
				</tr>
				<tr>
					<td>Register As </td>
					<td><input type="text" name="eregisteredname" id="eregisteredname" value="<?php echo $row['ERegisteredName'];?>" class="form-control" required /></td>
            		<td>Supplier Type</td>
            		<td><input type="text" name="supplier" id="supplier" value="<?php echo $row['Supplier'];?>" /></td>
				</tr>
            	<tr>
					<td>Owner </td>
					<td><input type="text" name="owner" id="owner" value="<?php echo $row['Owner'];?>" class="form-control" required/></td>
            		<td>Products Manufactured</td>
            		<td><input type="text" name="productmanufactured" id="productmanufactured" value="<?php echo $row['ProductManufactured'];?>" /></td>
				</tr>
            	<tr>
					<td>Last Modify</td>
					<td><?php echo date('Y-m-d H:i', strtotime($row['EModifyDate'])) ;?></td>
            		<td>OEM Customer</td>
            		<td><input type="text" name="oemcustomer" id="oemcustomer" value="<?php echo $row['OEMCustomer'];?>" /></td>
				</tr>
            	<tr>
            		<?php
					$modifybyid = $row['EModifyBy'];
    				$modifybyresult = $dbconnect->query("SELECT username FROM PD_DB_Account WHERE AcctID = $modifybyid");
    				while($modifyrow = $modifybyresult->fetch_assoc()){
            		?>
					<td>Modify By</td>
					<td><?php echo $modifyrow['username'];?></td>
                    <?php
                    }
                    ?>
                    <td># of Employees</td>
            		<td><input type="number" name="numberofworker" id="numberofworker" value="<?php echo $row['NumberofWorker'];?>" class="form-control" min="0" max="2147483647" /></td>
				</tr>
            	<tr>
                    <td>Enter By</td>
					<td><?php echo $row['username'];?></td>
                    <td>Annual Sales</td>
            		<td><input type="number" name="annualsale" id="annualsale" value="<?php echo $row['AnnualSales'];?>" class="form-control" min="0" max="9007199254740991"/></td>
				</tr>
                <tr>
                    <td>Status</td>
					<td><input type="checkbox" name="estatus" id="estatus" value="status"> Active</td>
                </tr>
			</table>
            <?php
            }
            ?>
            
        <!-- -------------- Edit Address ---------------- -->
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
                  
            <?php
            $retrieveaddress = 'SELECT * FROM PD_Entity_Attribute WHERE EID = '.$eid.' AND EACategory = "address" AND EAStatus = "Active" ORDER BY NOT (EASubCategory="Primary") ASC';
			$resultaddress = $dbconnect->query($retrieveaddress);
			while($addrow = $resultaddress->fetch_assoc()){
            	array_push($eaidadd, $addrow['EAID']);
				$jsonaddress = json_decode($addrow['EAString']);
            ?>
			<div class="form-group vendoraddress">
			<table id="vendor_data_address" class="table table-bordered table-striped">    
            	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	</div>
            	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                	<div class="row" align="right">  
            			<?php
            			if($addrow['EASubCategory'] != "Primary"){
            			?>
                		<button type="button" name="removeaddress" id="removeaddress"  class="btn btn-danger btn-xs">Remove Address</button>   	
                        <?php
                        }
                        ?>
                	</div>
            	</div>
                <input type="hidden" name="eaidaddress[]" id="eaidaddress" class="form-control" value="<?php echo $addrow['EAID'] ;?>"/>
				<tr>
					<td width=12%>Sub Category</td>
                    <?php
                    if($addrow['EASubCategory'] == "Primary"){
                    ?>
					<td width=38%><input type="text" name="esubaddress[]" id="esubaddress" class="form-control" value="<?php echo $addrow['EASubCategory'] ;?>" readonly/></td>
                    <?php
                    }else{
                    ?>
                    <td width=38%><input type="text" name="esubaddress[]" id="esubaddress" class="form-control" value="<?php echo $addrow['EASubCategory'] ;?>" onchange="check_prim_add()" /></td>
                    <?php
                    }
                    ?>
					<td width=12%>City</td>
            		<td width=38%><input type="text" name="ecity[]" id="ecity" class="form-control" value="<?php echo $jsonaddress->city; ?>" /></td>
				</tr>
				<tr>
					<td><span style="color:red">*</span> Address 1</td>
					<td><input type="text" name="eaddress1[]" id="eaddress1" class="form-control" value="<?php echo $jsonaddress->address1 ;?>" required /></td>
					<td>State</td>
            		<td><input type="text" name="estate[]" id="estate" class="form-control" value="<?php echo $jsonaddress->state; ?>" /></td>
				</tr>
				<tr>
					<td>Address 2</td>
					<td><input type="text" name="eaddress2[]" id="eaddress2" class="form-control" value="<?php echo $jsonaddress->address2; ?>"  /></td>
					<td>Country</td>
            		<td><input type="text" name="ecountry[]" id="ecountry" class="form-control" value="<?php echo $jsonaddress->country; ?>" /></td>
				</tr>
				<tr>
					<td>PO Box</td>
					<td><input type="text" name="epobox[]" id="epobox" class="form-control" value="<?php echo $jsonaddress->pobox; ?>" /></td>
					<td>Zip Code</td>
					<td><input type="text" name="ezip[]" id="ezip" class="form-control" value="<?php echo $jsonaddress->zip; ?>" /></td>
				</tr>
			</table>
			
			</div>
            <?php
            }
            ?>
            
        <!-- --------------- Edit Email ------------- -->
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
            <?php
            $retrieveemail = 'SELECT * FROM PD_Entity_Attribute WHERE EID = '.$eid.' AND EACategory = "email" AND EAStatus = "Active" ORDER BY NOT (EASubCategory="Primary") ASC';
			$resultemail = $dbconnect->query($retrieveemail);
			while($emailrow = $resultemail->fetch_assoc()){
            	array_push($eaidemail, $emailrow['EAID']);
            ?>
            <div class="form-group vendoremail">
			<table id="vendor_data_email" class="table table-bordered table-striped">
            	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	</div>
            	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                	<div class="row" align="right">  
            			<?php
            			if($emailrow['EASubCategory'] != "Primary"){
            			?>
                		<button type="button" name="removeemail" id="removeemail"  class="btn btn-danger btn-xs">Remove Email</button>   	
                        <?php
                        }
                        ?>
                	</div>
            	</div>
                <input type="hidden" name="eaidemail[]" id="eaidemail" class="form-control" value="<?php echo $emailrow['EAID'] ;?>"/>
				<tr>
					<td width=12%>Sub Category</td>
                    <?php
                    if($emailrow['EASubCategory'] == "Primary"){
                    ?>
					<td width=38%><input type="text" name="esubemail[]" id="esubemail" class="form-control" value="<?php echo $emailrow['EASubCategory'] ;?>" readonly /></td>
                    <?php
                    }else{
                    ?>
                    <td width=38%><input type="text" name="esubemail[]" id="esubemail" class="form-control" value="<?php echo $emailrow['EASubCategory'] ;?>" onchange="check_prim_e()"/></td>
                    <?php
                    }
                    ?>
					<td width=12%><span style="color:red">*</span> Email</td>
            		<td width=38%><input type="email" name="eemail[]" id="eemail" class="form-control" value="<?php echo $emailrow['EAString'] ;?>" required /></td>
				</tr>
			</table>
			</div>
            <?php
            }
            ?>
            
        <!-- -------------- Edit Phone ----------------- -->
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
            <?php
            $retrievephone = 'SELECT * FROM PD_Entity_Attribute WHERE EID = '.$eid.' AND EACategory = "phone" AND EAStatus = "Active" ORDER BY NOT (EASubCategory="Primary") ASC';
			$resultphone = $dbconnect->query($retrievephone);
			while($phonerow = $resultphone->fetch_assoc()){
            	array_push($eaidphone, $phonerow['EAID']);
            ?>
            <div class="form-group vendorphone">
			<table id="vendor_data_phone" class="table table-bordered table-striped">
            	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	</div>
            	<div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                	<div class="row" align="right">  
            			<?php
            			if($phonerow['EASubCategory'] != "Primary"){
            			?>
                		<button type="button" name="removephone" id="removephone"  class="btn btn-danger btn-xs">Remove Phone</button>   	
                        <?php
                        }
                        ?>
                	</div>
            	</div>
                <input type="hidden" name="eaidphone[]" id="eaidphone" class="form-control" value="<?php echo $phonerow['EAID'] ;?>"/>
				<tr>
					<td width=12%>Sub Category</td>
                    <?php
                    if($phonerow['EASubCategory'] == "Primary"){
                    ?>
					<td width=38%><input type="text" name="esubphone[]" id="esubphone" class="form-control" value="<?php echo $phonerow['EASubCategory'] ;?>" readonly /></td>
                    <?php
                    }else{
                    ?>
                    <td width=38%><input type="text" name="esubphone[]" id="esubphone" class="form-control" value="<?php echo $phonerow['EASubCategory'] ;?>" onchange="check_prim_p()"/></td>
                    <?php
                    }
                    ?>
					<td width=12%><span style="color:red">*</span> Phone</td>
            		<td width=38%><input type="number" name="ephone[]" id="ephone" class="form-control" value="<?php echo $phonerow['EAString'] ;?>" required /></td>
				</tr>
			</table>
			</div>
            <?php
            }
            ?>
        </form>
		
        <!--------------------- COPY FORM OF ADDRESS, EMAIL, PHONE ---------------------------->
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
					<td width=38%><input type="text" name="esubaddresscopy[]" id="esubaddresscopy" class="form-control" placeholder="Alternative Address" onchange="check_prim_address()" /></td>
					<td width=12%>City</td>
            		<td><input type="text" name="ecitycopy[]" id="ecitycopy" class="form-control" /></td>
				</tr>
				<tr>
					<td><span style="color:red">*</span> Address 1</td>
					<td><input type="text" name="eaddress1copy[]" id="eaddress1copy" class="form-control" required /></td>
					
					<td>State</td>
            		<td><input type="text" name="estatecopy[]" id="estatecopy" class="form-control" /></td>
				</tr>
				<tr>
					<td>Address 2</td>
					<td><input type="text" name="eaddress2copy[]" id="eaddress2copy" class="form-control"  /></td>
					<td>Country</td>
            		<td><input type="text" name="ecountrycopy[]" id="ecountrycopy" class="form-control" /></td>
				</tr>
				<tr>
					<td>PO Box</td>
					<td><input type="text" name="epoboxcopy[]" id="epoboxcopy" class="form-control" /></td>
					<td>Zip Code</td>
					<td><input type="text" name="ezipcopy[]" id="ezipcopy" class="form-control"  /></td>
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
					<td width=38%><input type="text" name="esubemailcopy[]" id="esubemailcopy" class="form-control" placeholder="Alternative Email" onchange="check_prim_email()" /></td>
					<td width=12%><span style="color:red">*</span> Email</td>
            		<td width=38%><input type="email" name="eemailcopy[]" id="eemailcopy" class="form-control" required /></td>
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
					<td width=38%><input type="text" name="esubphonecopy[]" id="esubphonecopy" class="form-control" placeholder="Alternative Phone" onchange="check_prim_phone()" /></td>
					<td width=12%><span style="color:red">*</span> Phone</td>
            		<td width=38%><input type="number" name="ephonecopy[]" id="ephonecopy" class="form-control" required /></td>
				</tr>
			</table>
			</div>
            <div style="text-align:center">
            	<span id="alert_action"></span>
            	<input type="submit" name="Save" id="Save" form="vendor_update_form" class="btn btn-info" value="Save" />
            	<input type="button" name="Reset" id="Reset"  class="btn btn-warning" value="Reset" onClick="window.location.reload()"/>
            </div>
		</div>
	</div>
         
<script>
function check_prim_add(){
    var num = document.querySelectorAll("#esubaddress");
    var i;
    for(i = 1; i < num.length; i++){
        var prim = num[i].value;
        if(prim=="Primary" || prim=="primary"){
            alert("Cannot be Primary Type");
            num[i].value = "";
        }
    }
}
function check_prim_e(){
    var num = document.querySelectorAll("#esubemail");
    var i;
    for(i = 1; i < num.length; i++){
        var prim = num[i].value;
        if(prim=="Primary" || prim=="primary"){
            alert("Cannot be Primary Type");
            num[i].value = "";
        }
    }
}
function check_prim_p(){
    var num = document.querySelectorAll("#esubphone");
    var i;
    for(i = 1; i < num.length; i++){
        var prim = num[i].value;
        if(prim=="Primary" || prim=="primary"){
            alert("Cannot be Primary Type");
            num[i].value = "";
        }
    }
}
function check_prim_address(){
    var num = document.querySelectorAll("#esubaddresscopy");
    var i;
    for(i = 0; i < num.length-1; i++){
        var prim = num[i].value;
        if(prim=="Primary" || prim=="primary"){
            alert("Cannot be Primary Type");
            num[i+i].value = "";
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

<?php     

    
?>
<script>
function reloadfunction() {
    location.reload();
}

$(document).ready(function(){

	$('#ecity, #eaddress1, #estate, #eaddress2, #ecountry, #epobox, #ezip, #ecitycopy, #eaddress1copy, #estatecopy, #eaddress2copy, #ecountrycopy, #epoboxcopy, #ezipcopy').keypress(function(e){
    	if(e.which == 39 || e.which == 34 || e.which == 92){
    		return false;
    	}
  	});
	
	$('#vendor_update_form').submit(function(event){
       	event.preventDefault();
    	var action="save_update";
       	var eid = "<?php print_r($eid);?>";
       	var data = $(this).serialize()+"&action="+action+"&eid="+eid;
       	$.ajax({
           	type:"post",
           	url:"vendor_action.php",
           	data:data,
           	success: function(mess){
               	$('#alert_action').fadeIn().html('<div class="alert alert-info">'+mess+'</div>');
               	window.setTimeout(function(){location.reload()},2000)
           	}
       	});
    });


	var estatus = "<?php echo $status; ?>";
	if(estatus == "Active"){
    	$('#estatus').prop("checked", true);
    }
	else{
    	$('#estatus').prop("checked", false);
    }
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
	

	var maxGroup = 5;

    $("#addmoreaddress").click(function(){
        if($('body').find('.vendoraddress').length < maxGroup){
            var fieldHTML = '<div class="form-group vendoraddress">'+$(".vendoraddresscopy").html()+'</div>';
            $('body').find('.vendoraddress:last').after(fieldHTML);
        	$('#ecitycopy, #eaddress1copy, #estatecopy, #eaddress2copy, #ecountrycopy, #epoboxcopy, #ezipcopy').keypress(function(e){
    	if(e.which == 39 || e.which == 34 || e.which == 92){
    		return false;
    	}
  	});
        }else{
            alert('Maximum 5 Addresses are allowed.');
        }
    });
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
            alert('Maximum 5 Emails are allowed.');
        }
    });
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
            alert('Maximum 5 Phones are allowed.');
        }
    });
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