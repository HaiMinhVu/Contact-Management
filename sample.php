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
                            <h3 class="panel-title">Sample List</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                             <?php
							if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
							?>
                             <button type="button" name="add" id="add_button" onclick="location.href='sample_add.php'" class="btn btn-success btn-xs">Add</button>   
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
                    		<table id="sample_data" class="table table-bordered table-striped">
                    			<thead><tr>
									<th>ID</th>
									<th>Sample Name</th>
									<th>Description</th>
									<th>Images</th>
									<th>Enter By</th>
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
    <div id="SampleAddModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="POST" id="sample_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Project</h4>
    				</div>
    				<div class="modal-body">
                        <div class="form-group">
    						<label>Enter Sample Name</label>
							<input type="text" name="sname" id="sname" class="form-control" required />
                        </div>
                        <div class="form-group">
    						<label>Enter Sample Description</label>
							<textarea rows="5" name="sdescription" id="sdescription" class="form-control" ></textarea>
                        </div>
                        <div class="form-group">
    						<label>Link To Image</label>
							<input type="file" name="imageUpload" id="imageUpload">
                        </div>
    				<div class="modal-footer">
    					<input type="hidden" name="sid" id="sid"/>
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
    var dataTable = $('#sample_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"sample_fetch.php",
            type:"POST"
        },
        <?php
		if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
		?>
        "columnDefs":[
            {
                "targets":[0,1,2,3,4,5,6,7,8],
                "orderable":false,
            },
        ],
        <?php
        }else{
        ?>
        "columnDefs":[
            {
                "targets":[0,1,2,3,4,5,6],
                "orderable":false,
            },
        ],
        <?php
        }
        ?>
        "pageLength": 10,
    });

    ////// Add new item to the table
    /*$('#add_button').click(function(){
        $('#SampleAddModal').modal('show');
        $('#sample_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Project");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });*/

    $(document).on('submit', '#sample_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"sample_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#sample_form')[0].reset();
                $('#SampleAddModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                dataTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.update', function(){
        var sid = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"sample_action.php",
            method:"POST",
            data:{sid:sid, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#SampleAddModal').modal('show');
            	$('.modal-title').html("<i class='fa fa-pencil-square-o'></i>Edit Project");
            	$('#sid').val(sid);
                $('#sname').val(data.sname);
                $('#sdescription').val(data.sdescription);
                $('#simage').val(data.simage);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var sid = $(this).attr("id"); /// this will get project id
   		var btn_action = 'delete';
    	var status = $(this).data("status");
        if(confirm("Are you sure you want to delete?" ))
        {
            $.ajax({
                url:"sample_action.php",
                method:"POST",
                data:{sid:sid,btn_action:btn_action,status:status},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
    });

});
</script>

<?php
include ('footer.php');
?>