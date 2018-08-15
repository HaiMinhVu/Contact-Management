<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$projectid =$_GET['project_id'];
$progress; $status; $empid;
$sidarray = array();
$p_require_s = "SELECT SID FROM PD_Project_Require_Sample WHERE ProjectID = $projectid";
$p_require_s_result = $dbconnect->query($p_require_s);
while($sidrow = $p_require_s_result->fetch_assoc()){
	array_push($sidarray, $sidrow['SID']);
}
?>

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Project Update</font></h3>
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
			<div id="reopen" style="text-align:center; display:none;">
            	<button name="reopenclick" id="reopenclick" class="btn btn-success">Re-Open</button>
            </div>
			<?php
			$projectsql = "SELECT * FROM PD_Project JOIN PD_DB_Account ON EnterBy = AcctID WHERE ProjectID = $projectid";
			$projectfetch = $dbconnect->query($projectsql);
			while($row = $projectfetch->fetch_assoc()){
            $progress = $row['Progress'];
            $status = $row['ProjectStatus'];
            $empid = $row['ProjectLead'];
            $modifybyid = $row['ModifyBy'];
			?>
            <form method="POST" id="project_update_form">
			<table id="project_data" class="table table-bordered table-striped" >
				<tr>
					<td width=20%>Project Name</td>
					<td><input type="text" name="project_name" id="project_name" value="<?php echo $row['ProjectName'];?>" class="form-control" required/></td>
				</tr>
				<tr>
					<td >Description</td>
            		<td><textarea rows="3" name="project_description" id="project_description" class="form-control" ><?php echo $row['ProjectDescription'];?></textarea></td>
					
				</tr>
            	<tr>
					<td >Date Created</td>
            		<td><?php echo date('Y-m-d H:i', strtotime($row['DateCreated'])) ;?></td>
				</tr>
            	<tr>
					<td>Created By</td>
					<td><?php echo $row['username'] ;?></td>
				</tr>
            	<tr>
					<td>Start Date</td>
            		<td><input type="date" name="startdate" id="startdate" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['StartDate'])) ;?>"  /></td>
				</tr>
            	<tr>
					<td >Estimate End Date</td>
            		<td><input type="date" name="estcompletedate" id="estcompletedate" value="<?php echo date('Y-m-d', strtotime($row['EstEndDate'])) ;?>" class="form-control"  /></td>
				</tr>
            	<tr>
					<td>End Date</td>
            		<td><input type="date" name="completedate" id="completedate" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['EndDate'])) ;?>" /></td>
				</tr>
                <tr>
                    <td >Project Lead</td>
                    <td><select name="project_lead" id="project_lead" class="selectpicker" data-live-search="true" required>
                        <option value="">Select Leader</option>
                        <?php echo employee_option_list($dbconnect);?>
                    </select>
            		<button type="button" name="addleader" id="addleader" class="btn btn-success btn-xs" >Add</button> </td>
                </tr>
            	<tr>
					<td>Progress</td>
            		<td><select name="progress" id="progress" class="selectpicker" data-live-search="true"  >
                    	<option value="">Select Progress</option>
                    	<option value="Complete">Complete</option>
                        <option value="InComplete">InComplete</option>
                    </select></td>
				</tr>
            	<tr>
					<td >Modify Date</td>
            		<td><?php echo date('Y-m-d H:i', strtotime($row['ModifyDate'])) ;?></td>
				</tr>
            	<tr>
					<td >Modify By</td>
            		<?php
            		$modifyidsql = $dbconnect->query("SELECT username FROM PD_DB_Account WHERE AcctID = $modifybyid");
					while($modifyidrow = $modifyidsql->fetch_assoc()){
            		?>
            		<td><?php echo $modifyidrow['username'] ;?></td>
                    <?php
                    }
                    ?>
				</tr>
                <tr>
					<td>Select Sample</td>
            		<td><select name="sampleid[]" id="sampleid" multiple class="selectpicker" data-live-search="true" data-width="fit" required>
                    	<?php echo sample_option_list($dbconnect);?>
                    </select>
                    <button type="button" name="addsample" id="addsample" class="btn btn-success btn-xs" onclick="window.location.href='sample_add.php'">Add</button></td></td>
				</tr>
                <tr>
					<td>Status</td>
            		<td><input type="checkbox" name="projectstatus" id="projectstatus" value="status"> Active</td>
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
           
