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
                            <h3 class="panel-title">Contact List</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                            <?php
                            if(($_SESSION['type'] == "Admin") || $_SESSION['type'] == "Manager"){
                            ?>
                             <button type="button" name="add" id="add_button" onclick="location.href='contact_add.php'" class="btn btn-success btn-xs">Add</button>   
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
                            <table id="contact_data" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Fax</th>
                                    <th>Website</th>
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
    <div id="ContactAddModal" class="modal fade">
        <div class="modal-dialog">
            <form method="POST" id="contact_form">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Project</h4>
                    </div>
                        
                    <div class="modal-body">
                        <div class="relation-group">
                            <label>Enter Name</label>
                            <input type="text" name="ecname" id="ecname" class="form-control" required />
                        </div>
                        <div class="relation-group">
                            <label>Enter Email</label>
                            <input type="email" name="ecemail" id="ecemail" class="form-control" required />
                        </div>
                        <div class="relation-group">
                            <label>Enter Phone</label>
                            <input type="text" name="ecphone" id="ecphone" class="form-control" required />
                        </div>
                        <div class="relation-group">
                            <label>Enter Fax</label>
                            <input type="text" name="ecfax" id="ecfax" class="form-control"  />
                        </div>
                        <div class="relation-group">
                            <label>Enter Website</label>
                            <input type="text" name="ecwebsite" id="ecwebsite" class="form-control"  />
                        </div>
                        <div class="relation-group">
                            <label>Enter Address 1</label>
                            <input type="text" name="ecaddress1" id="ecaddress1" class="form-control" required />
                        </div>
                        <div class="relation-group">
                            <label>Enter Address 2</label>
                            <input type="text" name="ecaddress2" id="ecaddress2" class="form-control"  />
                        </div>
                        <div class="relation-group">
                            <label>Enter City</label>
                            <input type="text" name="eccity" id="eccity" class="form-control"  />
                        </div>
                        <div class="relation-group">
                            <label>Enter State</label>
                            <input type="text" name="ecstate" id="ecstate" class="form-control"  />
                        </div>
                        <div class="relation-group">
                            <label>Enter Zipcode</label>
                            <input type="text" name="eczip" id="eczip" class="form-control"  />
                        </div>
                        <div class="relation-group">
                            <label>Enter Country</label>
                            <input type="text" name="eccountry" id="eccountry" class="form-control"  />
                        </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ecid" id="ecid"/>
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
    var dataTable = $('#contact_data').DataTable({
        "processing":true,
        "serverSide":true,
        "order":[],
        "ajax":{
            url:"contact_fetch.php",
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

    $(document).on('submit', '#contact_form', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"contact_action.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#contact_form')[0].reset();
                $('#ContactAddModal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                dataTable.ajax.reload();
            }
        })
    });
                        
    $(document).on('click', '.delete', function(){
        var ecid = $(this).attr("id");
        var btn_action = 'delete';
        var status = $(this).data("status");
        if(confirm("Are you sure you want to delete?" )){
            $.ajax({
                url:"contact_action.php",
                method:"POST",
                data:{ecid:ecid,btn_action:btn_action,status:status},
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



