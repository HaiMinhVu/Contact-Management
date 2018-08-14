<?php
include('dbconnect.php');
include('functions.php');
include('header.php');

?>
<span id="alert_action"></span>
			<div class="panel panel-default">
				<div class="panel-heading">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <div class="row">
                            <h3 class="panel-title"><font color="#2775F5">Add New Sample</font></h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                            <button type="button" name="back" id="back" class="btn btn-success btn-xs" onclick="window.history.back()">Back</button>	
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
				<div class="panel-body">
				<form method="POST" id="sample_add_form" enctype="multipart/form-data">
					<table id="add_sample" class="table table-bordered table-striped">
						<tr>
							<td width=14%>Sample Name</td>
							<td><input type="text" name="sname" id="sname" class="form-control" required /></td>
						</tr>
            			<tr>
							<td>Image</td>
							<td><input type="file" name="uploadimage" id="uploadimage" onchange="previewImage()"class="form-control"><br>
							<img id="previewim" src="" height="200" alt="Image preview..."></td>
						</tr>
						<tr>
							<td>Location</td>
							<td><input type="text" name="slocation" id="slocation" class="form-control" placeholder="place to store sample" /></td>
						</tr>
						<tr>
							<td>Description</td>
							<td><textarea rows="5" name="sdescription" id="sdescription" class="form-control" ></textarea></td>
						</tr>
						<tr>
							<td>Status</td>
							<td><select name="status" id="status" class="form-control" required>
                    			<option value="">Select Status</option>
                    			<option value="Active" selected>Active</option>
                        		<option value="InActive">InActive</option>
                    		</select></td>
						</tr>
					</table>
					<div style="text-align:center">
						<input type="submit" name="Add" id="Add" class="btn btn-info" value="Add" />
            			<input type="reset" name="reset" id="reset" class="btn btn-warning" value="Reset" />	
					</div>
				</form>
				</div>
			</div>

<script type="text/javascript">
function previewImage() {
  var preview = document.querySelector('#previewim');
  var file    = document.querySelector('#uploadimage').files[0];
  var reader  = new FileReader();

  reader.addEventListener("load", function () {
    preview.src = reader.result;
  }, false);

  if (file) {
    reader.readAsDataURL(file);
  }
}
</script>
<script>
$(document).ready(function(){

	$('#sample_add_form').submit(function(event){
        event.preventDefault();
        var data = new FormData(this);
    	data.append("action", "add");
        $.ajax({
           	type:"post",
           	url:"sample_action.php",
           	data:data,
           	contentType: false,
        	cache: false,
   			processData:false,
           	success: function(mess){
               	$('#alert_action').fadeIn().html('<div class="alert alert-info">'+mess+'</div>');
                window.setTimeout(function(){location.reload()},2000)
           	}
        });
    });
});
</script>

<?php
include ('footer.php');
?>