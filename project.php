<?php
include('dbconnect.php');
include('functions.php');
include('header.php');
?>

<span id="alert_action"></span>
<h4>Project List</h4>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">

                <div class="panel-heading">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <div class="input-daterange">
      						<div class="col-md-4">
       							<input type="date" name="start_date" id="start_date" class="form-control" />
      						</div>
      						<div class="col-md-4">
       							<input type="date" name="end_date" id="end_date" class="form-control" />
      						</div>      
     					</div>
     					<div class="col-md-4">
      						<input type="button" name="filterdate" id="filterdate" value="Filter" class="btn btn-success" />
							<input type="button" name="clearfilter" id="clearfilter" value="Clear" class="btn btn-success" />
     					</div>
                    </div>
					
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
							<?php
							if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
							?>
                             <input type="button" name="add" id="add_button" onclick="location.href='project_add.php'" class="btn btn-success" value="Add">   
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
									<th>Created By</th>
									<th>Project Lead</th>
                            		<th>Start Date</th>
									<th>Progress</th>
									<th>Status</th>
                            		<?php
									if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
									?>
									<th width=10%></th>
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

<script>
$(document).ready(function(){
	var projectdataTable;
	fetch_data('no');                     
 	function fetch_data(is_date_search, start_date='', end_date='')
 	{
  		projectdataTable = $('#project_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order": [],
        "ajax":{
            url:"project_fetch.php",
            type:"POST",
    		data:{
     		is_date_search:is_date_search, start_date:start_date, end_date:end_date
    		}
   		},
    	<?php
		if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
		?>
        "columnDefs":[
            {
<<<<<<< HEAD
                "targets":[2,3,5,6,7],
=======
                "targets":[0,2,3,4,5,6,7,8],
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
                "orderable":false,
            },
        ],
        <?php
        }else{
        ?>
        "columnDefs":[
            {
<<<<<<< HEAD
                "targets":[2,3,5,6],
=======
                "targets":[0,2,3,4,5,6],
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
                "orderable":false,
            },
        ],
        <?php
        }
        ?>
<<<<<<< HEAD
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
=======
        "lengthMenu": [[15, 30, 50, -1], [15, 30, 50, "All"]]
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23
    	});
 	}

 	$('#filterdate').click(function(){
    	var start_date = $('#start_date').val();
  		var end_date = $('#end_date').val();
    	is_date_search = 'yes'
  		if(start_date != '' && end_date !=''){
   			$('#project_data').DataTable().destroy();
   			fetch_data(is_date_search, start_date, end_date);
  		}
  		else{
   			alert("Both Date is Required");
  		}
 	}); 
                                    
	$('#clearfilter').click(function(){
    	$('#project_data').DataTable().destroy();
    	fetch_data('no');
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
<<<<<<< HEAD
=======
           
	              
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
>>>>>>> 3eb9be92b01e1ad40c96a52ddee23ba0b0de8a23

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