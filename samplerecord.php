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
									<th>Price/Unit</th>
                                    <th>Type</th>
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
    <div id="SampleRecordAddModal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="POST" id="samplerecord_form">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Project</h4>
    				</div>
    				<div class="modal-body">
                        <div class="form-group">
                                <label>Select Sample Lead</label>
                                <select name="sid" id="sid" class="form-control" required>
                                    <option value="">Select Sample</option>
                                    <?php echo sample_option_list($dbconnect);?>
                                </select>
    					</div>
                        <div class="form-group">
                                <label>Request From</label>
                                <select name="eid" id="eid" class="form-control" required>
                                    <option value="">Select Vender</option>
                                    <?php echo entity_option_list($dbconnect);?>
                                </select>
    					</div>
                        <div class="form-group">
    						<label>Enter Quantity</label>
							<input type="text" name="quantity" id="quantity" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" required />
                        </div>
                        <div class="form-group">
    						<label>Price/Unit</label>
							<input type="text" name="price" id="price" class="form-control" pattern="[+-]?([0-9]*[.])?[0-9]+" required />
                        </div>
                        <div class="form-group">
    						<label>Date Requested</label>
							<input type="date" name="daterequested" id="daterequested" value="<?php echo date("Y-m-d");?>" class="form-control" required />
                        </div>
                        <div class="form-group">
    						<label>Select Type</label>
							<select name="type" id="type" class="form-control" required>
                                <option value="">Select Type</option>
                        		<option value="Quote">Quote</option>
                        		<option value="P.O">P.O</option>
                        		<option value="Invoice">Invoice</option>
                        		<option value="Payment">Payment</option>
                            </select>
                        </div>
                        <div class="form-group">
    						<label>Est Deliver</label>
							<input type="date" name="estdeliver" id="estdeliver" value="" class="form-control"/>
                        </div>
                        <div class="form-group">
    						<label>Arrival Date</label>
							<input type="date" name="arrivaldate" id="arrivaldate" value="" class="form-control"/>
                        </div>
                        <div class="form-group">
    						<label>Payment Terms</label>
							<input type="text" name="paymentterm" id="paymentterm" class="form-control" />
                        </div>
                        <div class="form-group">
    						<label>Shipping Terms</label>
							<input type="text" name="shippingterm" id="shippingterm" class="form-control" />
                        </div>
                        <div class="form-group">
    						<label>Warranty Terms</label>
							<input type="text" name="warrantyterm" id="warrantyterm" class="form-control" />
                        </div>
                        
    				<div class="modal-footer">
    					<input type="hidden" name="srid" id="srid"/>
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
                "targets":[0,1,2,3,4,5,6,7,8,9,10],
                "orderable":false,
            },
        ],
        <?php
        }else{
        ?>
        "columnDefs":[
            {
                "targets":[0,1,2,3,4,5,6,7,8],
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
        $('#SampleRecordAddModal').modal('show');
        $('#samplerecord_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i> Add Project");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });*/

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

    $(document).on('click', '.update', function(){
    	// display hidden fields - update has 3 more fields than add
        var srid = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"samplerecord_action.php",
            method:"POST",
            data:{srid:srid, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#SampleRecordAddModal').modal('show');
            	$('.modal-title').html("<i class='fa fa-pencil-square-o'></i>Edit Record");
            	$('#srid').val(srid);
                $('#sid').val(data.sid);
                $('#eid').val(data.eid);
                $('#quantity').val(data.quantity);
            	$('#price').val(data.price);
            	$('#daterequested').val(data.daterequested);
            	$('#type').val(data.type);
            	$('#estdeliver').val(data.estdeliver);
            	$('#arrivaldate').val(data.arrivaldate);
            	$('#paymentterm').val(data.paymentterm);
            	$('#shippingterm').val(data.shippingterm);
            	$('#warrantyterm').val(data.warrantyterm);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
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