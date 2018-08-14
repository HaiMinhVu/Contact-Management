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
                            <h3 class="panel-title">Sample Record List</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                             <?php
							if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
							?>
                             <button type="button" name="add" id="add_button"  onclick="location.href='samplerecord_add.php'" class="btn btn-success btn-xs">Add</button>   
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
                    		<table id="samplerecord_data" class="table table-bordered table-striped">
                    			<thead><tr>
									<th>ID</th>
									<th>Sample Name</th>
									<th>Request From</th>
                                    <th>Request By</th>
                                    <th>Date Requested</th>
									<th>Quantity</th>
									<th>Used</th>
                            		<th>Available</th>
                                    <th>Type</th>
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
    //// create table - project_fetch to load data into table
    var dataTable = $('#samplerecord_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"samplerecord_fetch.php",
            type:"POST"
        },
        <?php
		if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
		?>
        "columnDefs":[
            {
                "targets":[5,6,7,8,9,10],
                "orderable":false,
            },
        ],
        <?php
        }else{
        ?>
        "columnDefs":[
            {
                "targets":[5,6,7,8],
                "orderable":false,
            },
        ],
        <?php
        }
        ?>
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });

    $(document).on('submit', '#samplerecord_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"samplerecord_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#samplerecord_form')[0].reset();
                $('#SampleRecordAddModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                dataTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var srid = $(this).attr("id"); /// this will get project id
   		var btn_action = 'delete';
    	var status = $(this).data("status");
        if(confirm("Are you sure you want to delete?" ))
        {
            $.ajax({
                url:"samplerecord_action.php",
                method:"POST",
                data:{srid:srid,btn_action:btn_action,status:status},
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