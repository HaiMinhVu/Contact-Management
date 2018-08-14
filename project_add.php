<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
?>
<<<<<<< HEAD
=======
<span id="alert_action"></span>
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Add New Project</font></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
<<<<<<< HEAD
                    <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.history.back()">Back</button> 	
=======
                    <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='project.php'">Back</button> 	
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		<div class="panel-body">
			<form method="POST" id="projectadd_form">
			<table id="project_data" class="table table-bordered table-striped">
				<tr>
					<td width=14%>Project Name <span style="color:red">*</span></td>
					<td><input type="text" name="project_name" id="project_name" class="form-control" required/></td>
				</tr>
				<tr>
					<td >Description</td>
					<td><textarea rows="3" name="project_description" id="project_description" class="form-control" ></textarea></td>
				</tr>
            	<tr>
<<<<<<< HEAD
=======
					<td>Date Created</td>
            		<td><input type="date" name="datecreated" id="datecreated" class="form-control" value="<?php echo date('Y-m-d') ;?>"  /></td>
				</tr>
            	<tr>
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
					<td>Start Date</td>
            		<td><input type="date" name="startdate" id="startdate" class="form-control" value="<?php echo date('Y-m-d') ;?>"  /></td>
				</tr>
				<tr>
					<td >Estimate End Date</td>
            		<td><input type="date" name="estcompletedate" id="estcompletedate" class="form-control"  /></td>
				</tr>
				<tr>
					<td >End Date</td>
            		<td><input type="date" name="completedate" id="completedate" class="form-control" /></td>
				</tr>
            	<tr>
					<td >Project Lead <span style="color:red">*</span></td>
<<<<<<< HEAD
            		<td><select name="project_lead" id="project_lead" class="selectpicker" data-width="fit" data-live-search="true" required>
                    	<option value="">Select Leader</option>
                    	<?php echo employee_option_list($dbconnect);?>
                    </select>
					<button type="button" name="addleader" id="addleader" class="btn btn-success btn-xs" >Add</button> </td>
=======
            		<td><select name="project_lead" id="project_lead" class="selectpicker" data-width="fit" data-style="btn-primary" data-live-search="true" required>
                    	<option value="">Select Leader</option>
                    	<?php echo employee_option_list($dbconnect);?>
                    </select></td>
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
				</tr>
            	<tr>
					<td >Progress</td>
            		<td><select name="progress" id="progress" class="form-control" >
                    	<option value="Complete">Complete</option>
                        <option value="InComplete" selected>InComplete</option>
                    </select></td>
				</tr>
				<tr>
					<td>Select Sample <span style="color:red">*</span></td>
<<<<<<< HEAD
            		<td><select name="sampleid[]" id="sampleid" multiple class="selectpicker" data-live-search="true" data-width="fit" required>
                    	<?php echo sample_option_list($dbconnect);?>
					</select>
					<button type="button" name="addsample" id="addsample" class="btn btn-success btn-xs" onclick="window.location.href='sample_add.php'">Add</button></td>
=======
            		<td><select name="sampleid[]" id="sampleid" multiple class="selectpicker" data-style="btn-primary" data-live-search="true" data-width="fit" required>
                    	<?php echo sample_option_list($dbconnect);?>
					</select>
					<button type="button" name="addsample" id="addsample" class="btn btn-success btn-xs" onclick="window.location.href='sample_add.php'">Add</button> </td>
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
				</tr>
				<tr>
					<td >Status</td>
            		<td><input type="checkbox" name="projectstatus" id="projectstatus" value="status" checked> Active</td>
				</tr>
			</table>
<<<<<<< HEAD
			<div style="text-align:center">
				<span id="alert_action"></span>
				<input type="submit" name="Add" id="Add" class="btn btn-success" value="Add & Request Sample" />
				&nbsp;
            	<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />	
                &nbsp;
            	<input type="reset" name="reset" id="reset" class="btn btn-warning" value="Reset" />
			</div>
=======
            	<input type="submit" name="Add" id="Add" class="btn btn-info" value="Add" />
            	<input type="reset" name="reset" id="reset" class="btn btn-warning" value="Reset" />
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
			</form>
		</div>
	</div>

<<<<<<< HEAD
<!------- Add Project Leader Modal ----------->
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
                
    var action;
	$('#Add').click(function(){
    	action = "add";
    });
	$('#Save').click(function(){
    	action = "save";
    });
                
    $('#projectadd_form').submit(function(event){
        event.preventDefault();
        var data = $(this).serialize()+"&action="+action;
        $.ajax({
           	type:"post",
           	url:"project_action.php",
           	data:data,
           	success: function(mess){
               	$('#alert_action').fadeIn().html('<div class="alert alert-info">'+mess+'</div>');
               	if(action == "add"){
                   	window.setTimeout(function(){location.replace("samplerecord.php")},1000)
                }
               	if(action == "save"){
                   	window.setTimeout(function(){location.reload()},2000)
                }
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
=======
<?php
if(isset($_POST['Add'])){
	$status = '';
	if(empty($_POST['projectstatus'])){
    	$status = 'InActive';
    }
	else{
    	$status = 'Active';
    }
	$end_date = "";
	$projectname = $_POST['project_name'];
	$projectdescription = $_POST['project_description'];
	$date_created = $_POST['datecreated'];
	$start_date = $_POST['startdate'];
	$est_end_date = $_POST['estcompletedate'];
	$end_date = (($_POST['completedate'] != '') ? ($end_date = $_POST['completedate']) : ($end_date = "1969-12-31"));
	$project_progress = $_POST['progress'];
	$project_lead = $_POST['project_lead'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	$sampleid = $_POST['sampleid'];

	$sql = "INSERT INTO Project VALUES(null, '$projectname', '$projectdescription', '$date_created', '$start_date', '$est_end_date', '$end_date', $modify_by, $project_lead, '$modify_date', $modify_by, '$project_progress', '$status')";
    if($dbconnect->query($sql) == TRUE){
    	$tmpsql = "SELECT MAX(ProjectID) FROM Project";
    	$tmpresult = $dbconnect->query($tmpsql);
    	while($prorow = $tmpresult->fetch_assoc()){
        	$maxproid = $prorow['MAX(ProjectID)'];
        	foreach ($sampleid as $sid){
            	$p_require_s = "INSERT INTO Project_Require_Sample VALUES($maxproid, $sid)";
            	$p_require_s_result = $dbconnect->query($p_require_s);
            }
        	echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">New Project Added</div>';
       			 </script>";
        }
    }
    else{
        echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-danger"'.">Query Failed: ".$sql."</div>';
       			 </script>";
    }
}     
?>
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23

<?php
include ('footer.php');
?>