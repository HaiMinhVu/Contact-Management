<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>

<p id="response"></p>
	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><label>Add New Contact</label></h3>
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
			<form method="POST" id="vendorcontact_add_form">
			<table id="add_contact" class="table table-bordered table-striped">
				<h5><label>General Info</label></h5>
				<tr>
					<td width=20%>Name</td>
					<td><input type="text" name="ecname" id="ecname" class="form-control" placeholder="john" required /></td>
				</tr>
				<tr>
					<td width=20%>Email</td>
					<td><input type="email" name="ecemail" id="ecemail" class="form-control" placeholder="john@email.com" required /></td>
				</tr>
            	<tr>
					<td width=20%>Phone</td>
					<td><input type="number" name="ecphone" id="ecphone" class="form-control" placeholder="1234567890" required /></td>
				</tr>
            	<tr>
					<td width=20%>Fax</td>
					<td><input type="number" name="ecfax" id="ecfax" class="form-control" placeholder="1234567890" /></td>
				</tr>
            	<tr>
					<td width=20%>Website</td>
					<td><input type="text" name="ecwebsite" id="ecwebsite" placeholder="www.john.com" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Address 1</td>
					<td><input type="text" name="ecaddress1" id="ecaddress1" class="form-control" required /></td>
				</tr>
            	<tr>
					<td width=20%>Address 2</td>
					<td><input type="text" name="ecaddress2" id="ecaddress2" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>City</td>
					<td><input type="text" name="eccity" id="eccity" class="form-control" required /></td>
				</tr>
            	<tr>
					<td width=20%>State</td>
					<td><input type="text" name="ecstate" id="ecstate" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Zipcode</td>
					<td><input type="text" name="eczip" id="eczip" class="form-control"  /></td>
				</tr>
            	<tr>
					<td width=20%>Country</td>
					<td><input type="text" name="eccountry" id="eccountry" class="form-control" required /></td>
				</tr>
            	
			</table>

			<table id="add_contact_relation" class="table table-bordered table-striped">
				<h5><label>Related To</label></h5>
				<tr>
					<td width=20%>Select Vendor</td>
					<td><select name="eid" id="eid" class="selectpicker" data-live-search="true" required>
                                    <option value="">Select Vender</option>
                                    <?php echo entity_option_list($dbconnect);?>
                    </select></td>
				</tr>
				<tr>
					<td width=20%>Priority</td>
					<td><select name="priority" id="priority" class="selectpicker" data-live-search="true" required>
                                    <option value="">Select Priority</option>
                                    <option value="Primary Contact">Primary Contact</option>
                                    <option value="Alternative Contact">Alternative Contact</option>
                    </select></td>
				</tr>
				<tr>
					<td width=20%>Title</td>
					<td><input type="text" name="erctitle" id="erctitle" class="form-control" required /></td>
				</tr>
				<tr>
					<td >Status</td>
            		<td><input type="checkbox" name="ecpstatus" id="ecpstatus" value="status" checked> Active</td>
				</tr>
			</table>
			<div style="text-align:center">
				<span id="alert_action"></span>
            	<input type="submit" name="Add" id="Add" class="btn btn-success" value="Save & Add More" />
				<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            	<input type="button" name="reset" id="reset" class="btn btn-warning" value="Reset" onClick="window.location.reload()" />
			</div>
			</form>
		</div>
	</div>




<script>
$(document).ready(function(){
	
	var action;
	$('#Add').click(function(){
    	action = "addmore";
    });
	$('#Save').click(function(){
    	action = "save";
    });

	$('#vendorcontact_add_form').submit(function(event){
        event.preventDefault();
        var data = $(this).serialize()+"&action="+action;
        $.ajax({
            type:"post",
            url:"vendorcontact_action.php",
            data:data,
            success: function(mess){
                $('#alert_action').fadeIn().html('<div class="alert alert-info">'+mess+'</div>');
                if(action == "addmore"){
                    window.setTimeout(function(){location.reload()},2000)
                }
                if(action == "save"){
                 	window.setTimeout(function(){location.replace("vendorcontact.php")},2000)
                }	
            }
        });
    });
});
</script>

<?php
include ('footer.php');
?>