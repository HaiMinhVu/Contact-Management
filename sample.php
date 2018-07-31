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
									<th>Image</th>
									<th>Enter By</th>
									<th>Status</th>
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
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Image preview</h4>
      </div>
      <div class="modal-body">
        <img src="" id="imagepreview" style="width: 400px; height: 264px;" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
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
                "targets":[0,1,2,3,4,5,6,7],
                "orderable":false,
            },
        ],
        <?php
        }else{
        ?>
        "columnDefs":[
            {
                "targets":[0,1,2,3,4,5],
                "orderable":false,
            },
        ],
        <?php
        }
        ?>
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
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
	
	$(document).on('click', '.viewimage', function(){
    	var sid = $(this).attr("id");
    	window.open('sample_image.php?id='+sid);
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