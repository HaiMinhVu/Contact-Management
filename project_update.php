<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$projectid =$_GET['project_id'];
$brandid;$deptid; $progress; $status; $empid;
$eidarray = array();
?>
<span id="alert_action"></span>
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
            $modifybyid = $row['ModifyBy'];
			?>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Project Update</h3>
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
					<td><input type="text" name="project_name" id="project_name" value="<?php echo $row['ProjectName'];?>" class="form-control"/></td>
				</tr>
				<tr>
					<td >Description</td>
            		<td><textarea rows="3" name="project_description" id="project_description" class="form-control" ><?php echo $row['ProjectDescription'];?></textarea></td>
					
				</tr>
            	<tr>
					<td >Brand</td>
            		<td><select name="brand_id" id="brand_id" class="selectpicker" data-live-search="true" >
                    	<option value="">Select Brand</option>
                    	<?php echo brand_option_list($dbconnect);?>
                    </select>
            		<button type="button" name="brandadd" id="brandadd" class="btn btn-success btn-xs" onclick="window.location.href='brand_add.php'">Add</button></td>
				</tr>
            	<tr>
					<td >Department</td>
            		<td><select name="dept_id" id="dept_id" class="selectpicker" data-live-search="true" >
                    	<option value="">Select Department</option>
                    	<?php echo department_option_list($dbconnect);?>
                    </select>
            		<button type="button" name="deptadd" id="deptadd" class="btn btn-success btn-xs" onclick="window.location.href='dept_add.php'">Add</button></td>
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
            		<td><select name="project_lead" id="project_lead" class="selectpicker" data-live-search="true" >
                    	<option value="">Select Leader</option>
                    	<?php echo employee_option_list($dbconnect);?>
                    </select>
            		<button type="button" name="empadd" id="empadd" class="btn btn-success btn-xs" onclick="window.location.href='employee_add.php'">Add</button></td>
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
            	<tr>
					<td >Modify By</td>
            		<?php
            		$modifyidsql = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
					while($modifyidrow = $modifyidsql->fetch_assoc()){
            		?>
            		<td><?php echo $modifyidrow['username'] ;?></td>
                    <?php
                    }
                    ?>
				</tr>
			</table>
            <?php
            }
            ?>
            <input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            <input type="submit" name="Reset" id="Reset" class="btn btn-warning" value="Reset" />
		</div>
	</div>
</div>
</form>
            
<form method="POST" id="view_sample">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Sample Related</h3>
            	</div>
            	<div class="row">
            		<div class="col-md-8"><h4>Sample Info</h4></div>
  					<div class="col-md-4"><h4>Vendor Info</h4></div>
            	</div>
            </div>

            <?php
			$samplequery = "SELECT * FROM Project p 
    			INNER JOIN Project_Require_Sample prs ON prs.ProjectID = p.ProjectID
				INNER JOIN Sample s ON s.SID = prs.SID
                INNER JOIN SampleRecord sr ON sr.SID = s.SID
                INNER JOIN Entity e ON e.EID = sr.EID
                WHERE p.ProjectID = $projectid";
			$samplefetch = $dbconnect->query($samplequery);
			while($srow = $samplefetch->fetch_array()){
            	$eid = $srow['EID'];
    			if(!in_array($eid, $eidarray, true)){
        			array_push($eidarray, $eid);
        		}
			?>
			<table id="sample_view" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Sample</td>
					<td width=40%><?php echo $srow['SName'];?></td>
            		<td width=10%>Vendor</td>
            		<td width=40%><?php echo $srow['EName'];?></td>
				</tr>
            	<tr>
					<td width=10%>Type</td>
					<td width=40%><?php echo $srow['Type'];?></td>
            		<td width=10%>Owner</td>
            		<td width=40%><?php echo $srow['Owner'];?></td>
				</tr>
            	<tr>
					<td width=10%>Quantity</td>
					<td width=40%><?php echo $srow['Quantity'];?></td>
            		<td width=10%>Supplier</td>
            		<td width=40%><?php echo $srow['Supplier'];?></td>
				</tr>
            	<tr>
					<td width=10%>Price/Unit</td>
					<td width=40%><?php echo $srow['PriceperUnit'];?></td>
            		<td width=10%>Manufactured</td>
            		<td width=40%><?php echo $srow['ProductManufactured'];?></td>
				</tr>
            	<tr>
					<td width=10%>Image</td>
					<td width=40%><?php echo $srow['Images'];?></td>
            		<td width=10%>Annual Sale</td>
            		<td width=40%><?php echo $srow['AnnualSales'];?></td>
				</tr>
            	
			</table>
            <br>
            <?php
            }
            ?>  
		</div>
	</div>
</div>
</form>

<form method="POST" id="view_sample">
<div class="panel-body">
	<div class="row">
		<div class="col-sm-12 table-responsive">
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<h3>Contacts Related</h3>
            	</div>
            </div>
            <?php
			foreach($eidarray as $eid){
    		$contactsql = "SELECT * FROM Entity e INNER JOIN Entity_RelateTo_Contact erc ON erc.EID = e.EID
						INNER JOIN Entity_Contact ec ON ec.ECID = erc.ECID
                        WHERE e.EID = $eid";

    		$contactfetch = $dbconnect->query($contactsql);
    		while($crow = $contactfetch->fetch_array()){
			?>
            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
            		<div class="col-md-8"><h4>Vendor: <?php echo $crow['EName'];?></h4></div>
            	</div>
            </div>
			<table id="contact_view" class="table table-bordered table-striped">
				<tr>
					<td width=10%>Name</td>
					<td width=40%><?php echo $crow['ECName'];?></td>
            		<td width=10%>Title</td>
                    <td width=40%><?php echo $crow['ERCTitle'];?></td>
				</tr>
            	<tr>
					<td width=10%>Email</td>
					<td width=40%><?php echo $crow['ECEmail'];?></td>
            		<td width=10%>Address 1</td>
            		<td width=40%><?php echo $crow['ECAddress1'];?></td>
				</tr>
            	<tr>
					<td width=10%>Phone</td>
					<td width=40%><?php echo $crow['ECPhone'];?></td>
            		<td width=10%>Address 2</td>
            		<td width=40%><?php echo $crow['ECAddress2'];?></td>
				</tr>
            	<tr>
					<td width=10%>Fax</td>
					<td width=40%><?php echo $crow['ECFax'];?></td>
            		<td width=10%>City</td>
            		<td width=40%><?php echo $crow['ECCity'];?></td>
				</tr>
            	<tr>
					<td width=10%>Website</td>
					<td width=40%><?php echo $crow['ECWebsite'];?></td>
            		<td width=10%>State-Zip</td>
            		<td width=40%><?php echo $crow['ECState']."-".$crow['ECZip'];?></td>
				</tr>
            	<tr>
					<td width=10%>Status</td>
					<td width=40%><?php echo $crow['ECStatus'];?></td>
                    <td width=10%>Country</td>
            		<td width=40%><?php echo $crow['ECCountry'];?></td>
				</tr>
            	
			</table>
            <?php
            }
            }
            ?>  
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
    if($dbconnect->query($sql) === TRUE){
		echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-info"'.">Project Updated</div>';
       			 </script>";
		echo "<meta http-equiv='refresh' content='2'>";
	}
    else{
        echo "<script type='text/javascript'>
            	document.getElementById('alert_action').innerHTML = '<div class=".'"alert alert-danger"'.">Query Failed: ".$sql."</div>';
       			 </script>";
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