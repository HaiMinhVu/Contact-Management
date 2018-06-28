<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
?>

</style>
<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <div class="row">
                            <h3 class="panel-title">Project List</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
							<?php
							if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
							?>
                             <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>   
							<?php
                            }
                            ?>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                    	<div class="col-sm-12 table-responsive">
                    		<table id="project_data" class="table table-bordered table-striped">
                    			<thead><tr>
									<th>ID</th>
									<th>Project Name</th>
									<th>Enter By</th>
									<th>Project Lead</th>
									<th>Date Created</th>
									<th>Progress</th>
									<th>Status</th>
									<th></th>
                            		<?php
									if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
									?>
									<th></th>
									<th></th>
                                    <?php
                            		}
                            		?>
								</tr></thead>
                    		</table>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="ProjectAddModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="POST" id="project_form">
    			<div class="modal-content">

    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Project</h4>
    				</div>
                        
    				<div class="modal-body">
                        <div class="project_add_form">
    						<label>Enter Project Name</label>
							<input type="text" name="project_name" id="project_name" class="form-control" required />
                        </div>
                        <div class="project_add_form">
                            <label>Enter Project Description</label>
                            <textarea name="project_description" id="project_description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="project_add_form">
                                <label>Brand Belong To</label>
                                <select name="brand_id" id="brand_id" class="form-control" required>
                                    <option value="">Select Brand</option>
                                    <?php echo brand_option_list($dbconnect);?>
                                </select>
    					</div>
                        <div class="project_add_form">
                                <label>Department Belong To</label>
                                <select name="dept_id" id="dept_id" class="form-control" required>
                                    <option value="">Select Department</option>
                                    <?php echo department_option_list($dbconnect);?>
                                </select>
    					</div>
                        <div class="project_add_form">
    						<label>Date Created</label>
							<input type="date" name="datecreated" id="datecreated" value="<?php echo date("Y-m-d");?>" class="form-control" required />
                        </div>
                        <div class="project_add_form">
    						<label>Start Date</label>
							<input type="date" name="startdate" id="startdate" value="<?php echo date("Y-m-d");?>" class="form-control" required />
                        </div>
                        <div class="project_add_form">
    						<label>Estimate Complete Date</label>
							<input type="date" name="estcompletedate" id="estcompletedate" value="<?php echo date("Y-m-d");?>" class="form-control" required />
                        </div>

                        <div class="project_add_form">
    						<label>Complete Date</label>
							<input type="date" name="completedate" id="completedate" class="form-control"  />
                        </div>
                        <div class="project_add_form">
                                <label>Project Lead</label>
                                <select name="project_lead" id="project_lead" class="form-control" required>
                                    <option value="">Select Leader</option>
                                    <?php echo employee_option_list($dbconnect);?>
                                </select>
    					</div>
                        <div class="project_add_form">
    						<label>Progress</label>
							<select name="progress" id="progress" class="form-control" >
                                <option value="">Select Progress</option>
                        		<option value="Complete">Complete</option>
                        		<option value="InComplete">InComplete</option>
                            </select>
                        </div>	  
                        
    				<div class="modal-footer">
    					<input type="hidden" name="project_id" id="project_id"/>
    					<input type="hidden" name="btn_action" id="btn_action"/>
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>

<script>
$(document).ready(function(){
    //// create table - project_fetch to load data into table
    var projectdataTable = $('#project_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"project_fetch.php",
            type:"POST"
        },
    	<?php
		if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
		?>
        "columnDefs":[
            {
                "targets":[0,1,2,3,4,5,6,7,8,9],
                "orderable":false,
            },
        ],
        <?php
        }else{
        ?>
        "columnDefs":[
            {
                "targets":[0,1,2,3,4,5,6,7],
                "orderable":false,
            },
        ],
        <?php
        }
        ?>
        "pageLength": 10,
    });

    ////// Add new item to the table
    $('#add_button').click(function(){
        $('#ProjectAddModal').modal('show');
        $('#project_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Project");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

    $(document).on('submit', '#project_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"project_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#project_form')[0].reset();
                $('#ProjectAddModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                projectdataTable.ajax.reload();
            }
        })
    });
                        
    $(document).on('click', '.update', function(){
    	// display hidden fields - update has 3 more fields than add
        var project_id = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"project_action.php",
            method:"POST",
            data:{project_id:project_id, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#ProjectAddModal').modal('show');
            	$('.modal-title').html("<i class='fa fa-pencil-square-o'></i>Edit Project");
            	$('#project_id').val(project_id);
                $('#project_name').val(data.project_name);
                $('#project_description').val(data.project_description);
                $('#brand_id').val(data.brand_id);
                $('#dept_id').val(data.dept_id);
            	$('#datecreated').val(data.created_date);
                $('#startdate').val(data.start_date);
                $('#estcompletedate').val(data.est_end_date);
            	$('#completedate').val(data.end_date);
            	$('#project_lead').val(data.project_lead);
            	$('#progress').val(data.progress);
            	$('#status').val(data.status);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var project_id = $(this).attr("id"); /// this will get project id
   		var btn_action = 'delete';
    	var status = $(this).data("status");
        if(confirm("Are you sure you want to delete?" )){
            $.ajax({
                url:"project_action.php",
                method:"POST",
                data:{project_id:project_id,btn_action:btn_action,status:status},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    projectdataTable.ajax.reload();
                }
            });
        }
        else{
            return false;
        }
    });

});
</script>

<?php
include ('footer.php');
?>