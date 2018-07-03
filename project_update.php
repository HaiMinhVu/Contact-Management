<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$projectid =$_GET['project_id'];
$brandid;$deptid; $progress; $status; $empid;

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<form method="POST" id="edit_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<?php

			$projectsql = "SELECT * FROM Project JOIN SMDBAccounts ON EnterBy = AcctID WHERE ProjectID = $projectid";
			$projectfetch = $dbconnect->query($projectsql);
			while($row = $projectfetch->fetch_assoc()){
            $brandid = $row['BrandBelongTo'];
            $deptid = $row['DeptBelongTo'];
            $progress = $row['Progress'];
            $status = $row['ProjectStatus'];
            $empid = $row['ProjectLead'];
			?>
            <h3>Project Update</h3>
			<table id="project_data" class="table table-bordered table-striped">
				<tr>
					<td width=20%>Project Name</td>
					<td><input type="text" name="project_name" id="project_name" value="<?php echo $row['ProjectName'];?>" class="form-control"/></td>
				</tr>
				<tr>
					<td >Description</td>
					<td><input type="text" name="project_description" id="project_description" value="<?php echo $row['ProjectDescription'];?>" class="form-control"/></td>
				</tr>
            	<tr>
					<td >Brand</td>
            		<td><select name="brand_id" id="brand_id" class="form-control" >
                    	<option value="">Select Brand</option>
                    	<?php echo brand_option_list($dbconnect);?>
                    </select></td>
				</tr>
            	<tr>
					<td >Department</td>
            		<td><select name="dept_id" id="dept_id" class="form-control" >
                    	<option value="">Select Brand</option>
                    	<?php echo department_option_list($dbconnect);?>
                    </select></td>
				</tr>
            	<tr>
					<td >Date Created</td>
            		<td><input type="date" name="datecreated" id="datecreated" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['DateCreated'])) ;?>" required /></td>
				</tr>
            	<tr>
					<td>Start Date</td>
            		<td><input type="date" name="startdate" id="startdate" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['StartDate'])) ;?>" required /></td>
				</tr>
            	<tr>
					<td >Project Lead</td>
            		<td><select name="project_lead" id="project_lead" class="form-control" >
                    	<option value="">Select Brand</option>
                    	<?php echo employee_option_list($dbconnect);?>
                    </select></td>
				</tr>
            	<tr>
					<td >Estimate End Date</td>
            		<td><input type="date" name="estcompletedate" id="estcompletedate" value="<?php echo date('Y-m-d', strtotime($row['EstEndDate'])) ;?>" class="form-control" required /></td>
				</tr>
            	<tr>
					<td >End Date</td>
            		<td><input type="date" name="completedate" id="completedate" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['EndDate'])) ;?>"required /></td>
				</tr>
            	<tr>
					<td >Progress</td>
            		<td><select name="progress" id="progress" class="form-control" >
                    	<option value="">Select Progress</option>
                    	<option value="Complete">Complete</option>
                        <option value="InComplete">InComplete</option>
                    </select></td>
				</tr>
            	<tr>
					<td >Status</td>
            		<td><select name="status" id="status" class="form-control" >
                    	<option value="">Select Status</option>
                    	<option value="Active">Active</option>
                        <option value="InActive">InActive</option>
                    </select></td>
				</tr>
            	<tr>
					<td >Enter By</td>
					<td ><?php echo $row['username'] ;?></td>
				</tr>
            	<tr>
					<td >Modify Date</td>
            		<td><?php echo date('Y-m-d H:i', strtotime($row['ModifyDate'])) ;?></td>
				</tr>
			</table>
            <?php
            }
            ?>

            <input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            <input type="submit" name="reset" id="reset" class="btn btn-info" value="Cancel" />
		</div>
	</div>
</div>
</form>
<?php
if(isset($_POST['Save'])){
	$projectname = $_POST['project_name'];
	$projectdescription = $_POST['project_description'];
	$brandid = $_POST['brand_id'];
	$deptid = $_POST['dept_id'];
	$date_created = $_POST['datecreated'];
	$start_date = $_POST['startdate'];
	$est_end_date = $_POST['estcompletedate'];
	$end_date = $_POST['completedate'];
	$project_progress = $_POST['progress'];
	$project_lead = $_POST['project_lead'];
	$status = $_POST['status'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	
	$sql = "UPDATE Project SET ProjectName = '$projectname', ProjectDescription = '$projectdescription', BrandBelongTo = '$brandid', DeptBelongTo = '$deptid', DateCreated = '$date_created', StartDate = '$start_date', EstEndDate = '$est_end_date', EndDate = '$end_date', Progress = '$project_progress', ModifyDate = '$modify_date', ModifyBy = $modify_by, ProjectStatus = '$status', ProjectLead = '$project_lead'
            WHERE ProjectID = $projectid";
    if($dbconnect->query($sql) == TRUE){
		echo "<meta http-equiv='refresh' content='0'>";	// reload page
	}
    else{
        echo $sql;
    }
}     
?>
<script>
$(document).ready(function(){
	$('#brand_id').val(<?php echo $brandid;?>);
	$('#dept_id').val(<?php echo $deptid;?>);
    $('#progress').val("<?php echo $progress;?>");
	$('#status').val("<?php echo $status?>");
	$('#project_lead').val("<?php echo $empid?>");

});
</script>


<?php
include ('footer.php');
?>