<!------------------------ Add Employee Modal ------------------------------>
    <div id="projectlead_add" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="projectlead_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i>Employee</h4>
    				</div>
    				<div class="modal-body">
    					<div class="form-group">
    						<label>Employee Name</label>
							<input type="text" name="employeename" id="employeename" class="form-control" required />
    					</div>
    					<div class="form-group">
							<label>Employee Title</label>
							<input type="text" name="employeetitle" id="employeetitle" class="form-control"  required />
						</div>
                        <div class="form-group">
							<label>Manager</label>
							<select name="manager" id="manager" class="selectpicker" data-width="fit" data-live-search="true" >
                    			<option value="">Select Leader</option>
                    			<?php echo employee_option_list($dbconnect);?>
                    		</select>
						</div>
                         <div class="form-group">
							<label>Work Type</label>
							<input type="text" name="worktype" id="worktype" class="form-control" placeholder="Full Time / Part Time" required/>
						</div>
    				</div>
                    <div class="modal-footer">
                        <input type="submit" name="addlead" id="addlead" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
    			</div>
    		</form>
    	</div>
    </div>
            
<script>
           
$(document).ready(function(){

	var pro_status = "<?php echo $status; ?>";
	if(pro_status == "Active"){
    	$('#projectstatus').prop("checked", true);
    }
	else{
    	$('#projectstatus').prop("checked", false);
    }
    $('#progress').val("<?php echo $progress;?>");
	$('#project_lead').val("<?php echo $empid?>");
	$('#sampleid').val([<?php foreach($sidarray as $id){echo '"'.$id.'",'; } ?>]);
            
    var progress = "<?php echo $progress;?>";
    // if project is completed => all fields are disabled
    if (progress == "Complete"){
    	$('#project_data').find("input, textarea, select, button").prop('disabled', true);
    	$('#Save, #Reset').prop('disabled', true);
    	$('#reopen').css({"display": "block"});
    }
    // reopen the project => all fields turn to be editable
	$('#reopenclick').click(function(){
        if(confirm("Want to reopen this project ???")){
    	   	$('#project_data').find("input, textarea, select, button").prop('disabled', false);
           	$('#project_data').find("select").selectpicker('refresh');
           	$('#Save, #Reset').prop('disabled', false);
    	   	$('#reopen').css({"display": "none"});
           	var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1;
            var yyyy = today.getFullYear();
            if(dd<10) {
                dd = '0'+dd
            } 
            if(mm<10) {
                mm = '0'+mm
            } 
            today = yyyy+'-'+mm+'-'+dd;
           	$('#startdate').val(today);
           	$('#estcompletedate').val("");
           	$('#completedate').val("");
           	$('#progress').selectpicker("val","InComplete");
        }
    });
    
	$('#project_update_form').submit(function(event){
       	event.preventDefault();
    	var action="save_update";
       	var projectid = "<?php echo $projectid?>"
       	var data = $(this).serialize()+"&action="+action+"&projectid="+projectid;
       	$.ajax({
           	type:"post",
           	url:"project_action.php",
           	data:data,
           	success: function(mess){
               	$('#alert_action').fadeIn().html('<div class="alert alert-info">'+mess+'</div>');
               	window.setTimeout(function(){location.reload()},2000)
           	}
       	});
    });

                        
	$('#addleader').click(function(){
		$('#projectlead_add').modal('show');
		$('#projectlead_form')[0].reset();
		$('.modal-title').html("Add Employee");
	});
                        
    $('#projectlead_form').submit(function(event){
        event.preventDefault();
    	var action = "addlead";
        var data = $(this).serialize()+"&action="+action;
        $.ajax({
           	type:"post",
           	url:"project_action.php",
           	data:data,
           	success: function(mess){
               	$('#alert_action').fadeIn().html('<div class="alert alert-info">'+mess+'</div>');
            	$('#projectlead_add').modal('hide');
            	window.setTimeout(function(){location.reload()},1000)
           	}
        });
    });

});
</script>


<?php
include ('footer.php');
?>