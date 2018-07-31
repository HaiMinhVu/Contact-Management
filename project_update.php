<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
$projectid =$_GET['project_id'];
$progress; $status; $empid;
$sidarray = array();
$p_require_s = "SELECT SID FROM Project_Require_Sample WHERE ProjectID = $projectid";
$p_require_s_result = $dbconnect->query($p_require_s);
while($sidrow = $p_require_s_result->fetch_assoc()){
	array_push($sidarray, $sidrow['SID']);
}
?>
<span id="alert_action"></span>

	<div class="panel panel-default">
		<div class="panel-heading">
        	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
            	<div class="row">
                	<h3 class="panel-title"><font color="#2775F5">Project Update</font></h3>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                <div class="row" align="right">
                    <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.location.href='project.php'">Back</button> 	
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
		<div class="panel-body">
			<?php
			$projectsql = "SELECT * FROM Project JOIN SMDBAccounts ON EnterBy = AcctID WHERE ProjectID = $projectid";
			$projectfetch = $dbconnect->query($projectsql);
			while($row = $projectfetch->fetch_assoc()){
            $progress = $row['Progress'];
            $status = $row['ProjectStatus'];
            $empid = $row['ProjectLead'];
            $modifybyid = $row['ModifyBy'];
			?>
            <form method="POST" id="project_update_form">
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
					<td >Date Created</td>
            		<td><?php echo date('Y-m-d', strtotime($row['DateCreated'])) ;?></td>
				</tr>
            	<tr>
					<td>Created By</td>
					<td><?php echo $row['username'] ;?></td>
				</tr>
            	<tr>
					<td>Start Date</td>
            		<td><input type="date" name="startdate" id="startdate" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['StartDate'])) ;?>" required /></td>
				</tr>
            	<tr>
					<td >Project Lead</td>
            		<td><select name="project_lead" id="project_lead" class="selectpicker" data-live-search="true" data-style="btn-primary">
                    	<option value="">Select Leader</option>
                    	<?php echo employee_option_list($dbconnect);?>
                    </select></td>
				</tr>
            	<tr>
					<td >Estimate End Date</td>
            		<td><input type="date" name="estcompletedate" id="estcompletedate" value="<?php echo date('Y-m-d', strtotime($row['EstEndDate'])) ;?>" class="form-control" required /></td>
				</tr>
            	<tr>
					<td>End Date</td>
            		<td><input type="date" name="completedate" id="completedate" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['EndDate'])) ;?>"required /></td>
				</tr>
            	<tr>
					<td>Progress</td>
            		<td><select name="progress" id="progress" class="form-control" >
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
            		$modifyidsql = $dbconnect->query("SELECT username FROM SMDBAccounts WHERE AcctID = $modifybyid");
					while($modifyidrow = $modifyidsql->fetch_assoc()){
            		?>
            		<td><?php echo $modifyidrow['username'] ;?></td>
                    <?php
                    }
                    ?>
				</tr>
                <tr>
					<td>Select Sample</td>
            		<td><select name="sampleid[]" id="sampleid" multiple class="selectpicker" data-live-search="true" data-width="fit" data-style="btn-primary" >
                    	<?php echo sample_option_list($dbconnect);?>
                    </select></td>
				</tr>
                <tr>
					<td>Status</td>
            		<td><input type="checkbox" name="projectstatus" id="projectstatus" value="status"> Active</td>
				</tr>
			</table>
            <?php
            }
            ?>
            	<input type="submit" name="Save" id="Save" class="btn btn-info" value="Save" />
            	<input type="submit" name="Reset" id="Reset" class="btn btn-warning" value="Reset" />
            </form>
            
		</div>
	</div>
         
<?php
if(isset($_POST['Save'])){
	if(empty($_POST['projectstatus'])){
    	$status = 'InActive';
    }
	else{
    	$status = 'Active';
    }
	$projectname = $_POST['project_name'];
	$projectdescription = $_POST['project_description'];
	$start_date = $_POST['startdate'];
	$est_end_date = $_POST['estcompletedate'];
	$end_date = $_POST['completedate'];
	$project_progress = $_POST['progress'];
	$project_lead = $_POST['project_lead'];
	$modify_date = date('Y-m-d H:i');
	$modify_by = $_SESSION['acct_id'];
	
	$sampleid = $_POST['sampleid'];

	$sql = "UPDATE Project SET ProjectName = '$projectname', ProjectDescription = '$projectdescription', StartDate = '$start_date', EstEndDate = '$est_end_date', EndDate = '$end_date', Progress = '$project_progress', ModifyDate = '$modify_date', ModifyBy = $modify_by, ProjectStatus = '$status', ProjectLead = '$project_lead'
            WHERE ProjectID = $projectid";
	$oldarray = $newarray = $lostarray = array();
	foreach ($sampleid as $sid){
    	if(in_array($sid, $sidarray)){
        	array_push($oldarray, $sid);
        }
    	else{
        	array_push($newarray, $sid);
        }
    }
	$lostarray = array_diff( $sidarray, $sampleid);
	
    if($dbconnect->query($sql) === TRUE){
    	foreach ($newarray as $newsid){
            	$newsql = "INSERT INTO Project_Require_Sample VALUES($projectid, $newsid)";
            	$newresult = $dbconnect->query($newsql);
        }
    	foreach ($lostarray as $lostsid){
            	$lostsql = "DELETE FROM Project_Require_Sample WHERE ProjectID = $projectid AND SID = $lostsid";
            	$lostresult = $dbconnect->query($lostsql);
        		//echo $lostsql;
        }
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

	
});
</script>


<?php
include ('footer.php');
?>