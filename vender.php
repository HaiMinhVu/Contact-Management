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
                            <h3 class="panel-title">Vender List</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                             <?php
							if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
							?>
                             <button type="button" name="add" id="add_button" onclick="location.href='vender_add.php'" class="btn btn-success btn-xs">Add</button>   
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
                    		<table id="vender_data" class="table table-bordered table-striped">
                    			<thead><tr>
									<th>ID</th>
									<th>Vendor Name</th>
									<th>Register Name</th>
									<th>Owner</th>
									<th>Supplier</th>
									<th>Manufactured</th>
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
    <div id="EntityAddModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="POST" id="vender_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Vender</h4>
    				</div>
    				<div class="modal-body">
                        <div class="vender_add_form">
                                <label>Vender Parents</label>
                                <select name="epid" id="epid" class="form-control">
                                    <option value="">Select Parents</option>
                                    <?php echo entity_option_list($dbconnect);?>
                                </select>
    					</div>
                        <div class="vender_add_form">
    						<label>Enter Vender Name</label>
							<input type="text" name="ename" id="ename" class="form-control" required />
                        </div>
                        <div class="vender_add_form">
    						<label>Enter Registered Name</label>
							<input type="text" name="eregisteredname" id="eregisteredname" class="form-control" required />
                        </div>
                        <div class="vender_add_form">
    						<label>Enter Owner</label>
							<input type="text" name="owner" id="owner" class="form-control" required />
                        </div>
                        <div class="vender_add_form">
    						<label>Enter Supplier</label>
                        	<textarea name="supplier" id="supplier" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="vender_add_form">
    						<label>Enter OEM Customer</label>
							<input type="text" name="oemcustomer" id="oemcustomer" class="form-control" required />
                        </div>
                        <div class="vender_add_form">
    						<label>Enter Number of Worker</label>
							<input type="text" name="numberofworker" id="numberofworker" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" required />
                        </div>
                        <div class="vender_add_form">
    						<label>Enter Annual Sale</label>
							<input type="text" name="annualsale" id="annualsale" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" required />
                        </div>
                        <div class="vender_add_form">
    						<label>Enter Product Manufactured</label>
                        	<textarea name="productmanufactured" id="productmanufactured" class="form-control" rows="3" required></textarea>
                        </div>
    				<div class="modal-footer">
    					<input type="hidden" name="eid" id="eid"/>
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
    var dataTable = $('#vender_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"vender_fetch.php",
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
    /*$('#add_button').click(function(){
        $('#EntityAddModal').modal('show');
        $('#vender_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add New Vender");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });*/

    $(document).on('submit', '#vender_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"vender_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#vender_form')[0].reset();
                $('#EntityAddModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                dataTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.update', function(){
        var eid = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"vender_action.php",
            method:"POST",
            data:{eid:eid, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#EntityAddModal').modal('show');
            	$('.modal-title').html("<i class='fa fa-pencil-square-o'></i>Edit Vender");
            	$('#eid').val(eid);
                $('#ename').val(data.ename);
                $('#eregisteredname').val(data.eregisteredname);
                $('#owner').val(data.owner);
                $('#supplier').val(data.supplier);
            	$('#oemcustomer').val(data.oemcustomer);
                $('#numberofworker').val(data.numberofworker);
                $('#annualsale').val(data.annualsale);
            	$('#productmanufactured').val(data.productmanufactured);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var eid = $(this).attr("id"); /// this will get project id
   		var btn_action = 'delete';
    	var status = $(this).data("status");
        if(confirm("Are you sure you want to delete?" )){
            $.ajax({
                url:"vender_action.php",
                method:"POST",
                data:{eid:eid,btn_action:btn_action,status:status},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    dataTable.ajax.reload();
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