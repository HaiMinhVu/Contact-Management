<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$projectid =1;
$brandid;

?>

<form method="POST" id="edit_form">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
			<?php

			$projectsql = "SELECT * FROM Project JOIN SMDBAccounts ON EnterBy = AcctID WHERE ProjectID = $projectid";
			$projectfetch = $dbconnect->query($projectsql);
			while($row = $projectfetch->fetch_assoc()){
            $brandid = $row['BrandBelongTo'];
			?>
            <h3>Project Update</h3>
			<table id="project_data" class="table table-bordered table-striped">
				<tr>
					<td width=20%>Project Name</td>
					<td><input type="text" name="projectname" id="projectname" value="<?php echo $row['ProjectName'] ;?>" class="form-control"/></td>
				</tr>
				<tr>
					<td >Description</td>
					<td><input type="text" name="description" id="description" value="<?php echo $row['ProjectDescription'];?>" class="form-control"/></td>
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
            		<td><input type="date" name="datecreated" id="datecreated" value="<?php echo date("Y-m-d", strtotime($row['DateCreated']));?>" class="form-control" required /></td>
				</tr>
            	<tr>
					<td>Start Date</td>
            		<td><input type="date" name="startdate" id="startdate" value="<?php echo date("Y-m-d", strtotime($row['StartDate']));?>" class="form-control" required /></td>
				</tr>
            	<tr>
					<td >Estimate End Date</td>
            		<td><input type="date" name="estenddate" id="estenddate" value="<?php echo date("Y-m-d", strtotime($row['EstEndDate']));?>" class="form-control" required /></td>
				</tr>
            	<tr>
					<td >End Date</td>
            		<td><input type="date" name="enddate" id="enddate" value="<?php echo date("Y-m-d", strtotime($row['EndDate']));?>" class="form-control" required /></td>
				</tr>
            	<tr>
					<td >Enter By</td>
					<td><?php echo $row['username'];?></td>
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
			</table>
            <?php
            }
            ?>


            <input type="submit" name="action" id="action" class="btn btn-info" value="submit" />
		</div>
	</div>
</div>
</form>
<script
var brandid = "<?php echo $brandid; ?>";
$('select option[value="brandid"]').attr("selected",true);
            
}
></script>
<?php
if($_POST['action'] == "submit"){
	echo $_POST['status'];
}
echo $brandid;
            
include(footer.php);
?>