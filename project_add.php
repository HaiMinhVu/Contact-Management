<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>


<form method="POST" id="add_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Add New Project</h3>
            	</div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
            	<div class="row" align="right">
            		<button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='project.php'">Back</button>   					
            	</div>
            </div>
			<table id="project_data" class="table table-bordered table-striped">
				<tr>
					<td width=20%>Project Name</td>
					<td><input type="text" name="project_name" id="project_name" class="form-control" required/></td>
				</tr>
				<tr>
					<td >Description</td>
					<td><input type="text" name="project_description" id="project_description" class="form-control" required/></td>
				</tr>
            	<tr>
					<td >Brand</td>
            		<td><select name="brand_id" id="brand_id" class="form-control" required >
                    	<option value="">Select Brand</option>
                    	<?php echo brand_option_list($dbconnect);?>
                    </select></td>
				</tr>
            	<tr>
					<td >Department</td>
            		<td><select name="dept_id" id="dept_id" class="form-control" required >
                    	<option value="">Select Brand</option>
                    	<?php echo department_option_list($dbconnect);?>
                    </select></td>
				</tr>
            	<tr>
					<td >Date Created</td>
            		<td><input type="date" name="datecreated" id="datecreated" class="form-control" value="<?php echo date('Y-m-d') ;?>" required /></td>
				</tr>
            	<tr>
					<td>Start Date</td>
            		<td><input type="date" name="startdate" id="startdate" class="form-control" value="<?php echo date('Y-m-d') ;?>" required /></td>
				</tr>
				<tr>
					<td >Estimate End Date</td>
            		<td><input type="date" name="estcompletedate" id="estcompletedate" value="<?php echo date('Y-m-d') ;?>" class="form-control"  /></td>
				</tr>
				<tr>
					<td >End Date</td>
            		<td><input type="date" name="completedate" id="completedate" class="form-control" /></td>
				</tr>
            	<tr>
					<td >Project Lead</td>
            		<td><select name="project_lead" id="project_lead" class="form-control" required>
                    	<option value="">Select Leader</option>
                    	<?php echo employee_option_list($dbconnect);?>
                    </select></td>
				</tr>
            	<tr>
					<td >Progress</td>
            		<td><select name="progress" id="progress" class="form-control" required >
                    	<option value="">Select Progress</option>
                    	<option value="Complete">Complete</option>
                        <option value="InComplete">InComplete</option>
                    </select></td>
				</tr>
            	<tr>
					<td >Status</td>
            		<td><select name="status" id="status" class="form-control" required>
                    	<option value="">Select Status</option>
                    	<option value="Active">Active</option>
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
	$end_date = "";
	$projectname = $_POST['project_name'];
	$projectdescription = $_POST['project_description'];
	$brandid = $_POST['brand_id'];
	$deptid = $_POST['dept_id'];
	$date_created = $_POST['datecreated'];
	$start_date = $_POST['startdate'];
	$est_end_date = $_POST['estcompletedate'];
	$end_date = (($_POST['completedate'] != '') ? ($end_date = $_POST['completedate']) : ($end_date = "1969-12-31"));
	$project_progress = $_POST['progress'];
	$project_lead = $_POST['project_lead'];
	$status = $_POST['status'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	
	$sql = "INSERT INTO Project VALUES(null, '$projectname', '$projectdescription', $brandid, $deptid, '$date_created', '$start_date', '$est_end_date', '$end_date', $modify_by, $project_lead, '$modify_date', $modify_by, '$project_progress', '$status')";
    if($dbconnect->query($sql) == TRUE){
		
		echo "New Project Added";

	}
    else{
        echo $sql;
    }
}     


?>

<?php
include ('footer.php');
?>