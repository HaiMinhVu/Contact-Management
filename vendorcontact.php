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
                            <h3 class="panel-title">Vendor Contact Relationship List</h3>
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
                            <table id="relation_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Vender Name</th>
                                    <th>Contact Name</th>
                                    <th>Title</th>
                                    <th>Email</th>
                                    <th>Phone</th>
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
    <div id="RelationAddModal" class="modal fade">
        <div class="modal-dialog">
            <form method="POST" id="relation_form">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Project</h4>
                    </div>
                        
                    <div class="modal-body">
                        <div class="relation-group">
                                <label>Select Vender</label>
                                <select name="eid" id="eid" class="form-control" required>
                                    <option value="">Select Vender</option>
                                    <?php echo entity_option_list($dbconnect);?>
                                </select>
                        </div>
                        <div class="relation-group">
                                <label>Select Contact</label>
                                <select name="ecid" id="ecid" class="form-control" required>
                                    <option value="">Select Contact</option>
                                    <?php echo contact_option_list($dbconnect);?>
                                </select>
                        </div>
                        <div class="relation-group">
                                <label>Select Priority</label>
                                <select name="priority" id="priority" class="form-control" required>
                                    <option value="">Select Priority</option>
                                    <option value="Primary Contact">Primary Contact</option>
                                    <option value="Alternative Contact">Alternative Contact</option>
                                </select>
                        </div>
                        <div class="relation-group">
                            <label>Enter Title</label>
                            <input type="text" name="erctitle" id="erctitle" class="form-control" required />
                        </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ercid" id="ercid"/>
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
    var dataTable = $('#relation_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"vendorcontact_fetch.php",
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
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });

    ////// Add new item to the table
    $('#add_button').click(function(){
        $('#RelationAddModal').modal('show');
        $('#relation_form')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i>Add Relationship");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

    $(document).on('submit', '#relation_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"vendorcontact_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#relation_form')[0].reset();
                $('#RelationAddModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                dataTable.ajax.reload();
            }
        })
    });
                        
    $(document).on('click', '.update', function(){
        // display hidden fields - update has 3 more fields than add
        var ercid = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"vendorcontact_action.php",
            method:"POST",
            data:{ercid:ercid, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#RelationAddModal').modal('show');
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i>Edit Relationship");
                $('#id').val(data.ercid);
                $('#eid').val(data.eid);
                $('#ecid').val(data.ecid);
                $('#priority').val(data.priority);
                $('#erctitle').val(data.erctitle);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var ercid = $(this).attr("id");
        var btn_action = 'delete';
        var status = $(this).data("status");
        if(confirm("Are you sure you want to delete?" )){
            $.ajax({
                url:"vendorcontact_action.php",
                method:"POST",
                data:{ercid:ercid,btn_action:btn_action,status:status},
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



